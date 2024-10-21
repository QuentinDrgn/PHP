<?php
require '../app/Models/db.php'; // Include the database connection

$isLoggedIn = isset($_SESSION['username']); // Check if the user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : null;

// Check if the user is logged in as admin
$role = $_SESSION['role'] ?? null;

$userId = null;

// Fetch the user ID of the currently logged-in user
if ($isLoggedIn) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $userId = $user['id'];
        $isAdmin = false; // Not an admin
    } else {
        $stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin) {
            $userId = $admin['id'];
            $isAdmin = true; // Admin user
        }
    }
}

// Fetch personal information from the database if userId is set
$personalInfo = null; // Initialize variable
if ($userId) {
    $stmt = $pdo->prepare('SELECT * FROM personal_info WHERE id_user = ?'); // Assuming `id_user` references the user
    $stmt->execute([$userId]);
    $personalInfo = $stmt->fetch();
}

$styles = null;
if ($isLoggedIn) {
    if ($isAdmin) {
        // Admin user, query using admin_id
        $stmt = $pdo->prepare('SELECT * FROM style_settings WHERE admin_id = ?');
        $stmt->execute([$userId]);
    } else {
        // Regular user, query using user_id
        $stmt = $pdo->prepare('SELECT * FROM style_settings WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
    $styles = $stmt->fetch();
}

// Handle form submission and update the database (admin only)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $languages = $_POST['languages'];
    $interest = $_POST['interest'];
    $formation = $_POST['formation'];
    $profile = $_POST['profile'];
    $technologies = $_POST['technologies'];
    $profileDescription = $_POST['profileDescription'];

    // Update personal information in the database
    if ($personalInfo) {
        $stmt = $pdo->prepare('UPDATE personal_info SET name = ?, title = ?, email = ?, phone = ?, profile_description = ?, languages = ?, interest = ?, formation = ?, profile = ?, technologies = ? WHERE id_user = ?');
        $stmt->execute([$name, $title, $email, $phone, $profileDescription, $languages, $interest, $formation, $profile, $technologies, $userId]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO personal_info (id, id_user, name, title, email, phone, profile_description) VALUES (UUID(), ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$userId, $name, $title, $email, $phone, $profileDescription]);
    }
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
    <?php if ($styles): ?>
        <style>
            .boxImg,
            .boxName,
            .boxInfos,
            .boxSkills {
                border-color: <?= htmlspecialchars($styles['border']); ?>;
                border-width: 2px;
                border-style: solid;
            }

            .boxName h2 {
                color: <?= htmlspecialchars($styles['name_color']); ?>;
            }

            .boxName {
                background-color: <?= htmlspecialchars($styles['background1']); ?>;
            }

            .boxInfos {
                background-color: <?= htmlspecialchars($styles['background2']); ?>;
            }

            .boxSkills {
                background-color: <?= htmlspecialchars($styles['background3']); ?>;
            }

            .boxInfos u,
            boxInfos b {
                color: <?= htmlspecialchars($styles['title_color_left']); ?>;
            }

            .boxSkills u,
            .boxSkills b {
                color: <?= htmlspecialchars($styles['title_color_right']); ?>;
            }

            .boxSkills p {
                color: <?= htmlspecialchars($styles['p_color_R']); ?>;
            }

            .boxInfos p {
                color: <?= htmlspecialchars($styles['p_color_L']); ?>;
            }

            h3 {
                color: <?= htmlspecialchars($styles['subtitle_color']); ?>;
            }
        </style>
    <?php endif; ?>
</head>

<body>
    <nav>
        <a href="/">HOME</a>
        <a href="/curriculum">CV</a>
        <a href="/portfolio">PORTFOLIO</a>
        <a href="/login">LOGIN</a>
        <a href="/profil"><?php echo $isLoggedIn ? $username : 'GUEST'; ?></a>
        <?php if ($role == "admin") {
            echo '<a href="/admin">ADMIN</a>';
        } ?>
    </nav>
    <h1 id="title">CURRICULUM VITAE</h1>
    <?php if ($role == "admin" || $role == "user") {
        echo '<button id="editBtn">Edit Profile Info</button>';
        echo '<button id="editStyleBtn">Edit Style</button>';
    } ?>
    <div class="container">
        <!-- Header Section -->
        <div class="boxImg">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/036/594/092/small_2x/man-empty-avatar-photo-placeholder-for-social-networks-resumes-forums-and-dating-sites-male-and-female-no-photo-images-for-unfilled-user-profile-free-vector.jpg" alt="Profile Picture" class="profilPic">
        </div>
        <div class="boxName">
            <h2><?php echo $isLoggedIn ? ($personalInfo['name'] ?? 'John Doe') : 'John Doe'; ?></h2>
        </div>
        <div class="boxInfos">
            <b><u style="font-size: 32px">
                    Post
                </u></b>
            <p>______________</p>
            <b><u>
                    Contact
                </u></b>
            <p><?php echo $isLoggedIn ? ($personalInfo['email'] ?? 'admin@example.com') : 'admin@example.com'; ?></p>
            <p><?php echo $isLoggedIn ? ($personalInfo['phone'] ?? '00/00/00/00/00') : '00/00/00/00/00'; ?></p>
            <p>______________</p>
            <b><u>
                    Skills
                </u></b>
            <p><?php echo $isLoggedIn ? ($personalInfo['title'] ?? 'Admin Skills') : 'Admin Skills'; ?></p>
            <p>______________</p>
            <b><u>
                    Languages
                </u></b>
            <p><?php echo $isLoggedIn ? ($personalInfo['languages'] ?? 'English') : 'Edit your profile to see your informations'; ?></p>
            <p>______________</p>
            <b><u>Interests</u></b>
            <p><?php echo $isLoggedIn ? ($personalInfo['interest'] ?? 'Music | Science') : 'Edit your profile to see your informations'; ?></p>
        </div>

        <!-- Profile Section -->
        <div class="boxSkills">
            <section class="formation">
                <u>
                    <h2>Formation</h2>
                </u>
                <p><?php echo $isLoggedIn ? ($personalInfo['formation'] ?? 'Edit your profile to see your informations') : 'Edit your profile to see your informations'; ?></p>
            </section>

            <section class="experience">
                <u>
                    <h2>Expérience</h2>
                </u>
                <div class="job">
                    <h3>Stage Développeur Web</h3>
                    <p><?php echo $isLoggedIn ? ($personalInfo['profile'] ?? 'Edit your profile to see your informations') : 'Edit your profile to see your informations'; ?></p>
                </div>
            </section>

            <section class="profile">
                <u>
                    <h2>Profile</h2>
                </u>
                <p><?php echo $isLoggedIn ? ($personalInfo['profile_description'] ?? 'I am a passionate web developer with experience in creating dynamic websites and applications.') : 'I am a passionate web developer with experience in creating dynamic websites and applications.'; ?></p>
            </section>

            <section class="technologies">
                <u>
                    <h2>Technologies</h2>
                </u>
                <p><?php echo $isLoggedIn ? ($personalInfo['technologies'] ?? 'Edit your profile to see your informations') : 'Edit your profile to see your informations'; ?></p>

                <section class="projects">
                    <u>
                        <h2>My Projects</h2>
                    </u>
                    <b><a href="/portfolio">
                            <p>Click here to see my projects!</p>
                        </a></b>
                </section>
            </section>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Personal Information</h2>
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $isLoggedIn ? ($personalInfo['name'] ?? 'John Doe') : 'John Doe'; ?>" required>

                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $isLoggedIn ? ($personalInfo['title'] ?? 'Admin Skills') : 'Admin Skills'; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $isLoggedIn ? ($personalInfo['email'] ?? 'admin@example.com') : 'admin@example.com'; ?>" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $isLoggedIn ? ($personalInfo['phone'] ?? '00/00/00/00/00') : '00/00/00/00/00'; ?>" required>

                    <label for="languages">Languages:</label>
                    <input type="text" id="languages" name="languages" value="<?php echo $isLoggedIn ? ($personalInfo['languages'] ?? 'English') : 'English'; ?>" required>

                    <label for="interest">Interests:</label>
                    <input type="text" id="interest" name="interest" value="<?php echo $isLoggedIn ? ($personalInfo['interest'] ?? 'Music | Science') : 'Music | Science'; ?>" required>

                    <label for="formation">Formation:</label>
                    <textarea id="formation" name="formation" required><?php echo $isLoggedIn ? ($personalInfo['formation'] ?? 'Edit your profile to see your informations') : 'Edit your profile to see your informations'; ?></textarea>

                    <label for="profile">Profile:</label>
                    <textarea id="profile" name="profile" required><?php echo $isLoggedIn ? ($personalInfo['profile'] ?? 'Edit your profile to see your informations') : 'Edit your profile to see your informations'; ?></textarea>

                    <label for="technologies">Technologies:</label>
                    <textarea id="technologies" name="technologies" required><?php echo $isLoggedIn ? ($personalInfo['technologies'] ?? 'Edit your profile to see your informations') : 'Edit your profile to see your informations'; ?></textarea>

                    <label for="profileDescription">Profile Description:</label>
                    <textarea id="profileDescription" name="profileDescription" required><?php echo $isLoggedIn ? ($personalInfo['profile_description'] ?? 'I am a passionate web developer with experience in creating dynamic websites and applications.') : 'I am a passionate web developer with experience in creating dynamic websites and applications.'; ?></textarea>

                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </div>
        <div id="myModalStyle" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Style</h2>
                <form method="POST" action="/saveStyle">
                    <label for="background1">Background Color1:</label>
                    <input type="color" id="background1" name="background1" value="<?php echo $isLoggedIn ? ($styles['background1'] ?? '#D1D1D1') : '#D1D1D1'; ?>" required>
                    <div class="color-preview" id="previewBackground1"></div>

                    <p>_____________________________</p>

                    <label for="background2">Background Color2:</label>
                    <input type="color" id="background2" name="background2" value="<?php echo $isLoggedIn ? ($styles['background2'] ?? '#D1D1D1') : '#D1D1D1'; ?>" required>
                    <div class="color-preview" id="previewBackground2"></div>

                    <p>_____________________________</p>

                    <label for="background3">Background Color3:</label>
                    <input type="color" id="background3" name="background3" value="<?php echo $isLoggedIn ? ($styles['background3'] ?? '#D1D1D1') : '#D1D1D1'; ?>" required>
                    <div class="color-preview" id="previewBackground3"></div>

                    <p>_____________________________</p>

                    <label for="leftTitle">Left Titles color:</label>
                    <input type="color" id="titleLeft" name="titletLeft" value="<?php echo $isLoggedIn ? ($styles['title_color_left'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewTitleLeft"></div>

                    <p>_____________________________</p>

                    <label for="rightTitle">Right Titles color:</label>
                    <input type="color" id="titleRight" name="titleRight" value="<?php echo $isLoggedIn ? ($styles['title_color_right'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewTitleRight"></div>

                    <p>_____________________________</p>

                    <label for="border">Border Color:</label>
                    <input type="color" id="border" name="border" value="<?php echo $isLoggedIn ? ($styles['border'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewBorder"></div>

                    <p>_____________________________</p>

                    <label for="leftParagraph">Left Paragraph Color:</label>
                    <input type="color" id="paragraphLeft" name="paragraphLeft" value="<?php echo $isLoggedIn ? ($styles['p_color_L'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewParagraphLeft"></div>

                    <p>_____________________________</p>

                    <label for="rightParagraph">Right Paragraph Color:</label>
                    <input type="color" id="paragraphRight" name="paragraphRight" value="<?php echo $isLoggedIn ? ($styles['p_color_R'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewParagraphRight"></div>

                    <p>_____________________________</p>

                    <label for="name">Name Color:</label>
                    <input type="color" id="nameColor" name="nameColor" value="<?php echo $isLoggedIn ? ($styles['name_color'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewNameColor"></div>

                    <p>_____________________________</p>

                    <label for="subtitle">Subtitle Color:</label>
                    <input type="color" id="subtitle" name="subtitle" value="<?php echo $isLoggedIn ? ($styles['subtitle_color'] ?? '#00000') : '#00000'; ?>" required>
                    <div class="color-preview" id="previewSubtitle"></div>

                    <button type="submit" id="saveStyleBtn">Apply Style</button>
                </form>
            </div>
        </div>

    </div>

    <footer>
        <h4>&copy; 2024 PORTFOLIO / CV | <a href="/contact" id="contact">CONTACT US</a></h4>
    </footer>

    <script>
        // Get modal and elements
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];
        var editStyleBtn = document.getElementById("editStyleBtn");

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Get modal and elements
        var modalStyle = document.getElementById("myModalStyle");
        var spanStyle = document.getElementsByClassName("close")[1];

        // When the user clicks the button, open the modal
        editStyleBtn.onclick = function() {
            modalStyle.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanStyle.onclick = function() {
            modalStyle.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modalStyle) {
                modalStyle.style.display = "none";
            }
        }

        // Add this script to your existing <script> section
        // Add this script to your existing <script> section
        document.querySelectorAll('input[type="color"]').forEach(input => {
            const previewId = 'preview' + input.id.charAt(0).toUpperCase() + input.id.slice(1); // Generate the preview element's ID
            const previewElement = document.getElementById(previewId);

            // Set initial preview color
            previewElement.style.backgroundColor = input.value;

            // Change preview color on input change
            input.addEventListener('input', function() {
                previewElement.style.backgroundColor = this.value;
            });
        });
    </script>
</body>

</html>