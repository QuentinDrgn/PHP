<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>
    <header>
        <nav>
            <a href="/">HOME</a>
            <a href="/curriculum">CV</a>
            <a href="/portfolio">PORTFOLIO</a>
            <a href="/login">LOGIN</a>
            <a href="/profil"><?php echo $isLoggedIn ? $username : 'GUEST'; ?></a>
            <?php if ($role == "admin") {
                echo '<a href="/admin">ADMIN</a>';
            }
            echo '</nav>';
            ?>
        </nav>
    </header>
    <h1> ADMIN</h1>
    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV</h4>
    </footer>
</body>

</html>