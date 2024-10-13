<?php
// index.php in the public directory

session_start();
require '../app/Models/db.php'; // Include the database connection

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : null;

$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string if exists
$requestUri = strtok($requestUri, '?');

// Define your routes
switch ($requestUri) {
    case '/':
        echo '<link rel="stylesheet" href="CSS/style.css">';
        echo '<nav>
                <a href="/">HOME</a>
                <a href="/curriculum">CV</a>
                <a href="/portfolio">PORTFOLIO</a>
                <a href="/login">LOGIN</a>
                <a href="/profil">'. ($isLoggedIn ? htmlspecialchars($username) : 'GUEST') . '</a>
            </nav>';
        echo '<h1>WELCOME TO PORTFOLIO / CV</h1>';
        echo '<p>Welcome to My Portfolio and CV! Hello and thank you for visiting! I am excited to share my professional journey and creative work with you. This platform is designed to showcase my skills, experiences, and the projects I am passionate about.

Here, you will find my detailed CV highlighting my educational background, work history, and key accomplishments. I invite you to explore my portfolio, where I display a collection of my best work that reflects my dedication and creativity in [your field, e.g., web development, graphic design, etc.].

Whether you are a potential employer, a fellow professional, or simply curious about my work, I hope you find inspiration and insight as you navigate through my projects. If you have any questions or would like to connect, please dont hesitate to reach out.</p>';
        echo '<footer>
                <h4>&copy; 2021 PORTFOLIO / CV</h4>
            </footer>';
        break;

    case '/curriculum':
        // Correct path using __DIR__
        $filePath = __DIR__ . '/../app/Views/curriculum.php';
        if (file_exists($filePath)) {
            include $filePath; // Include the curriculum.php file
        } else {
            echo '<h1>File not found: ' . htmlspecialchars($filePath) . '</h1>';
        }
        break;

    case '/portfolio':
        $filePath = __DIR__ . '/../app/Views/portfolio.php';
        if (file_exists($filePath)) {
            include $filePath; // Include the portfolio.php file
        } else {
            echo '<h1>File not found: ' . htmlspecialchars($filePath) . '</h1>';
        }
        break;

    case '/login':
        $filePath = __DIR__ . '/../app/Views/login.php';
        if (file_exists($filePath)) {
            include $filePath; // Include the login.php file
        } else {
            echo '<h1>File not found: ' . htmlspecialchars($filePath) . '</h1>';
        }
        break;

    case '/profil':
        $filePath = __DIR__ . '/../app/Views/profil.php';
        if (file_exists($filePath)) {
            include $filePath; // Include the profil.php file
        } else {
            echo '<h1>File not found: ' . htmlspecialchars($filePath) . '</h1>';
        }
        break;

    default:
        echo '<h1>404 Not Found</h1>';
        break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
    </header>
</body>
</html>
