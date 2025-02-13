<?php
session_start();

// Function to log out a user
function logoutUser() {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();
}

// Check if the user clicked the logout button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"]) && $_POST["logout"] == 1) {
    logoutUser();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "sweatstudio";

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $loginUsername = $_POST["loginUsername"];
        $loginPassword = $_POST["loginPassword"];

        $query = "SELECT id, password, profile_picture FROM users WHERE username = :username";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $loginUsername, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user_id = $result['id'];
            $hashedPassword = $result['password'];
            $profile_picture = $result['profile_picture'];

            if (password_verify($loginPassword, $hashedPassword)) {
                // Set a cookie to remember the username for 7 days (adjust the time as needed)
                setcookie('remember_username', $loginUsername, time() + 60 * 60 * 24 * 7, '/');

                session_start();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['profile_picture'] = $profile_picture; // Set the profile picture in the session
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['login_error_message'] = "Incorrect username or password.";
            }
        } else {
            $_SESSION['login_error_message'] = "User not found.";
        }
    } catch (PDOException $e) {
        // Handle database connection or query errors
        $_SESSION['login_error_message'] = "Database error: " . $e->getMessage();
    } finally {
        // Close the database connection
        unset($pdo);
    }
}

// Retrieve the last remembered username from the cookie
$rememberedUsername = isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Logo.ico" type="image/x-icon">
    <title>Login</title>

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="background2">
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="navbar-logo">
            <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
        </div>
        <div class="links">
            <a href="about_us.php">About</a>
            <a href="trainer.php">Trainer</a>
            <a href="facilities.php">Facilities</a>
            <a href="classes.php">Classes</a>
            <a href="about_us.php#contactus">Contact</a>
            <?php
                if (isset($_SESSION['user_id'])) {
                    // Display the "Profile" link when the user is logged in
                    echo '<a href="profile.php">Profile</a>';
                }
            ?>
        </div>
        <div class="buttons">
            <?php
                if (isset($_SESSION['user_id'])) {
                    // User is logged in
                    // Display the user's profile picture and the logout button
                    echo '<a href="profile.php"><img src="' . $_SESSION['profile_picture'] . '" alt="Profile Picture" class="profile-image"></a>';
                    echo '<button id="logoutButton">Logout</button>';
                } else {
                    // User is not logged in, display login and signup buttons
                    echo '<a href="login.php" class="loginbtn">Login</a>';
                    echo '<a href="signup.php" class="signupbtn">Sign Up</a>';
                }
            ?>
        </div>
    </div>

    <!-- Login Form -->
    <div class="blank"></div>  
    <?php
    // Check if there's a login error message
    if (isset($_SESSION['login_error_message'])) {
        echo '<div class="login_error_message">' . $_SESSION['login_error_message'] . '</div>';
        // Clear the login error message from the session
        unset($_SESSION['login_error_message']);
    }
    ?>  
    <div class="loginform">
        <div class="left-column">
            <h1>Login</h1>
            <img src="img/form-decoration.png" alt="form-decoration">
        </div>
        <div class="right-column">
            <form action="login.php" method="POST">
                <div class="inputbox">
                        <label for="loginUsername">Username:</label>
                        <input type="text" name="loginUsername" id="loginUsername" required>
                </div>
                <div class="inputbox">
                    <label for="loginPassword">Password:</label>
                    <input type="password" name="loginPassword" id="loginPassword" required>
                </div>
                <div class="buttonrow">
                    <button type="submit" name="submit" value="login" class="form-loginbtn">LOGIN</button>
                    <a href="signup.php" class="form-signupbtn">Create an Account</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="relative-footer">
        <div class="info">
            <div class="footer-logo">
                <a href="index.php"><img src="img/logo2.png" alt="Logo"></a>
                <h4><i>"SweatStudio: Where Fitness Become A Lifestyle"</i></h4>
                <h5>&#10687;: No. 1, Jalan Studio, 47500 Subang Jaya, Selangor, Malaysia</h5>
                <h5>&#x1F57F;: +601-2345 6789</h5>
            </div>
            <div class="footer-links">
                <h4>Useful Links</h4>
                <a href="index.php">Home</a><br>
                <a href="about_us.php">About Us</a><br>
                <a href="facilities.php">Facilities</a><br>
                <a href="classes.php">Classes</a>
            </div>
            <div class="footer-info">
                <h4>More Info</h4>
                <a href="#">Terms of Service</a><br>
                <a href="#">Privacy Policy</a><br>
                <a href="about_us.php#contactus">Contact Us</a>
            </div>
            <div class="footer-intouch">
                <h4>Get In Touch</h4>
                <a href="#">Facebook</a><br>
                <a href="#">Instagram</a><br>
                <a href="#">Twitter</a><br>
                <a href="#">LinkedIn</a>
            </div>
        </div>
        <hr>
        <div class="copyright">
            <p>@2023 SweatStudio, All Right Reserved</p>
        </div>
    </footer>

    <!-- Include Bootstrap 5 JavaScript and Popper.js (Latest version) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript (at the bottom of your HTML file) -->
    <script>
        // Function to update the file name display
        document.getElementById('profile_picture').addEventListener('change', function() {
            var fileInput = document.getElementById('profile_picture');
            var fileNameDisplay = document.getElementById('file_name_display');

            // Check if a file is selected
            if fileInput.files.length > 0 {
                // Display the file name
                fileNameDisplay.innerText = fileInput.files[0].name;
            } else {
                // No file selected
                fileNameDisplay.innerText = "No file selected";
            }
        });
    </script>
    <!-- JavaScript for handling the logout -->
    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            // When the "Logout" button is clicked, submit a form to trigger the logout function
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'login.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'logout';
            input.value = '1';

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>
</html>
