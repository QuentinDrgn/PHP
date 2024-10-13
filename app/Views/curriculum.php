<?php
require '../app/Models/db.php'; // Include the database connection

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : null;

// Check if the user is logged in as admin
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

$userId = null;

// Fetch the user ID of the currently logged-in user
if ($isLoggedIn) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Check if a user was found and assign the user ID
    if ($user) {
        $userId = $user['id'];
    } else {
        // Handle the case where no user was found
        echo "User not found!";
        exit; // Or redirect
    }
}

// Fetch personal information from the database if userId is set
$personalInfo = null; // Initialize variable
if ($userId) {
    $stmt = $pdo->prepare('SELECT * FROM personal_info WHERE id_user = ?'); // Assuming `id_user` references the user
    $stmt->execute([$userId]);
    $personalInfo = $stmt->fetch();
}

// Handle form submission and update the database (admin only)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $profileDescription = $_POST['profileDescription'];

    // Update personal information in the database
    $stmt = $pdo->prepare('UPDATE personal_info SET name = ?, title = ?, email = ?, phone = ?, profile_description = ? WHERE id_user = ?');
    $stmt->execute([$name, $title, $email, $phone, $profileDescription, $userId]);

    // Redirect to the CV page to reflect the changes
    header("Location: /curriculum");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="CSS/curriculum.css">
</head>

<body>
    <nav>
        <a href="/">HOME</a>
        <a href="/curriculum">CV</a>
        <a href="/portfolio">PORTFOLIO</a>
        <a href="/login">LOGIN</a>
        <a href="/profil"><?php echo $isLoggedIn ? htmlspecialchars($username) : 'GUEST'; ?></a>
    </nav>';
    <h1 id="title">CURRICULUM VITAE</h1>
    <button id="editBtn">Edit</button>
    <div class="container">
        <!-- Header Section -->
        <div class="boxImg"><img src="https://static.vecteezy.com/system/resources/thumbnails/036/594/092/small_2x/man-empty-avatar-photo-placeholder-for-social-networks-resumes-forums-and-dating-sites-male-and-female-no-photo-images-for-unfilled-user-profile-free-vector.jpg" alt="Profile Picture" class="profilPic"></div>
        <div class="boxName">
            <h2><?php echo $personalInfo['name']; ?></h2>
            <p>Professional Profil</p>
        </div>
        <div class="boxInfos">
            <b><u>
                    <p style="font-size: 32px" ;>Post</p>
                </u></b>
            <p>______________</p>
            <b><u>
                    <p>Contact</p>
                </u></b>
            <p><?php echo $personalInfo['email']; ?> </p>
            <p><?php echo $personalInfo['phone']; ?></p>
            <p>______________</p>
            <b><u>
                    <p>Skills</p>
                </u></b>
            <p><?php echo $personalInfo['title']; ?></p>
            <p>______________</p>
            <b><u>
                    <p>Languages</p>
                </u></b>
            <p>- English</p>
            <P>- French</P>
            <p>______________</p>
            <b><u>Interests</u></b>
            <p>- Music</p>
            <p>- Travel</p>
            <p>- Photography</p>
            <p>- Science</p>

        </div>
        <!-- Profile Section -->
        <div class="boxSkills">

            <section class="formation">
                <u>
                    <h2>Formation</h2>
                </u>
                <p>2019 - 2021 : Ynov Campus - Bachelor Informatique</p>
                <p>2017 - 2019 : Lycée Jean Monnet - Baccalauréat Scientifique</p>
            </section>

            <section class="experience">
                <u>
                    <h2>Expérience</h2>
                </u>
                <div class="job">
                    <h3>Stage Développeur Web</h3>
                    <p>Ynov Campus | 2020 - 2021</p>
                    <ul>
                        <li>Création de sites web dynamiques</li>
                        <li>Optimisation des performances des sites</li>
                        <li>Travail en équipe sur des projets</li>
                    </ul>
                </div>
            </section>


            <section class="profile">
                <u>
                    <h2>Profile</h2>
                </u>
                <p><?php echo $personalInfo['profile_description']; ?></p>
            </section>

            <section class="technologies">
                <u>
                    <h2>Technologies</h2>
                </u>
                <ul>
                    <li>HTML, CSS, JavaScript</li>
                    <li>Node.js, Express.js</li>
                    <li>React, Angular</li>
                    <li>SQL, MongoDB</li>
                    <li>Git, GitHub</li>
                </ul>

                <section class="projects">
                    <u>
                        <h2>My projetcs</h2>
                    </u>
                    <b><a href="/portfolio">
                            <p>Click here to see my projects!</p>
                        </a></b>
                </section>
        </div>
        <!-- Modal for updating personal information (visible only for admin) -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Personal Information</h2>
                    <form method="POST" action="">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $personalInfo['name']; ?>" required>

                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="<?php echo $personalInfo['title']; ?>" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $personalInfo['email']; ?>" required>

                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $personalInfo['phone']; ?>" required>

                        <label for="profileDescription">Profile Description:</label>
                        <textarea id="profileDescription" name="profileDescription" required><?php echo $personalInfo['profile_description']; ?></textarea>

                        <input type="submit" value="Save Changes">
                    </form>
                </div>
            </div>
    </div>
    <footer>
        <h4>&copy; 2021 PORTFOLIO / CV</h4>
    </footer>

    <script>
        // Get modal and elements
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

        // Open the modal when the edit button is clicked
        if (btn) {
            btn.onclick = function() {
                modal.style.display = "block";
            }
        }

        // Close the modal when the 'x' is clicked
        if (span) {
            span.onclick = function() {
                modal.style.display = "none";
            }
        }

        // Close the modal if the user clicks outside the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>