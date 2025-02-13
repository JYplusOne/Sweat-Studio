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

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Logo.ico" type="image/x-icon">
    <title>Facilities</title>

    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/facilities.css">
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

    <!-- The Banner -->
    <header>
        <div>
            <div class="page-banner">
                <div class="text">
                    <h1>Explore Our Premier Facilities at SweatStudio</h1>
                    <p>"Experience Top-Notch Amenities Tailored for Your Fitness Goals at SweatStudio"</p><br>
                    <br><br>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Filter to select facilities based on facility type -->
        <form id="filter-form">
            <label for="facilities-type">Facilities Type:</label>
            <select id="facilities-type" name="facilitiesType">
                <option value="">All</option>
                <option value="Outdoor">Outdoor</option>
                <option value="Indoor">Indoor</option>
            </select>
        </form>

        <div id="facilities">
            <!-- Facilities will be loaded here via AJAX -->
        </div>

        <!-- Include jQuery library for AJAX and DOM manipulation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Load all facilities by default
                loadFacilities();

                // Apply filter when the user makes a selection
                $("#filter-form").on("change", function () {
                    loadFacilities();
                });

                function loadFacilities() {
                    // Get selected filter value
                    var facilitiesType = $("#facilities-type").val();

                    console.log("Facilities Type: " + facilitiesType);

                    // Send an AJAX request to get_facilities_json.php
                    $.ajax({
                        type: "GET",
                        url: "get_facilities_json.php",
                        data: {
                            facilitiesType: facilitiesType
                        },
                        dataType: "json",
                        success: function (data) {
                            console.log("AJAX Success: ", data);
                            // Display the facilities on the page
                            displayFacilities(data);
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX Error: " + error);
                        }
                    });
                }

                function displayFacilities(data) {
                    var facilitiesDiv = $("#facilities");
                    facilitiesDiv.empty();
                    if (data.length === 0) {
                        facilitiesDiv.append("<p>No facilities found.</p>");
                    } else {
                        $.each(data, function (index, facilityData) {
                            console.log("Facility Data: ", facilityData);
                            // Create the facilityDiv container
                            var facilityDiv = '<div class="facility-thumbnail">';

                            // Create the facility image container
                            facilityDiv += '<div class="facility-thumbnail-img">';
                            facilityDiv += '<img src="' + facilityData.image_path + '" alt="Facility Image" />';
                            facilityDiv += '</div>';

                            // Add title and description
                            facilityDiv += '<div class="facility-info">';
                            facilityDiv += '<h4>' + facilityData.facility_name + '</h4>';
                            facilityDiv += '<p>' + facilityData.description + '</p>';
                            facilityDiv += '<p id="price">' + facilityData.price + '</p>';
                            facilityDiv += '</div>';

                            // "Book Now" button
                            var bookNowContainer = '<div class="book-now-container">';
                            <?php if (isset($_SESSION['user_id'])): ?>
                                // User is logged in
                                bookNowContainer += '<a href="payment.php?facility_id=' + facilityData.facility_id + '" class="book-now-button">Book Now</a>';
                            <?php else: ?>
                                // User is not logged in
                                bookNowContainer += '<a href="login.php" class="book-now-button">Login to Book</a>';
                            <?php endif; ?>
                            bookNowContainer += '</div>';
                            facilityDiv += bookNowContainer;

                            // Close the facilityDiv container
                            facilityDiv += '</div>';

                            // Append the facilityDiv to the facilitiesDiv
                            facilitiesDiv.append(facilityDiv);
                        });
                    }
                }
            });
        </script>
    </main>

    <!-- Footer -->
    <footer class="relative-footer2">
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

</body>
</html>