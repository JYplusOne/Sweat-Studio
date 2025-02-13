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
    <title>About Us</title>
    
    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/about_us.css">
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
            <div class="about-banner">
                <div class="text">
                    <<h1>Who are we ? </h1>                 
                    <p>"Welcome to SweatStudio, where fitness meets flexibility, and community thrives. We are more than just a gym; we are a dynamic fitness destination that empowers you to sculpt the body and lifestyle you desire. Whether you're a seasoned fitness enthusiast or just starting your journey, our mission is to provide a space for everyone to achieve their goals, have fun, and connect with expert trainers specializing in various fitness areas."</p><br>
                    <br><br>
                </div>
            </div>
        </div>
    </header>

    <div class="visionmission-row">
        <div class="visionmission shadow1">
            <img src="aboutus_image/vision.svg" alt="vision">
            <h2>Vision</h2>
            <p>At SweatStudio, we envision a world where fitness is accessible, customizable, and transformative, empowering individuals to embrace a lifestyle of wellbeing for a healthier, happier community.</p>
        </div>
        <div class="visionmission shadow2">
            <img src="aboutus_image/mission.svg" alt="mission">
            <h2>Mission</h2>
            <p>Inspire your fitness journey at our state-of-the-art facility. Rent our versatile space for solo workouts, group classes, or personalized training sessions, tailored to your goals and preferences.</p>
        </div>
        <div class="visionmission shadow1">
            <img src="aboutus_image/value.svg" alt="value">
            <h2>Value</h2>
            <p>We value accessibility, community, and personalization. Explore a variety of sports, connect with fellow enthusiasts, and tailor your experience to your unique preferences at SweatStudio</p>
        </div>
    </div>
    

    <!--Team Member-->
    <div class="services-section-background">
        <div class="section-title">
            <h1>Team Founder</h1>
            <p>The group who create the world of SweatStudio!</p>
        </div>
        <div class="container" style="padding-top: 20px;">
            <!-- Team member 1 -->
            <div class="member">
                <div class="rounded"><img src="aboutus_image/jiayi.png" alt="jiayi" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h4>Yeo Jia Yi</h4><p>Group Leader</p>
                </div>
            </div>
            <!-- Team member 2 -->
            <div class="member">
                <div class="rounded"><img src="aboutus_image/jiamei.jpg" alt="jiamei" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h4>Lim Jia Mei</h4><p>Member</p>
                    </div>
            </div>
            <!-- Team member 3 -->
            <div class="member">
                <div class="rounded"><img src="aboutus_image/limting.jpg" alt="limting" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h4>Lim Ting</h4><p>Member</p>
                    </div>
            </div>
            <!-- Team member 4 -->
            <div class="member">
                <div class="rounded"><img src="aboutus_image/alicia.jpeg" alt="alicia" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h4>Alicia Goh</h4><p>Member</p>
                    </div>
            </div>
            <!-- Team member 5 -->
            <div class="member">
                <div class="rounded"><img src="aboutus_image/yihuey.jpeg" alt="jiayi" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h4>Tey Yi Huey	</h4><p>Member</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Slider to display fitness classes--> 
    <div class="section-title">
        <h1>What we provide?</h1>
        <p>"Unlock Your Potential: Join Our Sport Center and Ignite Your Fitness Journey Today!"</p>
    </div>
    <div id="popularClassCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#popularClassCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#popularClassCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#popularClassCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="aboutus_image/coa_facility.jpg" class="d-block w-100" alt="class1">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Book Facility</h2>
                    <p>"Ready to elevate your fitness journey? Book a spot at SweatStudio for a personalized workout experience. We offer a clean, inviting environment for your workouts, events, or yoga and meditation sessions. Take control of your fitness – reserve your space today!"
                    <br>
                    Feel free to adjust the wording as needed to fit your style and audience.
                    </p>
                    <br><a href="facilities.php" class="detailsbtn">Book Now !</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="aboutus_image/coa_class.jpg" class="d-block w-100" alt="class2">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Book Class</h2>
                    <p>Ready to transform your fitness routine? Join a class with our expert trainers at SweatStudio for a personalized and efficient journey to your fitness goals. Whether you're into high-intensity training or prefer the zen of yoga, our knowledgeable instructors have you covered.
                    <br>
                    Reserve your spot today, and let's make your fitness aspirations a reality with SweatStudio!
                    </p>
                    <br><a href="classes.php" class="detailsbtn">Book Now !</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="aboutus_image/coa_contact.jpg" class="d-block w-100" alt="class3">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Contact Us</h2>
                    <p>Got questions or need info? Click on our inquiry form for a quick response about classes, trainers, or anything related to your fitness journey. Your path to a healthier, happier you starts with SweatStudio. 
                    <br>
                    Contact us now!  
                    </p>
                    <br><a href="about_us.php#contactus" class="detailsbtn">Enquiry Now !</a>
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

        

    <!--testimonial-->
    <div class="outoutdiv">
    <div class="section-title">
        <h1>Testimonials</h1>
        <p>Hear what our satisfied members have to say – check out our user testimonials for firsthand accounts of the SweatStudio experience.</p>
    </div>
    <div class="outerdiv">   
        <div class="innerdiv">
        <!-- div1 -->
        <div class="div1 eachdiv">
            <div class="userdetails">
            <div class="imgbox">
                <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-daniel.jpg" alt="">
            </div>
            <div class="detbox">
                <p class="name">Daniel Clifford</p>
                <p class="designation">Group Fitness Class</p>
            </div>
            </div>
            <div class="review">
            <h4>Unlocking My Full Potential</h4>
            <p>“ Joining David Miller's fitness program has been a transformative experience. Under his expert guidance, I've not only achieved my fitness goals but also discovered a new level of strength and confidence I didn't know I had. David's personalized approach and motivational coaching are second to none. This program is not just about physical change; it's a pathway to self-discovery and self-belief. I wholeheartedly recommend it to anyone looking for a remarkable fitness journey. ”</p>
            </div>
        </div>

        <!-- div2 -->
        <div class="div2 eachdiv">
            <div class="userdetails">
            <div class="imgbox">
                <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-jonathan.jpg" alt="user1">
            </div>
            <div class="detbox">
                <p class="name">Jonathan Walters</p>
                <p class="designation">Transformative Yoga Classes</p>
            </div>
            </div>
            <div class="review">
            <h4>The team was very supportive and kept me motivated</h4>
            <p>“ <b>Sarah's</b> yoga classes have transformed my fitness journey. Her expertise and care made every session an incredible experience. "</p>
            </div>
        </div>

        <!-- div3 -->
        <div class="div3 eachdiv">
            <div class="userdetails">
            <div class="imgbox">
                <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-kira.jpg" alt="user2">
            </div>
            <div class="detbox">
                <p class="name dark">Kira Whittle</p>
                <p class="designation dark">Transformative Swimming Classes</p>
            </div>
            </div>
            <div class="review dark">
            <h4>Such a life-changing experience. Highly recommended!</h4>
            <p>“ I had an immense fear of water and never thought I could swim. <b>Michael's</b> coaching completely changed that. With his patient guidance, I overcame my fears and gained confidence in the water. His dedication to teaching is exceptional, and I'm now a confident swimmer. Thank you, Michael, for your incredible support and expertise! "
                <br>
                In this example, the title is more descriptive while the comment remains concise, highlighting the transformation the client experienced under the trainer's guidance.</p>
            </div>
        </div>

        <!-- div4 -->
        <div class="div4 eachdiv">
            <div class="userdetails">
            <div class="imgbox">
                <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-jeanette.jpg" alt="user3">
            </div>
            <div class="detbox">
                <p class="name dark">Jeanette Harmon</p>
                <p class="designation dark">Personal Fitness Class</p>
            </div>
            </div>
            <div class="review dark">
            <h4>Total Body Transformation</h4>
            <p>“ <b>David's</b> Total Body Transformation Challenge was an incredible experience. His guidance and workouts were instrumental in helping me achieve my fitness goals. Highly recommend! ”</p>
            </div>
        </div>

        <!-- div5 -->
        <div class="div5 eachdiv">
            <div class="userdetails">
            <div class="imgbox">
                <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-patrick.jpg" alt="user4">
            </div>
            <div class="detbox">
                <p class="name">Patrick Abrams</p>
                <p class="designation">Personal Fitness Class</p>
            </div>
            </div>
            <div class="review">
            <h4>Total Body Transformation Challenge: Achieving My Fitness Goals.</h4>
            <p>“ <b>David's</b> Total Body Transformation Challenge was an incredible experience. His guidance and workouts were instrumental in helping me achieve my fitness goals. Highly recommend! <br>The support and motivation from both David and the other participants in the challenge made the journey even more rewarding. It's not just a fitness program; it's a community of like-minded individuals working together to achieve their best selves. ”</p>
            </div>
        </div>
        </div>
    </div>
    </div>
        

    <!--contact us-->
    <!--connection to sqldatabase-->
    <?php
    $conn = mysqli_connect('localhost','root','','sweatstudio') or die('connection failed');
    ?>

    <?php
    if (isset($_POST['submit'])) {
        date_default_timezone_set('Asia/Singapore');

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone_no']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Get the current timestamp
        $time_stamp = date('Y-m-d H:i:s');

        // Check if any of the variables are empty
        if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
            echo "Please fill in all the required fields.";
        } else {
            $query = "INSERT INTO `members` (name, email, phone_no, subject, message, time_stamp) VALUES ('$name', '$email', '$phone', '$subject', '$message', '$time_stamp')";
            $insert = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));
        }
    }
    ?>

    <div class="section-title" id="contactus">
        <h1>Contact us</h1>
        <p>We would like to hear from you!</p>
    </div>
    <div class="contact-section">
        <div class="contact-info">
            <div class="contact">
                <img src="aboutus_image/phoneicon.jpg" alt="phone icon">
                <p><b>Phone Number</b><br>+601-2345 6789</p>
            </div>
            <div class="contact">
                <img src="aboutus_image/emailicon.jpg" alt="email icon">
                <p><b>Email Address</b><br>sweatstudio@gmail.com</p>
            </div>
            <div class="contact">
                <img src="aboutus_image/linkicon.jpg" alt="link icon">
                <p><b>Social Media</b><br>@Sweat Studio</p>
            </div>
            <div class="contact">
                <img src="aboutus_image/locationicon.jpg" alt="location icon">
                <p><b>Location</b><br>No. 1, Jalan Studio, 47500 Subang Jaya, Selangor, Malaysia</p>
            </div>
        </div>
        <div class="contact-form">
            <form action="" method="post" enctype="multipart/form-data" onsubmit="sendEmail();">
                <h3>Send message</h3>
                <input type="text" id="name" name="name" placeholder="Your Name" class="box" required>
                <input type="email" id="email" name="email" placeholder="Email" class="box" required>
                <input type="tel" id="phone_no" name="phone_no" placeholder="Phone number" class="box" required>
                                    
                <label for="subject"> Needed Services:</label>
                <select name="subject" id="subject" class="box" required>
                    <option value="trainer">Trainer</option>
                    <option value="facilities">Facilities</option>
                    <option value="classes">Classes</option>
                    <option value="others">Others</option>
                </select>

                <textarea id="message" name="message" rows="4" placeholder="What would you like to enquire?" class="box" required></textarea>
                <input type="submit" name="submit" value="Send" class="btn">
            </form>
        </div>
    </div>
                    
    <!--email to server host-->
    <script>
        function sendEmail(){
            Email.send({
                Host : "smtp.elasticemail.com",
                Username : "jiamei0216@gmail.com",
                Password : "4D5F670816A91F5EC031D9F60109DC06420E",
                To : 'jiamei0216@gmail.com',
                From : document.getElementById("email").value,
                Subject : "New Contact Form Enquiry",
                Body : "Name: " + document.getElementById("name").value + "<br> Email: " + document.getElementById("email").value + "<br> Phone Number: " + document.getElementById("phone_no").value + "<br> Subject: " + document.getElementById("subject").value +"<br> Enquiqry : " + document.getElementById("message").value
            })
            message => alert("Enquiry Sent Sucessfully")
        }
    </script>
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