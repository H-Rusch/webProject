<?php

interface GuideDAO {

    /**
     * Prepare the registration of a new user.
     * The parameter 'key' must be used with registerUser_complete,
     * to confirm and complete the registration
     */
    function registerUser_start(string $key, string $username, string $encoded_password, string $email): int;

    /** Confirm and complete the registration of a new user. See registerUser_start. */
    function registerUser_complete(string $key): int;

    /** Login a user, if the given username and password belong to an existing user. */
    function login($username, $password);

    /* Get all of the guides in the database, ordered, so that the most recently edited gudies are shown first.
    Can be passed an optional parameter which limits the amount of guides gotten. */
    function getGuides($offsetTimes = null);

    /* Get a guide-object identified by it's ID. */
    function getGuide($id);

    /* Get all guides written by a specific user. */
    function getGuidesForUser($userID);

    /* Search through the title, author-name, tags, category and guideText of a guide.
    Order the results by the amount of hits.
    An optional userID can be given, to only search through entries for that specific user.
    An optional offset can be given, to limit the amount of guides returned while reloading. */
    function searchGuide($search, $userID = null, $offsetTimes = null);

    /* Sort a selection of guides based on a filter. Method used when Javascript is diabled. */
    function sortGuides($guides, $filter);

    /* Create a new guide in the database. Also save the corresponding tags. */
    function createGuide($author, $trackID, $title, $category, $text, $lastEdit, $tags);

    /* Update a guide with the new information given. */
    function updateGuide($guideID, $trackID, $title, $category, $text, $lastEdit, $tags);

    /* Delete a guide specified by it's ID. Also delete all of its tags, ratings, likes, dislikes. */
    function deleteGuide($guideID);

    /* Like a guide. Delete dislikes by that user for that specific guide. */
    function likeGuide($userID, $guideID);

    /* Dislike a guide. Delete likes by that user for that specific guide. */
    function dislikeGuide($userID, $guideID);
}
