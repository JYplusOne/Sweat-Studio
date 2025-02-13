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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Logo.ico" type="image/x-icon">
    <title>Home</title>
    
    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
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
            <div class="container-2columns">
                <div class="text">
                    <h1>SweatStudio: Where Fitness Become A Lifestyle</h1>                 
                    <p>"We're here to help you unlock your full potential and achieve your fitness goals. Our state-of-the-art facilities, expert trainers, and diverse range of fitness classes are all designed to empower you."</p><br>
                    <a href="#" class="explorebtn">Book Facilities</a>
                    <a href="classes.php" class="explorebtn">Book Classes</a>
                    <br><br>
                </div>
                <div class="image"><!--Removed--></div>
            </div>
        </div>
    </header>
    

    
    <main> 
        <!--Achievement-->
        <div class="achievement-row">
            <div class="achievement shadow1">
                <h2>180,000</h2><h6>SQUARE FEET</h6><hr>
                <p>Of space, providing ample room for your workouts.</p>
            </div>
            <div class="achievement shadow2">
                <h2>1,000+</h2><h6>ACTIVE MEMBERS</h6><hr>
                <p>All dedicated to achieving their fitness goals with us.</p>
            </div>
            <div class="achievement shadow1">
                <h2>50+</h2><h6>CLASSES</h6><hr>
                <p>Provide a variety options to keep your workouts exciting.</p>
            </div>
            <div class="achievement shadow2">
                <h2>30+</h2><h6>TRAINERS</h6><hr>
                <p>With diverse expertise to guide your fitness journey.</p>
            </div>
            <div class="achievement shadow1">
                <h2>10</h2><h6>YEARS</h6><hr>
                <p>Of experience in providing professional services.</p>
            </div>
        </div>
        <!-- About Section --> 
        <div class="about-us-section">
            <div class="about-us-content">
                <h2>About SweatStudio</h2>
                <p>At SweatStudio, we are more than just a fitness center; we are a vibrant and inclusive community dedicated to your health and well-being. With over a decade of experience in the fitness industry, our target is to empower individuals of all fitness levels to lead healthier, happier lives.</p>
                <br><a href="about_us.php" class="explorebtn">View More</a>
            </div>
            <div class="about-us-image">
              <img src="img/about-us-image.png" alt="About Us Image">
            </div>
        </div>

        <!-- Service Section -->
        <div class="services-section-background">
            <div class="section-title">
                <h1>Discover Our Comprehensive Services</h1>
                <p>Unlock your potential with our diverse services. Experience excellence in sports and fitness.</p>
            </div>
            <div class="services-section">
                <div class="service-box">
                    <div class="icon-wrapper">
                        <img src="img/services-icon-1.svg" alt="Service Icon 1">
                    </div>
                    <h3>Online Booking</h3>
                    <p>We offer the convenience of online booking and reservation services for our fitness classes and facilities.</p>
                </div>
                <div class="service-box">
                    <div class="icon-wrapper">
                        <img src="img/services-icon-2.svg" alt="Service Icon 2">
                    </div>
                    <h3>Fitness Classes</h3>
                    <p>We offer various fitness classes that cater to all interests. You're sure to find the perfect fit for your fitness journey.</p>
                </div>
                <div class="service-box">
                    <div class="icon-wrapper">
                        <img src="img/services-icon-3.svg" alt="Service Icon 3">
                    </div>
                    <h3>Expert Trainers</h3>
                    <p>Our team of experienced and highly qualified trainers and instructors are dedicated to help you achieve your fitness goals</p>
                </div>
                <div class="service-box">
                    <div class="icon-wrapper">
                        <img src="img/services-icon-4.svg" alt="Service Icon 4">
                    </div>
                    <h3>Comperhensive Facilities</h3>
                    <p>We offer state-of-the-art fitness facilities to give you a better fitness experience.</p>
                </div>
                <div class="service-box">
                    <div class="icon-wrapper">
                        <img src="img/services-icon-5.svg" alt="Service Icon 5">
                    </div>
                    <h3>Good Environment</h3>
                    <p>We adheres to stringent cleanliness standards and safety measures to provide a healthy and secure workout environment for all.</p>
                </div>
                <div class="service-box">
                    <div class="icon-wrapper">
                        <img src="img/services-icon-6.svg" alt="Service Icon 6">
                    </div>
                    <h3>Nutrition Guidance</h3>
                    <p>Our expert nutritionists provide personalized guidance and nutrition plans to support your fitness goals</p>
                </div>
            </div>
        </div>
        
        
        <!-- Carousel Slider to display fitness classes--> 
        <div class="section-title">
                <h1>Popular Classes</h1>
                <p>Explore our popular classes, striking a perfect balance between high-intensity training and relaxation.</p>
        </div>
        <div id="popularClassCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#popularClassCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#popularClassCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#popularClassCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/Class1.png" class="d-block w-100" alt="class1">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Yoga Flow</h2>
                        <p>A dynamic yoga class that combines breath and movement to create a flowing sequence of poses. This class will challenge your strength, flexibility, and balance, while calming your mind and reducing stress. Suitable for all levels, as the instructor will offer modifications and variations for each pose.
                            <br><br><b>Trainer: Jessie Tan</b>
                        </p>
                        <br><a href="class_details.php?class_id=2" class="detailsbtn">More Details</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/Class2.png" class="d-block w-100" alt="class2">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Spin Zone</h2>
                        <p>A high-intensity spin class that will make you sweat and burn calories like never before. You will ride to the rhythm of upbeat music, following the instructor’s cues to adjust your speed, resistance, and posture. You will also do some intervals, sprints, and climbs to challenge your endurance and power. 
                            <br><br><b>Trainer: Jake Boss</b>
                        </p>
                        <br><a href="class_details.php?class_id=4" class="detailsbtn">More Details</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/Class3.png" class="d-block w-100" alt="class3">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Booty Camp</h2>
                        <p>A boot camp style class that focuses on toning and shaping your lower body. You will do a variety of exercises using your own body weight, dumbbells, bands, and kettlebells. You will work on your glutes, hamstrings, quads, calves, and core, while also improving your cardio and agility.  
                            <br><br><b>Trainer: Mia Stone</b>
                        </p>
                        <br><a href="class_details.php?class_id=6" class="detailsbtn">More Details</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
          
            <!-- Controls -->
            <a class="carousel-control-prev" href="#popularClassCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#popularClassCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        <!-- Info cards to showcase trainers --> 
        <div class="section-title">
            <h1>New Trainers</h1>
            <p>Meet SweatStudio’s new trainers, your personal guide to achieving your fitness goals</p>
        </div>
        <div class="trainers">
            <div class="trainer-card">
                <a href="trainer_details.php?trainer_id=1"> 
                    <img src="img/Jessie.jpg" alt="trainer1">
                    <h4>Jessie Tan</h4>
                    <p>Certified yoga instructor with <br>over 10 years of experience.</p>
                    <p><i>Class: Yoga Flow</i></p>
                </a>
            </div>
          
            <div class="trainer-card">
                <a href="trainer_details.php?trainer_id=2"> 
                    <img src="img/Jake.jpg" alt="trainer2">
                    <h4>Jake Boss</h4>
                    <p>Former professional cyclist <br> and spin instructor.</p>
                    <p><i>Class: Spin Zone</i></p>
                </a>
            </div>
            <div class="trainer-card">
                <a href="trainer_details.php?trainer_id=3"> 
                    <img src="img/Mia.jpg" alt="trainer3">
                    <h4>Mia Stone</h4>
                    <p>Fitness model and personal <br> trainer with 3 years of coaching experience. </p>
                    <p><i>Class: Booty Camp</i></p>
                </a>
            </div>
            <div class="trainer-card">
                <a href="trainer_details.php?trainer_id=4"> 
                    <img src="img/Spike.jpg" alt="trainer4">
                    <h4>Spike</h4>
                    <p>Certified swimming coach <br> with over 5 years of teaching experience.</p>
                    <p><i>Class: AquaFit Splash</i></p>
                </a>
            </div>
        </div>
        <div class="section-title">
            <br><br>
            <a href="trainer.php">View More</a>
        </div>

        <!-- testimonial--> 
        <div class="section-title">
            <h1>What Our Members Are Saying</h1>
            <p>Real stories, real results – hear from our dedicated sweatstudio community</p>
        </div>
        <div class="testimonial">
            <div class="testimonial-image">
              <img src="img/testimonial.png" alt="Testimonial Image">
            </div>
            <div class="testimonial-scroll">
                <div class="testimonial-card">
                    <img src="img/quotation-left.png" alt="quotation-left">
                    <div class="comment">
                        <p>SweatStudio has become my fitness haven. The Yoga Flow class with Jessie Tan not only aligns with my cultural preferences but has also brought tranquility to my busy life. The facility's commitment to cleanliness and the warm community atmosphere make every session a rejuvenating experience.</p>
                    </div>
                    <div class="user-image">
                        <img src="img/Lee Mei Ling.jpg" alt="Lee Mei Ling">
                        <p><b>Mrs. Lee Mei Ling</b><br><i>Business Owner</i></p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <img src="img/quotation-left.png" alt="quotation-left">
                    <div class="comment">
                        <p>"In my corporate life, finding a fitness center that aligns with my rigorous schedule was challenging until I discovered SweatStudio. The online booking system and extended operating hours provide unparalleled convenience. <br></p>
                    </div>
                    <div class="user-image">
                        <img src="img/Alexander Reynolds.jpg" alt="Alexander Reynolds">
                        <p><b>Mr. Alexander Reynolds</b><br><i>Corporate Executive</i></p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <img src="img/quotation-left.png" alt="quotation-left">
                    <div class="comment">
                        <p>SweatStudio has become my sanctuary for achieving holistic wellness. The meticulous attention to cleanliness and the state-of-the-art facilities create an environment conducive to both physical and mental fitness. The professionalism exhibited by the entire team at SweatStudio is commendable.</p>
                    </div>
                    <div class="user-image">
                        <img src="img/Vanessa Carter.jpg" alt="Vanessa Carter">
                        <p><b>Dr. Vanessa Carter</b><br><i>Wellness Advocate</i></p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <img src="img/quotation-left.png" alt="quotation-left">
                    <div class="comment">
                        <p>SweatStudio is a testament to inclusivity. The commitment to a clean and safe environment, coupled with a range of fitness offerings, showcases their understanding of diverse needs. It's more than a gym; it's a place where everyone feels welcomed.</p>
                    </div>
                    <div class="user-image">
                        <img src="img/Ahmad Bin Abdullah.jpg" alt="Ahmad Bin Abdullah">
                        <p><b>Mr. Ahmad Bin Abdullah</b><br><i>Engineer</i></p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <img src="img/quotation-left.png" alt="quotation-left">
                    <div class="comment">
                        <p>SweatStudio has been a refreshing addition to my student life. The ease of online bookings, extended hours, and the overall positive environment make it an ideal choice for individuals with varying schedules and preferences.</p>
                    </div>
                    <div class="user-image">
                        <img src="img/Priya Devi.jpg" alt="Priya Devi">
                        <p><b>Miss Priya Devi</b><br><i>Student</i></p>
                    </div>
                    
                </div>
                
            </div>
        </div>
        

    </main>
    
    

    <!-- Footer -->
    <footer>
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

</body>
</html>