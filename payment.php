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

// Initialize variables
$title = "";
$price = 0;

// Check if class_id or facility_id is set in the URL
if (isset($_GET['class_id']) || isset($_GET['facility_id'])) {
    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "sweatstudio";

    try {
        // Initialize $pdo
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['class_id'])) {
            $class_id = $_GET['class_id'];

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
                $title = $classData['title'];
                $price = $classData['price'];
                // ... other details
            } else {
                // Handle the case when the class is not found
                echo "Class not found.";
                exit;
            }
        } elseif (isset($_GET['facility_id'])) {
            $facility_id = $_GET['facility_id'];

            // Fetch facility-specific information based on $facility_id from the database
            $facilitySql = "SELECT facility_name, price FROM facilities WHERE facility_id = :facility_id";

            $facilityStmt = $pdo->prepare($facilitySql);
            $facilityStmt->bindParam(':facility_id', $facility_id, PDO::PARAM_INT);
            $facilityStmt->execute();

            $facilityData = $facilityStmt->fetch(PDO::FETCH_ASSOC);

            if ($facilityData) {
                // Set facility-specific details
                $title = $facilityData['facility_name'];
                $price = $facilityData['price'];
                // ... other details
            } else {
                // Handle the case when the facility is not found
                echo "Facility not found.";
                exit;
            }
        }
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    // Handle the case when class_id or facility_id is not provided in the URL
    echo "Class or facility not found.";
    exit;
}

$paymentSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_payment"])) {
    // Assuming you have form fields like card_number, expiry_date, cvv, etc.
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvs'];  // Fix the typo in the form field name

    // Insert into the booking table
    try {
        // Use the existing $pdo connection
        $sql = "INSERT INTO booking (id, class_id, facility_id) VALUES (:member_id, :class_id, :facility_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':member_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindParam(':facility_id', $facility_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        $paymentSuccess = true; // Set the payment success flag
    } catch (PDOException $e) {
        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Logo.ico" type="image/x-icon">
    <title>Your Page Title</title>

    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/payment.css">
</head>

<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="navbar-logo">
            <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
        </div>
        <div class="links">
            <!-- Add your navigation links here -->
            <a href="about_us.php">About</a>
            <a href="trainer.php">Trainer</a>
            <a href="facilities.php">Facilities</a>
            <a href="classes.php">Classes</a>
            <a href="about_us.php#contactus">Contact</a>
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

    <div class="payment-container">
        <div class="payment-details">
            <h2>Payment Details for <?php echo $title; ?></h2>
            <p>Price: <?php echo $price; ?></p>
        </div>
        <div class="payment-form">
            <?php
            if ($paymentSuccess) {
                echo '<script>
                        alert("Payment successful! Thank you.");
                        window.location.href = "profile.php";
                      </script>';
            }
            ?>
            <form action="payment.php?<?php echo isset($class_id) ? 'class_id=' . $class_id : 'facility_id=' . $facility_id; ?>" method="POST">
                <!-- Add hidden fields for class_id and facility_id -->
                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                <input type="hidden" name="facility_id" value="<?php echo $facility_id; ?>">

                <!-- Add your form fields here -->
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" minlength="16" maxlength="16" required>

                <label for="card_expiry">Card Expiry (mm/yy):</label>
                <input type="text" id="card_expiry" name="expiry_date" pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="mm/yy" title="Enter a valid expiry date (mm/yy)" required>

                <label for="card_cvc">Card CVC:</label>
                <input type="text" id="cvs" name="cvs" pattern="\d{3}" maxlength="3" placeholder="123" title="Enter a valid 3-digit CVC number" required>

                <button type="submit" class="btn btn-primary" name="submit_payment">Pay Now</button>
            </form>
        </div>
    </div>

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
                <!-- Add your footer links here -->
                <h4>Useful Links</h4>
                <a href="index.php">Home</a><br>
                <a href="about_us.php">About Us</a><br>
                <a href="facilities.php">Facilities</a><br>
                <a href="classes.php">Classes</a>
            </div>
            <div class="footer-info">
                <!-- Add your footer information or additional links here -->
                <h4>More Info</h4>
                <a href="#">Terms of Service</a><br>
                <a href="#">Privacy Policy</a><br>
                <a href="about_us.php#contactus">Contact Us</a>
            </div>
            <div class="footer-intouch">
                <!-- Add your social media links or other contact information here -->
                <h4>Get In Touch</h4>
                <a href="#">Facebook</a><br>
                <a href="#">Instagram</a><br>
                <a href="#">Twitter</a><br>
                <a href="#">LinkedIn</a>
            </div>
        </div>
        <hr>
        <div class="copyright">
            <!-- Add your copyright information or other text here -->
            <p>&copy; 2023 SweatStudio, All Rights Reserved</p>
        </div>
    </footer>

    <!-- Include Bootstrap 5 JavaScript and Popper.js (Latest version) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>