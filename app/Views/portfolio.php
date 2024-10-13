<?php
session_start();
require '../app/Models/db.php'; // Include the database connection

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/portfolio.css">
    <title>Document</title>
</head>
<body>
    <header>
        <nav>
            <a href="/">HOME</a>
            <a href="/curriculum">CV</a>
            <a href="/portfolio">PORTFOLIO</a>
            <a href="/login">LOGIN</a>
            <a href="/profil"><?php echo $isLoggedIn ? htmlspecialchars($username) : 'GUEST'; ?></a>
        </nav>';
    </header>
    <h1> PORTFOLIO</h1>
    <footer>
        <h4>&copy; 2021 PORTFOLIO / CV</h4>
    </footer>
</body>
</html>