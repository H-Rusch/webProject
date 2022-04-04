<?php
include_once "classUser.php";
include_once "classGuide.php";
include_once "GuideDAO.php";

class DBGuideDAO implements GuideDAO {

    private $offset = 5;

    function __construct() {
        $this->createDBIfNotExists();
    }

    function connect(): PDO {
        // get path to directory in order to find the database file
        $db = "sqlite:" . __DIR__ . "/database.db";
        $pdo = new PDO($db, "root", null);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // activate use of foreign key constraints
        $pdo->exec('PRAGMA foreign_keys = ON;');

        return $pdo;
    }

    /*
     * return codes
     *  - 0: success
     *  - 1: username taken
     *  - 2: email taken
     */
    function registerUser_start(string $key, string $username, string $encoded_password, string $email): int {
        $db = $this->connect();
        $db->beginTransaction();

        /* check that the users information is still not taken */
        $get_username_conflict_count_command = $db->prepare("SELECT count(*) FROM User WHERE username = ?;");
        if ($get_username_conflict_count_command->execute([$username]) === false) {
            return -1;
        }
        $username_conflicts = $get_username_conflict_count_command->fetch(PDO::FETCH_ASSOC);
        if ($username_conflicts["count(*)"] > 0) {
            return 1;
        }

        $get_email_conflict_count_command = $db->prepare("SELECT count(*) FROM User WHERE email = ?;");
        if ($get_email_conflict_count_command->execute([$email]) === false) {
            return -1;
        }
        $email_conflicts = $get_email_conflict_count_command->fetch(PDO::FETCH_ASSOC);
        if ($email_conflicts["count(*)"] > 0) {
            return 2;
        }

        /* insert information into 'RegisteringUser' table */
        $insert_new_user_command = $db->prepare("INSERT INTO RegisteringUser (key, username, encoded_password, email) VALUES (?, ?, ?, ?);");
        if ($insert_new_user_command->execute([$key, $username, $encoded_password, $email]) === false) {
            return -1;
        }

        $db->commit();
        return 0;
    }

    /*
     * return codes
     *  - -1: unexpected error
     *  - 0: success
     *  - 1: unknown key
     *  - 2: username taken
     *  - 3: email taken
     */
    function registerUser_complete(string $key): int {
        $db = $this->connect();
        $db->beginTransaction();

        /* load the users information into $user_data */
        $get_user_data_command = $db->prepare("SELECT username, encoded_password, email FROM RegisteringUser WHERE key = ?;");
        if ($get_user_data_command->execute([$key]) === false) {
            return -1;
        }
        $user_data = $get_user_data_command->fetch(PDO::FETCH_ASSOC);
        if ($user_data === false) {
            return 1;
        }

        /* check that the users information is still not taken */
        $get_username_conflict_count_command = $db->prepare("SELECT count(*) FROM User WHERE username = ?;");
        if ($get_username_conflict_count_command->execute([$user_data["username"]]) === false) {
            return -1;
        }
        $username_conflicts = $get_username_conflict_count_command->fetch(PDO::FETCH_ASSOC);
        if ($username_conflicts["count(*)"] > 0) {
            return 2;
        }

        $get_email_conflict_count_command = $db->prepare("SELECT count(*) FROM User WHERE email = ?;");
        if ($get_email_conflict_count_command->execute([$user_data["email"]]) === false) {
            return -1;
        }
        $email_conflicts = $get_email_conflict_count_command->fetch(PDO::FETCH_ASSOC);
        if ($email_conflicts["count(*)"] > 0) {
            return 3;
        }

        /* upgrade (move) user from 'RegisteringUser' to 'User' */
        $insert_new_user_command = $db->prepare("INSERT INTO User (username, password, email) VALUES (?, ?, ?);");
        if ($insert_new_user_command->execute([$user_data["username"], $user_data["encoded_password"], $user_data["email"]]) === false) {
            return -1;
        }

        $delete_pending_requests_for_email_command = $db->prepare("DELETE FROM RegisteringUser WHERE email = ?");
        if ($delete_pending_requests_for_email_command->execute([$user_data["email"]]) === false) {
            return -1;
        }

        $db->commit();
        return 0;
    }

    function login($username, $password): array {
        $db = $this->connect();
        $errors = [];

        // get all users with matching username
        $sql = "SELECT * FROM User WHERE username = ?;";
        $command = $db->prepare($sql);
        $command->execute([$username]);

        // if a user with the fitting username is found and the given password is correct, the user is logged in
        $user = $command->fetchObject();
        if (empty($user) || !password_verify($password, $user->password)) {
            $errors[] = "Die Eingabe ist ungültig.";
        } else {
            $_SESSION["userID"] = $user->userID;
            // Set a token to prevent CSRF attacks
            $_SESSION["token"] = uniqid();
        }

        $db = null;
        return $errors;
    }

    function getGuides($offsetTimes = null): array {
        try {
            $db = $this->connect();
            $result = [];

            $sql = "SELECT *
                    FROM Guide JOIN Track ON Guide.trackID = Track.trackID 
                    ORDER BY lastEdit DESC ";

            $executeParams = [];
            if (isset($offsetTimes)) {
                $sql .= "LIMIT ? OFFSET ?;";
                $offset = $this->offset * $offsetTimes;
                $executeParams = [$this->offset, $offset];
            }

            $command = $db->prepare($sql);
            $command->execute($executeParams);

            $result = $command->fetchAll();
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $result;
        }
    }

    function sortGuides($guides, $filter): array {
        $db = $this->connect();
        $guideIDs = [];
        $result = [];
        foreach ($guides as $guide) {
            $guideIDs[] = $guide["guideID"];
        }
        // Set as many placeholders as there are given guides
        $placeholders = implode(',', array_fill(0, count($guides), '?'));

        // only allow specified values, so no SQL-injection is possible in the folowing statement
        if (!($filter==="lastEdit") && !($filter==="category")){
            return $result;
        }

        $sql = "SELECT * FROM GUIDE 
                JOIN Track ON Guide.trackID = Track.trackID
                WHERE guideID IN ($placeholders)
                ORDER BY $filter";
        $command = $db->prepare($sql);
        $command->execute($guideIDs);
        $result = $command->fetchAll();

        $db = null;
        return $result;
    }

    // Sort guides used by Javascript
    function sortGuidesBy($guideIDs = null, $filter="category"): array {
        try {
            $db = $this->connect();
            $result = [];

            if (!($filter==="lastEdit") && !($filter==="category")){
                return $result;
            }
            if ($filter=="lastEdit") {
                $rang = "DESC";
            } else {
                $rang = "ASC";
            }

            // Set as many placeholders as there are show guides
            $placeholders = implode(',', array_fill(0, count($guideIDs), '?'));

            $sql = "SELECT *
                    FROM Guide JOIN Track on Guide.trackID = Track.trackID
                    WHERE guideID IN ($placeholders)
                    ORDER BY $filter $rang";
            $command = $db->prepare($sql);

            foreach($guideIDs as $index => $ID) {
                $command->bindValue($index +1, $ID);
            }
            $command->execute();

            $result = $command->fetchAll();
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $result;
        }
    }

    function getGuide($id) {
        $db = $this->connect();
        $db->beginTransaction();

        $sql = "SELECT * FROM GUIDE WHERE guideID = ?";
        $command = $db->prepare($sql);
        $command->execute([$id]);
        $result = $command->fetch();
        if (!$result) {
            // no guide was found, therefore return null and don't search for further information
            $guide = null;

        } else {
            $tags = $this->getTags($id);
            $dislikeCount = $this->getDislikes($id);
            $likeCount = $this->getLikes($id);
    
            $guide = new classGuide($result["guideID"], $result["userID"], $result["trackID"], $result["title"], $result["category"],
                 $result["guideText"], $result["lastEdit"], $tags, $dislikeCount, $likeCount);
        }
        
        $db->commit();
        $db = null;
        return $guide;
    }

    /* Get the tags for a specific guide which is specified by it's ID. */
    private function getTags($guideID) : array {
        $db = null;
        try{
            $db = $this->connect();
            $result = [];

            $sql = "SELECT tag FROM GuideTags WHERE guideID = ?";
            $command = $db->prepare($sql);
            $command->execute([$guideID]);

            $result= $command->fetchAll();
        } catch(Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
            $db->rollBack();
        } finally {
            $db = null;
            return $result;
        }
    }

    function getGuidesForUser($userID, $offsetTimes = null) : array {

        try {
            $db = $this->connect();
            $result = [];
            $executeParameters = [$userID];

            $sql = "SELECT * FROM Guide
                    JOIN Track ON Guide.trackID = Track.trackID
                    WHERE userID = ?
                    ORDER BY lastEdit DESC ";

            if (isset($offsetTimes)) {
                $sql .= "LIMIT ? OFFSET ?;";
                $executeParameters[] = $this->offset;
                $executeParameters[] = $this->offset * $offsetTimes;
            }
            $command = $db->prepare($sql);
            $command->execute($executeParameters);

            $result = $command->fetchAll();
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $result;
        }
    }

    // Source for the foundation of the statement: https://www.codeproject.com/Articles/141478/How-to-Create-a-Relevance-Based-Search-Query-for-S
    function searchGuide($search, $userID = null, $offsetTimes = null): array {

        try {
            $db = $this->connect();
            $result = [];

            // set additional sql logic based on the given parameters
            $userWhere = (isset($userID) ? " WHERE b.userID = :userID " : "");
            $limiting = (isset($offsetTimes) ? " LIMIT :limit OFFSET :offset " : "");

            $sql = "SELECT b.guideID, title, category, trackName 
                    FROM    (
                            SELECT  guideID,
                                    Count(*) as occurence
                            FROM    (
                                    SELECT guideID
                                    FROM   Guide
                                    WHERE  lower(title) LIKE :search 
                                        UNION ALL
                                    SELECT guideID
                                    FROM   Guide g0 JOIN user u ON g0.userID = u.userID
                                    WHERE  lower(u.username) LIKE :search
                                        UNION ALL
                                    SELECT guideID
                                    FROM   GuideTags
                                    WHERE  lower(tag) LIKE :search
                                        UNION ALL
                                    SELECT guideID
                                    FROM   Guide g1 JOIN Track ga ON g1.trackID = ga.trackID
                                    WHERE  lower(ga.trackName) LIKE :search 
                                        OR lower(ga.trackName) LIKE :search
                                        UNION ALL
                                    SELECT guideID
                                    FROM   Guide
                                    WHERE  lower(category) LIKE :search
                                        UNION ALL
                                    SELECT guideID
                                    FROM   Guide
                                    WHERE  lower(guideText) LIKE :search
                            )
                            GROUP BY guideID
                    ) a
                    JOIN Guide b ON a.guideID = b.guideID
                    JOIN Track c ON b.trackID = c.trackID
                    $userWhere
                    ORDER BY occurence DESC, lastEdit DESC
                    $limiting;";
            $command = $db->prepare($sql);
            // bind values for optional parameters
            if (isset($userID)) {
                $command->bindParam(":userID", $userID);
            }
            if (isset($offsetTimes)) {
                $command->bindValue(":limit", $this->offset);
                $command->bindValue(":offset", $offsetTimes * $this->offset);
            }
            $command->bindValue(":search", "%" . strtolower($search) . "%");
            $command->execute();

            $result = $command->fetchAll();
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $result;
        }
    }

    function createGuide($author, $trackID, $title, $category, $text, $lastEdit, $tags): array {
        $db = null;
        try {
            $db = $this->connect();
            $errors = [];
            $db->beginTransaction();

            $sql = "INSERT INTO Guide (userID, trackID, title, category, guideText, lastEdit) VALUES (?, ?, ?, ?, ?, ?)";
            $command = $db->prepare($sql);
            $command->execute([$author, $trackID, $title, $category, $text, $lastEdit]);

            $sql = "SELECT guideID FROM Guide ORDER BY guideID DESC LIMIT 1;";
            $command = $db->prepare($sql);
            $command->execute();
            $rowID = $command->fetch();

            foreach ($tags as $tag) {
                $sql = "INSERT INTO GuideTags (guideID, tag) VALUES (?, ?)";
                $command = $db->prepare($sql);
                $command->execute([$rowID[0], $tag]);
            }
            $db->commit();

        } catch (Exception $ex) {
            echo "Fehler:" . $ex->getMessage() . "<br />";
            $errors["exception"] = $ex->getMessage();
            $db->rollBack();
        } finally {
            $db = null;
            return $errors;
        }
    }

    function updateGuide($guideID, $trackID, $title, $category, $text, $lastEdit, $tags) {
        $db= $this->connect();
        // no explicit rollback, because PDO does it automatically, when the end of a script is reached and
        // there are still open transactions
        $db->beginTransaction();

        $sql = "SELECT guideID from Guide WHERE guideID = :guideID";
        $command = $db->prepare($sql);
        $command->execute([':guideID' => $guideID]);
        $fetchedGuideID = $command->fetch();

        if (!isset($fetchedGuideID[0])) {
            $db->rollback();
            return "Jemand kam dir zuvor und hat den Guide gelöscht.";
        }

        $sql = "UPDATE GUIDE SET trackID = ?, title = ?, category = ?, guideText = ?, lastEdit = ?
                WHERE guideID = ? AND userID = ?";
        $command = $db->prepare($sql);
        $command->execute(array($trackID, $title, $category, $text, $lastEdit, $guideID, $_SESSION["userID"]));

        $sql = "DELETE FROM GuideTags where guideID = :guideID";
        $command = $db->prepare($sql);
        $command->execute([':guideID' => $guideID]);

        foreach ($tags as $tag) {
            $sql = "INSERT INTO GuideTags (guideID, tag) VALUES (?, ?)";
            $command = $db->prepare($sql);
            $command->execute([$guideID, $tag]);
        }

        $db->commit();
        return true;
    }

    function deleteGuide($guideID) {
        $db = $this->connect();
        // no explicit rollback, because PDO does it automatically, when the end of a script is reached and
        // there are still open transactions
        $db->beginTransaction();

        $sql = "DELETE FROM Guide WHERE guideID = '$guideID'";
        $command = $db->prepare($sql);
        $command->execute();

        $db->commit();
    }

    function getTrackIdByName($track_name) {
        $db = $this->connect();
        $command = $db->prepare("SELECT trackID FROM Track WHERE trackName = :track_name");
        $command->execute([':track_name' => $track_name]);
        $response = $command->fetch();
        if (isset($response['trackID'])) {
            return $response['trackID'];
        } else {
            return null;
        }
    }

    /* Get the display and track name for a specific track. */
    function getTrackNamesForTrack($trackID) {
        try {
            $db = $this->connect();

            $sql = "SELECT trackName
                    FROM Track 
                    WHERE trackID = :trackID";
            $command = $db->prepare($sql);
            $command->execute([':trackID' => $trackID]);
            $trackNames = $command->fetch();
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $trackNames;
        }
    }

    /* Get the display and track name for all the tracks which are currently supported in the database. */
    function getAllTrackNames() {
        try {
            $db = $this->connect();

            $sql = "SELECT trackName
                    FROM Track";

            $trackNames = $db->query($sql);
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $trackNames;
        }
    }

    /* Checks wether a username is already taken by another user. */
    function isUsernameTaken($username) {

        try {
            $db = $this->connect();

            $sql = "SELECT * FROM User WHERE username = ?;";
            $command = $db->prepare($sql);
            $command->execute([$username]);

            return count($command->fetchAll()) == 1;
        } catch (PDOException $e) {
            echo "Fehler: " . $e->getMessage() . "<br/>";
        } finally {
            $db = null;
        }
    }

    /* Get the username for a user specified by the user's ID. */
    function getUsername($userID) {

        try {
            $db = $this->connect();

            $sql = "SELECT username 
                    FROM User 
                    WHERE userID = :userID";
            $command = $db->prepare($sql);
            $command->execute([':userID' => $userID]);
            $username = $command->fetch();
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
        } finally {
            $db = null;
            return $username;
        }
    }

    
    function likeGuide($userID, $guideID) {
        $db = $this->connect();
        $db->beginTransaction();

        $sql = "SELECT COUNT(dislikedID) FROM DislikedGuides WHERE userID = ? AND guideID = ?";
        $command = $db->prepare($sql);
        $command->execute([$userID, $guideID]);
        $guideDisliked = $command->fetch();

        if($guideDisliked[0] != 0) {
            $sql = "DELETE FROM DislikedGuides WHERE userID = ? AND guideID = ?";
            $command = $db->prepare($sql);
            $command->execute([$userID, $guideID]);
        }

        $sql = "SELECT COUNT(likedID) FROM LikedGuides WHERE UserID = ? AND guideID = ?";
        $command = $db->prepare($sql);
        $command->execute([$userID, $guideID]);
        $guideLiked = $command->fetch();

        if($guideLiked[0] == 0) {
            $sql = "INSERT INTO LikedGuides (userID, guideID) VALUES (?,?)";
            $command = $db->prepare($sql);
            $command->execute([$userID, $guideID]);
        }

        $db->commit();
        $db = null;
    }

    // get the count of likes for a guide
    private function getLikes($guideID) {
        try {
            $db = $this->connect();

            $sql = "SELECT COUNT(userID) FROM LikedGuides where guideID = :guideID";
            $command = $db->prepare($sql);
            $command->execute(['guideID' => $guideID]);
            $likes = $command->fetch()[0];
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
            $likes = 0;
        } finally {
            $db = null;
            return $likes;
        }
    }

    function dislikeGuide($userID, $guideID) {
        $db = $this->connect();
        $db->beginTransaction();

        $sql = "SELECT COUNT(likedID) FROM likedGuides WHERE userID = ? AND guideID = ?";
        $command = $db->prepare($sql);
        $command->execute([$userID, $guideID]);
        $guideLiked = $command->fetch();

        if($guideLiked[0] != 0) {
            $sql = "DELETE FROM likedGuides WHERE userID = ? AND guideID = ?";
            $command = $db->prepare($sql);
            $command->execute([$userID, $guideID]);
        }

        $sql = "SELECT COUNT(dislikedID) FROM DislikedGuides WHERE UserID = ? AND guideID = ?";
        $command = $db->prepare($sql);
        $command->execute([$userID, $guideID]);
        $guideDisLiked = $command->fetch();

        if($guideDisLiked[0] == 0) {
            $sql = "INSERT INTO DislikedGuides (userID, guideID) VALUES (?,?)";
            $command = $db->prepare($sql);
            $command->execute([$userID, $guideID]);
        }
        
        $db->commit();
        $db = null;
    }

    /* Get the count of dislikes for a guide. */
    private function getDislikes($guideID) {
        try {
            $db = $this->connect();

            $sql = "SELECT COUNT(userID) FROM DislikedGuides where guideID = :guideID";
            $command = $db->prepare($sql);
            $command->execute(['guideID' => $guideID]);
            $dislikes = $command->fetch()[0];
        } catch (Exception $ex) {
            echo "Fehler: " . $ex->getMessage() . "<br />";
            $dislikes = 0;
        } finally {
            $db = null;
            return $dislikes;
        }
    }

    /** Create database file and create tables */
    function createDBIfNotExists(): void {
        $file = __DIR__ . "/database.db";
        if (!file_exists($file)) {
            $db = $this->connect();

            $sql = "CREATE TABLE IF NOT EXISTS User (
                        userID      INTEGER PRIMARY KEY, 
                        username    Text Not Null,
                        email       Text Not Null, 
                        password    Text Not Null
                    ); ";
            $db->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS RegisteringUser (
                        key               Text PRIMARY KEY,
                        username          Text Not Null,
                        encoded_password  Text Not Null,
                        email             Text Not Null
                    );";
            $db->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS Track (
                        trackID         Integer Primary Key,
                        trackName       Text Not Null
                    ); ";
            $db->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS Guide (
                        guideID     Integer Primary Key,
                        userID      Integer Not Null,
                        trackID     Integer Not Null,
                        title       Text Not Null,
                        category    Text Not Null, 
                        guideText   Text Not Null,
                        lastEdit    Date Not Null,

                        Foreign Key (userID) References User (userID) ON DELETE CASCADE,
                        Foreign Key (trackID) References Track (trackID) ON DELETE CASCADE
                    ); ";
            $db->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS LikedGuides (
                        likedID     Integer Primary Key,
                        userID      Integer Not Null,
                        guideID     Integer Not Null,
                        
                        Foreign Key (userID) References User (userID) ON DELETE CASCADE,
                        Foreign Key (guideID) References Guide (guideID) ON DELETE CASCADE
                    ); ";
            $db->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS DislikedGuides (
                        dislikedID  Integer Primary Key,
                        userID      Integer Not Null,
                        guideID     Integer Not Null,
                        
                        Foreign Key (userID) References User (userID) ON DELETE CASCADE,
                        Foreign Key (guideID) References Guide (guideID) ON DELETE CASCADE
                    ); ";
            $db->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS GuideTags (
                        tagID       Integer Primary Key,
                        guideID     Integer Not Null,
                        tag         Text Not Null,

                        Foreign Key (guideID) References Guide (guideID) ON DELETE CASCADE
                    ); ";
            $db->exec($sql);

            $this->insertInitialValues();
        }
    }

    /** Fill tables with initial values. */
    private function insertInitialValues(): void {
        $db = $this->connect();

        $encoded = password_hash("a1234", PASSWORD_DEFAULT);
        $sql = "INSERT INTO User (username, email, password) VALUES
                    ('test1', 'test1@test.de', '$encoded'),
                    ('test2', 'test2@test.de', '$encoded'), 
                    ('test3', 'test3@test.de', '$encoded');";
        $db->exec($sql);

        $sql = "INSERT INTO Track (trackName) VALUES
            ('Mario Kart Stadium'),
            ('Water Park'),
            ('Sweet Sweet Canyon'),
            ('Thwomp Ruins'),
            ('Mario Circuit'),
            ('Toad Harbour'),
            ('Twisted Mansion'),
            ('Shy Guy Falls'),
            ('Sunshine Airport'),
            ('Dolphin Shoals'),
            ('Electrodome'),
            ('Mount Wario'),
            ('Cloudtop Cruise'),
            ('Bone Dry Dunes'),
            ('Bowsers Castle'),
            ('Rainbow Road'),
            ('Moo Moo Meadows (Wii)'),
            ('Mario Circuit (GBA)'),
            ('Cheep Cheep Beach (DS)'),
            ('Toads Turnpike (N64)'),
            ('Dry Dry Desert (GCN)'),
            ('Donut Plains 3 (SNES)'),
            ('Royal Raceway (N64)'),
            ('DK Jungle (3DS)'),
            ('Wario Stadium (DS)'),
            ('Sherbet Land (GCN)'),
            ('Melody Motorway (3DS)'),
            ('Yoshi Valley (N64)'),
            ('Tick-Tock Clock (DS)'),
            ('Piranha Plant Pipeway (3DS)'),
            ('Grumble Volcano (Wii)'),
            ('Rainbow Road (N64)');";
        $db->exec($sql);

$text1 =
"# Die große Acht 
## Strategie
Fahre als erster über die Ziellinie-";

$text2 =
"Baue für den shroomless Shortcut einen Super-Miniturbo auf. Drifte mit diesem auf den Sand, 
löse ihn dann aus und hüpfe zwei mal. Wenn du gegen nichts gegen fährst hast du ihn geschafft.";

$text3 =
"# Strategie
Sei **schnell**. Danach hast du einen Pokal";

$text4 =
"text4";

$text5 =
"text5";

$text6 =
"text6";

        $lastEdit = time();
        $sql = "INSERT INTO Guide (userID, trackID, title, category, guideText, lastEdit) VALUES
                    (1, 5, 'Die große Acht', 'online', ?, ?),
                    (1, 1, 'Shroomless Shortcut', 'time-trial', ?, ?),
                    (3, 26, 'Juhuu so schnell', 'time-trial', ?, ?),
                    (1, 1, 'Mein erster Guide', 'online', ?, ?),
                    (2, 31, 'Weltrekordhalter mit diesen 10 einfachen Tricks', 'time-trial', ?, ?),
                    (2, 15, 'Becher? Nach diesem Guide eher Pokal', 'online', ?, ?);";
        $command = $db->prepare($sql);
        $command->execute([$text1, $lastEdit, $text2, $lastEdit, $text3, $lastEdit, $text4, $lastEdit, $text5, $lastEdit, $text6, $lastEdit]);

        $sql = "INSERT INTO GuideTags (guideID, tag) VALUES
                (1, 'Parsedown'), (1, 'cool'), (1, 'Mario'),
                (2, 'Parsedown'), (2, 'Mario'), (2, 'SC'),
                (3, 'pokal'), (3, 'gewinnen'), (3, 'champion'), (3, 'weltmeister');";
        $db->exec($sql);
     }
}
