<?php
$referralLink = isset($_SESSION["userID"]) ? "./user-page.php" : "./login.php";
$referralText = isset($_SESSION["userID"]) ? "Nutzer" : "Login";
?>

<nav class="topnav">
    <input type="checkbox" id="hamburg">
    <label for="hamburg" class="hamburg">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
        Hamburger Button
    </label>
<nav class="menu">
    <a href="./home.php">Home</a>
    <a href="./guide-overview.php">Guides</a>
    <a href=<?php echo $referralLink; ?>><?php echo $referralText; ?></a>
</nav>
</nav>
