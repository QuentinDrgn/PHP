<?php

require '../app/Models/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // First, check if the user exists in the users table
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // If not a user, check if they are an admin
    if (!$user) {
        $stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
    }

    // Determine whether to use user_id or admin_id
    $userId = $user['id'] ?? null;
    $adminId = $admin['id'] ?? null;

    $username = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    if ($userId) {
        $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, phone = ?, password = ? WHERE id = ?');
        $stmt->execute([$username, $email, $phone, $password, $userId]);
    } else if ($adminId) {
        $stmt = $pdo->prepare('UPDATE admins SET username = ?, email = ?, phone = ?, password = ? WHERE id = ?');
        $stmt->execute([$username, $email, $phone, $password, $adminId]);
    }

    header('Location:/profil');
    exit;
}
