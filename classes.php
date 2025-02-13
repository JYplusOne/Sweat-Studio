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
    <title>Classes</title>
    
    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/classes.css">  
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
                    <h1>Discover Exciting Classes at SweatStudio</h1>                 
                    <p>"Unlock Your Potential, Transform Your Lifestyle, and Elevate Your Wellness Journey with SweatStudio's Diverse Fitness Classes"</p><br>
                    <br><br>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!--Filter to select classes based on class type and trainer-->
        <form id="filter-form">
            <label for="class-type">Class Type:</label>
            <select id="class-type" name="classType">
                <option value="">All</option>
                <option value="AquaFit">AquaFit</option>
                <option value="Gym">Gym</option>
                <option value="Pilates">Pilates</option>
                <option value="Swimming">Swimming</option>
                <option value="Yoga">Yoga</option>
                <option value="Zumba">Zumba</option>
            </select>

            <label for="trainer">Trainer:</label>
            <select id="trainer" name="trainer">
                <option value="">All</option>
                <option value="1">Jessie Tan</option>
                <option value="2">Jake Boss</option>
                <option value="3">Mia Stone</option>
                <option value="4">Spike</option>
                <option value="5">Alex Turner</option>
                <option value="6">Olivia Davis</option>
                <option value="7">Hannah White</option>
                <option value="8">Chris Brown</option>
                <option value="9">Sarah Thompson</option>
                <option value="10">David Miller</option>
                <option value="11">Michael Johnson</option>
                <option value="12">Emily Collins</option>
            </select>
        </form>

        <div id="classes">
            <!-- Classes will be loaded here via AJAX -->
        </div>

        <!-- Include jQuery library for AJAX and DOM manipulation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Load all classes by default
                loadClasses();

                // Apply filters when the user makes selections
                $("#filter-form").on("change", function() {
                    loadClasses();
                });

                function loadClasses() {
                    // Get selected filter values
                    var classType = $("#class-type").val();
                    var trainer = $("#trainer").val();

                    // Send an AJAX request to get_classes_json.php
                    $.ajax({
                        type: "GET",
                        url: "get_classes_json.php",
                        data: {
                            classType: classType,
                            trainer: trainer
                        },
                        dataType: "json",
                        success: function(data) {
                            // Display the classes on the page
                            displayClasses(data);
                        }
                    });
                }

                function displayClasses(data) {
                    var classesDiv = $("#classes"); //This line selects the HTML element with the id "classes" using jQuery and stores it in the classesDiv variable. 
                    classesDiv.empty();//clears the content of the classesDiv element- to remove any previously displayed class thumbnails
                    if (data.length === 0) {
                        classesDiv.append("<p>No classes found.</p>");//checks if the data array is empty. If there are no classes in the result, show a message
                    } else {
                        $.each(data, function(index, classData) {
                            // Create a link for each class thumbnail
                            var classLink = '<a href="class_details.php?class_id=' + classData.class_id + '">';

                            // Create the classDiv container
                            var classDiv = '<div class="class-thumbnail">';
                            
                            // Create the class image container
                            classDiv += '<div class="class-thumbnail-img">';
                            classDiv += '<img src="' + classData.class_picture + '" alt="Class Image" />';
                            classDiv += '</div>';
                            
                            // Add title and price
                            classDiv += '<div class="class-info">';
                            classDiv += '<h4>' + classData.title + '</h4>';
                            classDiv += '<p>Price: ' + classData.price + '</p>';
                            classDiv += '<p>Class Type: ' + classData.class_type + '</p>';
                            classDiv += '</div>';
                            
                            // Create the trainer info container
                            classDiv += '<div class="trainer-info">';
                            classDiv += '<img src="' + classData.trainer_picture + '" alt="Trainer Image" />';
                            classDiv += '<p>Trainer: ' + classData.trainer_name + '</p>';
                            classDiv += '</div>';
                            
                            // Close the classDiv container
                            classDiv += '</div>';
                            classLink += classDiv + '</a>'; // Wrap the div with the link
                            
                            // Append the classDiv to the classesDiv
                            classesDiv.append(classLink);
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