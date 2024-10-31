<?php

require '../app/Models/db.php';

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$userId = $_SESSION['userId'] ?? null;

// Check if the user is logged in as admin
$role = $_SESSION['role'] ?? null;

if ($isLoggedIn && $role == "admin") {
    // Prepare the SQL query to fetch the admin by id
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
    $stmt->execute([$userId]);
    $admin = $stmt->fetch();

    $username = $admin['username'];
    $password = $admin['password'];
    $email = $admin['email'];
    $phone = $admin['phone'];
} else if ($isLoggedIn) {
    // Prepare the SQL query to fetch the user by id
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    $username = $user['username'];
    $password = $user['password'];
    $email = $user['email'];
    $phone = $user['phone'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/profil.css">
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
            <?php if ($role == "admin") {
                echo '<a href="/admin">ADMIN</a>';
            }
            echo '</nav>';
            ?>
        </nav>';
    </header>
    <h1> PROFIL</h1>
    <?php if ($role != "admin" && $role != "user") {
        echo '<h2>Please Sign up or log in to see your informations and use our features !</h2>';
        echo '<button class="loginBtn"><a href="/login">LOGIN</a></button>';
        echo '<footer>
        <h4 id="footerGuest">&copy; 2021 PORTFOLIO / CV</h4>
        </footer>';
        exit;
    } ?>
    <form method="POST" action="/logout">
        <button type="submit" id="logoutBtn">LOGOUT</button>
    </form>
    <div class="profil">
        <form method="POST" action="/editProfil" id="profilForm">
            <input type="hidden" name="action" value="editProfil">
            <input type="text" name="name" value="<?php echo $username; ?>">
            <input type="password" name="password" placeholder="Password..">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
            <input type="number" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>">
            <button type="submit" id="saveBtn">SAVE</button>
        </form>
    </div>
    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV | <u><a href="/contact" id="contact">CONTACT US</a></h4></u>h4>
    </footer>
</body>
</html>