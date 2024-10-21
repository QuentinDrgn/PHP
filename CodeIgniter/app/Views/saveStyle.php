<?php
require '../app/Models/db.php'; // Include the database connection


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

    // Get the posted data
    $background1 = $_POST['background1'];
    $background2 = $_POST['background2'];
    $background3 = $_POST['background3'];
    $title_color_left = $_POST['titletLeft'];
    $title_color_right = $_POST['titleRight'];
    $border = $_POST['border'];
    $paragraphLeft = $_POST['paragraphLeft'];
    $paragraphRight = $_POST['paragraphRight'];
    $nameColor = $_POST['nameColor'];
    $subTitleColor = $_POST['subtitle'];

    // Check if styles already exist in the database for the user or admin
    if ($userId) {
        $stmt = $pdo->prepare('SELECT * FROM style_settings WHERE user_id = ?');
        $stmt->execute([$userId]);
    } else if ($adminId) {
        $stmt = $pdo->prepare('SELECT * FROM style_settings WHERE admin_id = ?');
        $stmt->execute([$adminId]);
    }

    $styleSetting = $stmt->fetch();

    if ($styleSetting) {
        // Update existing style settings
        if ($userId) {
            $stmt = $pdo->prepare('UPDATE style_settings SET background1 = ?, background2 = ?, background3 = ?, title_color_left = ?, border = ?, p_color_L = ?, p_color_R = ?, name_color = ?, title_color_right = ?, subtitle_color = ? WHERE user_id = ?');
            $stmt->execute([$background1, $background2, $background3, $title_color_left, $border, $paragraphLeft, $paragraphRight, $nameColor, $title_color_right, $subTitleColor, $userId]);
        } else if ($adminId) {
            $stmt = $pdo->prepare('UPDATE style_settings SET background1 = ?, background2 = ?, background3 = ?, title_color_left = ?, border = ?, p_color_L = ?, p_color_R = ?, name_color = ?, title_color_right = ?, subtitle_color = ? WHERE admin_id = ?');
            $stmt->execute([$background1, $background2, $background3, $title_color_left, $border, $paragraphLeft, $paragraphRight, $nameColor, $title_color_right, $subTitleColor, $adminId]);
        }
    } else {
        // Insert new style settings
        if ($userId) {
            $stmt = $pdo->prepare('INSERT INTO style_settings (user_id, background1, background2, background3, title_color_left, title_color_right, p_color_L, p_color_R, subtitle_color, name_color, border) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$userId, $background1, $background2, $background3, $title_color_left, $title_color_right, $paragraphLeft, $paragraphRight, $subTitleColor, $nameColor, $border]);
        } else if ($adminId) {
            $stmt = $pdo->prepare('INSERT INTO style_settings (admin_id, background1, background2, background3, title_color_left, title_color_right, p_color_L, p_color_R, subtitle_color, name_color, border) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$adminId, $background1, $background2, $background3, $title_color_left, $title_color_right, $paragraphLeft, $paragraphRight, $subTitleColor, $nameColor, $border]);
        }
    }

    // Redirect to the profile page
    header('Location: /curriculum');
}
