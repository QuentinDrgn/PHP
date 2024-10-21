<?php
require '../app/Models/db.php'; // Include the database connection

// Check if the user is logged in and set variables
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : null;

$role = $_SESSION['role'] ?? null;
$userId = $_SESSION['userId'] ?? null;

if ($isLoggedIn && $role == "user") {
    // Fetch projects where user_id matches the current user's userId
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE user_id = ?');
    $stmt->execute([$userId]);
} else {
    // Fetch all projects if not logged in or no specific role
    $stmt = $pdo->query('SELECT * FROM projects');
}

// Fetch the projects
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <?php if ($role == "admin") {
                echo '<a href="/admin">ADMIN</a>';
            }
            echo '</nav>';
            ?>
        </nav>
    </header>
    <h1> PORTFOLIO</h1>
    <h2> Welcome to my portfolio page. Here you can find all the projects I have worked on. </h2>
    <?php if ($role == "admin" || $role == "user") {
        echo '<button id="addBtn">Add Project</button>';
    } else {
        echo '<h3>Please Sign up or log in to see your informations and use our features !</h3>';
    }?>
    
    <div class="carousel">
        <div class="carousel-inner">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <div class="carousel-item card">
                        <h4><u>Titre:</u>  <?php echo htmlspecialchars($project['title']); ?></h4>
                        <p><u>Description:</u>  <?php echo htmlspecialchars($project['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </div>
        <button class="carousel-control prev" onclick="prevSlide()">❮</button>
        <button class="carousel-control next" onclick="nextSlide()">❯</button>
    </div>
    <div class="modal" id="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="/saveProject" method="POST" id="formProject">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
                <button type="submit" id="addBtnModal">Add Project</button>
            </form>
        </div>
    </div>
    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV | <a href="/contact" id="contact">CONTACT US</a></h4>
    </footer>
</body>
<script>
    let currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;

        // Ensure the index is within bounds
        if (index >= totalSlides) {
            currentSlide = 0; // Loop to the first slide
        } else if (index < 0) {
            currentSlide = totalSlides - 1; // Loop to the last slide
        } else {
            currentSlide = index;
        }

        // Calculate the translateX value for the carousel-inner
        const offset = -currentSlide * 100; // Each slide takes 100% width
        document.querySelector('.carousel-inner').style.transform = `translateX(${offset}%)`;
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Show the first slide on load
    showSlide(currentSlide);

    // Modal
    const modal = document.getElementById('modal');
    const addBtn = document.getElementById('addBtn');
    const closeBtn = document.querySelector('.close');

    addBtn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

</html>