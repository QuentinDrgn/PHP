<?php
require '../app/Models/db.php'; // Include the database connection

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : null;

// Initialize error messages
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; // Get the action 

    // Check which action to perform
    if ($action == 'createUser') {
        // Handle createUser
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        try {
            // Prepare the SQL query to insert the new user
            $stmt = $pdo->prepare('INSERT INTO users (id, username, email, password, phone) VALUES (UUID(), ?, ?, ?, ?)');
            $stmt->execute([$username, $email, $password, $phone]);
            header("Location: /admin"); // Redirect after successful creation
            exit; // Exit to prevent further execution
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // 23000 is the error code for duplicate entry
                $errorMessage = 'Error: The username or email already exists. Please choose another.';
            } else {
                $errorMessage = 'Error: ' . $e->getMessage(); // General error message
            }
        }
    } elseif ($action == 'createAdmin') {
        // Handle createAdmin
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        try {
            // Prepare the SQL query to insert the new admin
            $stmt = $pdo->prepare('INSERT INTO admins (id, username, email, password, phone) VALUES (UUID(), ?, ?, ?, ?)');
            $stmt->execute([$username, $email, $password, $phone]);
            header("Location: /admin"); // Redirect after successful creation
            exit; // Exit to prevent further execution
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // 23000 is the error code for duplicate entry
                $errorMessage = 'Error: The username or email already exists. Please choose another.';
            } else {
                $errorMessage = 'Error: ' . $e->getMessage(); // General error message
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Space between the two columns */
        }
        .form-container {
            flex: 1; /* Allow both forms to grow equally */
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
        }
        .form-title {
            padding: 10px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-content {
            display: none; /* Initially hide the form content */
            padding: 10px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        footer {
            margin-top: 20px;
            text-align: center;
        }
        .arrow {
            transition: transform 0.3s;
        }
        .arrow.open {
            transform: rotate(90deg); /* Rotate arrow when opened */
        }
    </style>
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

    <h1>ADMIN</h1>

    <div class="container">
        <section class="form-container">
            <div class="form-title" onclick="toggleForm('userForm')">
                <span>CREATE USER</span>
                <span class="arrow" id="userFormArrow">➔</span> <!-- Arrow indicator -->
            </div>
            <div class="form-content" id="userForm">
                <?php if ($errorMessage): ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <form id="createUserForm" action="" method="POST">
                    <input type="hidden" name="action" value="createUser"> <!-- Hidden field for action -->
                    <label for="userName">USERNAME:</label>
                    <input type="text" id="userName" name="username" required>
                    <label for="userEmail">EMAIL:</label>
                    <input type="email" id="userEmail" name="email" required>
                    <label for="userPassword">PASSWORD:</label>
                    <input type="password" id="userPassword" name="password" required>
                    <label for="phone">PHONE:</label>
                    <input type="text" id="phone" name="phone" required>
                    <button type="submit" value="createUser" id="submitBtn">CREATE USER</button>
                </form>
            </div>
        </section>

        <section class="form-container">
            <div class="form-title" onclick="toggleForm('adminForm')">
                <span>CREATE ADMIN</span>
                <span class="arrow" id="adminFormArrow">➔</span> <!-- Arrow indicator -->
            </div>
            <div class="form-content" id="adminForm">
                <?php if ($errorMessage): ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <form id="createAdminForm" action="" method="POST">
                    <input type="hidden" name="action" value="createAdmin"> <!-- Hidden field for action -->
                    <label for="adminName">USERNAME:</label>
                    <input type="text" id="adminName" name="username" required>
                    <label for="adminEmail">EMAIL:</label>
                    <input type="email" id="adminEmail" name="email" required>
                    <label for="adminPassword">PASSWORD:</label>
                    <input type="password" id="adminPassword" name="password" required>
                    <label for="phone">PHONE:</label>
                    <input type="text" id="phone" name="phone" required>
                    <button type="submit" value="createAdmin" id="submitBtn">CREATE ADMIN</button>
                </form>
            </div>
        </section>
    </div>

    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV <u><a href="/contact" id="contact">CONTACT US</a></h4></u></h4>
    </footer>

    <script>
    function toggleForm(formId) {
        // Get all form content elements
        const allForms = document.querySelectorAll('.form-content');
        const formContent = document.getElementById(formId);
        const arrow = document.getElementById(formId + 'Arrow');

        // Hide all forms first
        allForms.forEach(form => {
            if (form !== formContent) {
                form.style.display = 'none';
                form.previousElementSibling.querySelector('.arrow').classList.remove('open'); // Close other arrows
            }
        });

        // Toggle the current form
        if (formContent.style.display === 'none' || formContent.style.display === '') {
            formContent.style.display = 'block';
            arrow.classList.add('open'); // Add open class for rotation
        } else {
            formContent.style.display = 'none';
            arrow.classList.remove('open'); // Remove open class for rotation
        }
    }
</script>
</body>

</html>
