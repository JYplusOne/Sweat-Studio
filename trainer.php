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
    <title>Trainers</title>
    
    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/trainer.css">  
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
                    <h1>Meet Our Inspiring Trainers</h1>                 
                    <p>"Experience Excellence, Inspire Your Journey, and Achieve Your Fitness Goals with Our Dedicated Team of Trainers"</p><br>
                    <br><br>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!--Filter to select trainer based on trainer's specialty-->
        <form id="filter-specialty">
            <label for="specialty-type">Specialty:</label>
            <select id="specialty-type" name="specialtyType">
                <option value="">All</option>
                <option value="AquaFit">AquaFit</option>
                <option value="Gym">Gym</option>
                <option value="Pilates">Pilates</option>
                <option value="Swimming">Swimming</option>
                <option value="Yoga">Yoga</option>
                <option value="Zumba">Zumba</option>
            </select>
        </form>

        <div id="trainers">
            <!-- Trainer info will be loaded here via AJAX -->
        </div>

        <!-- Include jQuery library for AJAX and DOM manipulation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Load all trainers by default
                loadTrainer();

                // Apply filters when the user makes selections
                $("#filter-specialty").on("change", function() {
                    loadTrainer();
                });

                function loadTrainer() {
                    // Get selected filter values
                    var specialtyType = $("#specialty-type").val();
                    var trainer = $("#trainer").val();

                    // Send an AJAX request to get_trainer_json.php
                    $.ajax({
                        type: "GET",
                        url: "get_trainer_json.php",
                        data: {
                            specialtyType: specialtyType,
                            trainer: trainer
                        },
                        dataType: "json",
                        success: function(data) {
                            // Display the trainers on the page
                            displayTrainer(data);
                        }
                    });
                }

                function displayTrainer(data) {
                    var trainersDiv = $("#trainers"); //This line selects the HTML element with the id "trainers" using jQuery and stores it in the trainersDiv variable. 
                    trainersDiv.empty();//clears the content of the trainersDiv element- to remove any previously displayed thumbnails
                    if (data.length === 0) {
                        trainersDiv.append("<p>No trainer found.</p>");//checks if the data array is empty. If there are no trainers in the result, show a message
                    } else {
                        $.each(data, function(index, trainerData) {
                            // Create a link for each trainer thumbnail
                            var trainerLink = '<a href="trainer_details.php?trainer_id=' + trainerData.trainer_id + '">';

                            // Create the trainerDiv container
                            var trainerDiv = '<div class="trainer-thumbnail">';
                            
                            // Create the trainer image container
                            trainerDiv += '<div class="trainer-thumbnail-img">';
                            trainerDiv += '<img src="' + trainerData.trainer_picture + '" alt="Trainer Image" />';
                            trainerDiv += '</div>';
                            
                            // Add trainer name and specialty
                            trainerDiv += '<div class="trainer-info">';
                            trainerDiv += '<h4>' + trainerData.trainer_name + '</h4>';
                            trainerDiv += '<p>Specialty: ' + trainerData.specialty + '</p>';
                            trainerDiv += '</div>';
                            
                            // Close the trainerDiv container
                            trainerDiv += '</div>';
                            trainerLink += trainerDiv + '</a>'; // Wrap the div with the link
                            
                            // Append the trainerDiv to the trainersDiv
                            trainersDiv.append(trainerLink);
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
                <a href="#">Facilities</a><br>
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