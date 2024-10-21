<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $fromEmail = $_POST['email'];
    $message = $_POST['message'];

    // Validate email and message
    if (filter_var($fromEmail, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        $toEmail = 'test@example.com'; // Your destination email (MailHog)
        $subject = 'Contact Form Message';
        $headers = 'From: ' . $fromEmail;

        // Sanitize message
        $message = htmlspecialchars($message);

        // Send email
        if (mail($toEmail, $subject, $message, $headers)) {
            echo "<p>Message sent successfully!</p>";
        } else {
            // Debugging output
            echo "<p>Failed to send the message. Error: " . error_get_last()['message'] . "</p>";
        }
    } else {
        echo "<p>Invalid email or message.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/contact.css">
    <title>Contact Us</title>
</head>
<body>
    <header>
        <nav>
            <a href="/">HOME</a>
            <a href="/curriculum">CV</a>
            <a href="/portfolio">PORTFOLIO</a>
            <a href="/login">LOGIN</a>
            <a href="/profil">GUEST</a>
            <a href="/admin">ADMIN</a>
        </nav>
    </header>

    <main>
        <h1>CONTACT US</h1>
        <form action="/contact" method="POST" id="emailForm">
            <label for="email">YOUR EMAIL:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">YOUR MESSAGE:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit" id="sendMailBtn">SEND</button>
        </form>
    </main>
    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV</h4>
    </footer>
</body>
</html>
