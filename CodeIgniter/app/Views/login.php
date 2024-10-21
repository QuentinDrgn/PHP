<?php
require '../app/Models/db.php'; // Include the database connection

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; // Get the action (login or signup)

    if ($action == 'login') {
        // Handle login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the SQL query to fetch the user by username
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // If the admin user is found, verify the password
        if ($admin && password_verify($password, $admin['password'])) {
            // Set session for admin user
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            // Redirect to the CV page
            header("Location:/admin");
            exit;
        } elseif ($user && password_verify($password, $user['password'])) {
            // Set session for the regular user
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $user['id'];
            $_SESSION['role'] = 'user';
            // Redirect to the CV page  
            header("Location:/curriculum");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } elseif ($action == 'signup') {
        // Handle signup
        $username = $_POST['txt'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        // Prepare the SQL query to insert the new user
        $stmt = $pdo->prepare('INSERT INTO users (id, username, email, phone, password) VALUES (UUID(), ?, ?, ?, ?)');
        $stmt->execute([$username, $email, $phone, $password]);

        $name = "louis";
        $title = "Acr";
        $personalInfo = "test";

        // Get the ID of the newly created user
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $id_user = $stmt->fetchColumn();

        $stmt = $pdo->prepare('INSERT INTO personal_info (id, id_user, name, title, email, phone, profile_description) VALUES (UUID(), ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$id_user, $name, $title, $email, $phone, $personalInfo]);

        // Set session for the newly signed-up user
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';
        // Redirect to the CV page
        header("Location:/curriculum");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
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
        </nav>
    </header>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">SIGN UP</label>
                <input type="hidden" name="action" value="signup">
                <input type="text" name="txt" placeholder="Username" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="number" name="phone" placeholder="Phone" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button type="submit" value="Signup">SIGN UP</button>
            </form>
        </div>

        <div class="login">
            <form method="POST" action="" id="login">
                <label for="chk" aria-hidden="true">LOGIN</label>
                <input type="hidden" name="action" value="login">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required="">
                <button type="submit" value="Login">LOGIN</button>
            </form>
        </div>
    </div>
    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV | <a href="/contact" id="contact">CONTACT US</a></h4>
    </footer>
</body>

</html>