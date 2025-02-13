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
    // Redirect to the home page
    header("Location: index.php");
    exit;
}

// Retrieve the class_id from the URL
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "sweatstudio";

try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch class-specific information based on $class_id from the database
        $sql = "SELECT c.title, c.price, c.class_type, c.class_picture, c.description, c.date_time, c.duration, c.capacity, t.trainer_id, t.trainer_name AS trainer_name, t.trainer_picture
                FROM classes c
                JOIN trainers t ON c.trainer_id = t.trainer_id
                WHERE c.class_id = :class_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();

        $classData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($classData) {
            // Specific details
            $trainer_id = $classData['trainer_id'];
            $title = $classData['title'];
            $price = $classData['price'];
            $class_type = $classData['class_type'];
            $class_picture = $classData['class_picture'];
            $description = $classData['description'];
            $date_time = $classData['date_time'];
            $duration = $classData['duration'];
            $capacity = $classData['capacity'];
            $trainer_name = $classData['trainer_name'];
            $trainer_picture = $classData['trainer_picture'];
        } else {
            // Handle the case when the class is not found
            echo "Class not found.";
        }
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        unset($pdo);
    }
} else {
    // Handle the case when class_id is not provided in the URL
    echo "Class not found.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Logo.ico" type="image/x-icon">
    <link rel="icon" href="img/Logo.ico" type="image/x-icon">
    <title>Class Details</title>

    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/class_details.css">
</head>

<body>
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
                    echo '<form method="post" action="class_details.php" style="display: inline;">
                            <input type="hidden" name="logout" value="1">
                            <button type="submit" id="logoutButton">Logout</button>
                          </form>';
                } else {
                    // User is not logged in, display login and signup buttons
                    echo '<a href="login.php" class="loginbtn">Login</a>';
                    echo '<a href="signup.php" class="signupbtn">Sign Up</a>';
                }
            ?>
        </div>
    </div>

    <main>
        <div class="class-details-container">
            <div class="class-details-image">
                <img src="<?php echo $class_picture; ?>" alt="Class Image">
            </div>
            <div class="container-2c">
                <div class="details-left">
                    <p class="type">Class Type: <?php echo $class_type; ?></p>
                    <h1><?php echo $title; ?></h1>
                    <p><?php echo $description; ?></p>

                    <h2>Date & Time: </h2>
                    <p><?php echo $date_time; ?></p>

                    <h2>Duration: </h2>
                    <p><?php echo $duration; ?></p>

                    <h2>Capacity: </h2>
                    <p><?php echo $capacity; ?></p>

                    <h2>Trainer: </h2>
                    <div class="trainer-image-container">
                        <a href="trainer_details.php?trainer_id=<?php echo $trainer_id; ?>">
                            <img src="<?php echo $trainer_picture; ?>" alt="Trainer Image">
                            <p><?php echo $trainer_name; ?></p>
                        </a>
                    </div>
                </div>
                <div class="details-right">
                    <p>Price: <?php echo $price; ?></p>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        // Display the "Book Now" button when the user is logged in
                        echo '<a href="payment.php?class_id=' . $class_id . '" class="book-now-button">Book Now</a>';
                    } else {
                        // User is not logged in
                        echo '<p>Please login to make booking</p>';
                    }
                    ?>
                </div>
            </div>  
        </div>        
    </main>

    <!-- Footer -->
    <footer>
        <div class="info">
            <div class="footer-logo">
                <a href="index.php"><img src="img/logo2.png" alt="Logo"></a>
                <h4><i>"SweatStudio: Where Fitness Becomes A Lifestyle"</i></h4>
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
            <p>&copy; 2023 SweatStudio, All Rights Reserved</p>
        </div>
    </footer>

    <!-- Include Bootstrap 5 JavaScript and Popper.js (Latest version) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>