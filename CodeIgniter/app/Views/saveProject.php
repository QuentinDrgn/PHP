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

    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($userId) {
        $stmt = $pdo->prepare('INSERT INTO projects (id, user_id, title, description) VALUES (UUID(), ?, ?, ?)');
        $stmt->execute([$userId, $title, $description]);
    } else if ($adminId) {
        $stmt = $pdo->prepare('INSERT INTO projects (id, admin_id, title, description) VALUES (UUID(), ?, ?, ?)');
        $stmt->execute([$adminId, $title, $description]);
    }

    header('Location:/portfolio');
    exit;
}