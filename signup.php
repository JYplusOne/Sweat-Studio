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
    // Perform input validation
    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
        $_SESSION['signup_error_message'] = "All fields are required.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error_message'] = "Valid email is required.";
    } elseif (strlen($_POST["password"]) < 8) {
        $_SESSION['signup_error_message'] = "Password must be at least 8 characters.";
    } elseif (!preg_match("/[a-z]/i", $_POST["password"])) {
        $_SESSION['signup_error_message'] = "Password must contain at least one letter.";
    } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
        $_SESSION['signup_error_message'] = "Password must contain at least one number.";
    } else {
        // Hash the password
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Database connection parameters (please configure these)
        $host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "sweatstudio";

        try {
            // Create a PDO connection
            $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_username, $db_password);

            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the username is already registered
            $check_username_query = "SELECT id FROM users WHERE username = :username";
            $check_stmt = $pdo->prepare($check_username_query);
            $check_stmt->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
            $check_stmt->execute();
            $existing_username_count = $check_stmt->rowCount();
            $check_stmt->closeCursor();

            if ($existing_username_count > 0) {
                $_SESSION['signup_error_message'] = "Username is already taken. Please choose a different one.";
            } else {
                // File upload code
                if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                    // File upload is successful, process it
                    $file = $_FILES['profile_picture'];

                    // Define the directory where you want to store uploaded files (current directory)
                    $uploadDir = './user_profile_picture/';

                    // Ensure the directory exists, create it if not
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    // Generate a unique name for the uploaded file to prevent overwriting
                    $uploadFile = $uploadDir . basename($file['name']);

                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                        // File uploaded successfully, and $uploadFile contains the file's path
                    } else {
                        // Handle the case when the file could not be moved
                        $_SESSION['signup_error_message'] = "File upload failed.";
                    }
                }

                if (!isset($_SESSION['signup_error_message'])) {
                    // Insert data into the database
                    $insert_query = "INSERT INTO users (username, password, email, first_name, last_name, phone_number, age, profile_picture) 
                                    VALUES (:username, :password, :email, :firstName, :lastName, :phoneNumber, :age, :profilePicture)";
                    $stmt = $pdo->prepare($insert_query);
                    $stmt->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
                    $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
                    $stmt->bindParam(':firstName', $_POST["firstName"], PDO::PARAM_STR);
                    $stmt->bindParam(':lastName', $_POST["lastName"], PDO::PARAM_STR);
                    $stmt->bindParam(':phoneNumber', $_POST["phoneNumber"], PDO::PARAM_STR);
                    $stmt->bindParam(':age', $_POST["age"], PDO::PARAM_INT);
                    $stmt->bindParam(':profilePicture', $uploadFile, PDO::PARAM_STR);
                    
                    if ($stmt->execute()) {
                        // After the successful account creation, set a session variable with the success message
                        $_SESSION['success_message'] = "Account Created Successfully! You will be redirected to the login page in 3 seconds.";
                        header("refresh:3;url=login.php"); // Redirect to login page after 3 seconds
                    } else {
                        $_SESSION['signup_error_message'] = "Error: " . $stmt->errorInfo()[2];
                    }
                    $stmt->closeCursor();
                }
            }
        } catch (PDOException $e) {
            // Handle database connection or query errors
            $_SESSION['signup_error_message'] = "Database error: " . $e->getMessage();
        } finally {
            // Close the database connection
            unset($pdo);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Logo.ico" type="image/x-icon">
    <title>Sign Up</title>

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
                    echo '<form method="post" action="index.php" style="display: inline;">
                            <input type="hidden" name="logout" value="1">
                            <button type="submit" button id="logoutButton">Logout</button>
                          </form>';
                } else {
                    // User is not logged in, display login and signup buttons
                    echo '<a href="login.php" class="loginbtn">Login</a>';
                    echo '<a href="signup.php" class="signupbtn">Sign Up</a>';
                }
            ?>
        </div>
    </div>

    <!--Sign Up Form-->
    <div class="blank"></div>  
    <?php
        // Check if a success message exists in the session
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
            // Clear the session variable to avoid showing the message again on page refresh
            unset($_SESSION['success_message']);
        }

        // Check if a signup error message exists
        if (isset($_SESSION['signup_error_message'])) {
            echo '<div class="signup_error_message">' . $_SESSION['signup_error_message'] . '</div>';
            // Clear the signup error message from the session
            unset($_SESSION['signup_error_message']);
        }
    ?>
    <div class="signupform">
        <div class="left-column">
            <h1>Sign Up</h1>
            <img src="img/form-decoration.png" alt="form-decoration">
        </div>
        <div class="right-column">
            <form action="signup.php" method="POST" enctype="multipart/form-data">
                <div class="input-row">
                    <div class="inputbox">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="inputbox">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                </div>
                <div class="input-row">
                    <div class="inputbox">
                        <label for="firstName">First Name:</label>
                        <input type="text" name="firstName" id="firstName">
                    </div>
                    <div class="inputbox">
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" id="lastName">
                    </div>
                </div>
                <div class="input-row">
                    
                    <div class="inputbox">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="inputbox">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="tel" name="phoneNumber" id="phoneNumber" required>
                    </div>
                </div>
                <div class="input-row">
                    <div class="inputbox">
                        <label for="age">Age:</label>
                        <input type="text" name="age" id="age" required>
                    </div>
                    <div class="inputbox">
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/jpg, image/jpeg, image/png">
                    </div>
                </div>
                <div class="buttonrow">
                    <button type="submit" name="submit" value="register now" class="form-signupbtn">SIGN UP</button>
                    <a href="login.php" class="form-loginbtn">Login with Existing Account</a>
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

    <!-- JavaScript-->
    <script>
    // Function to update the file name display
    document.getElementById('profile_picture').addEventListener('change', function() {
        var fileInput = document.getElementById('profile_picture');
        var fileNameDisplay = document.getElementById('file_name_display');

        // Check if a file is selected
        if (fileInput.files.length > 0) {
            // Display the file name
            fileNameDisplay.innerText = fileInput.files[0].name;
        } else {
            // No file selected
            fileNameDisplay.innerText = "No file selected";
        }
        });
    </script>
    <script>
    // Function to redirect to login.php after 3 seconds
    function redirectToLogin() {
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 3000); // 3000 milliseconds (3 seconds)
    }

    // Check if the success message exists, and if so, display it and trigger the redirection
    var successMessage = document.querySelector('.success-message');
    if (successMessage) {
        successMessage.style.display = 'block';
        redirectToLogin();
    }
    </script>

</body>
</html>