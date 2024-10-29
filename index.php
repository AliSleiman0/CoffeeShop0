<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title> Brewed Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/convo.css">

    <link rel="icon" type="image/x-icon" href="assets/images/logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>

<body> <?php session_start();
require_once ('users\header.php') ?>



    

    <!-- JavaScript -->

    <script>
        $(document).ready(function () {
            $('#menu-btn').click(function () {
                $('.navbar-collapse').toggleClass('show');
            });
        });
    </script>


    <!-- HERO SECTION -->
    <section class="home" id="home">
        <div class="content">
            <h3>Welcome to<br> Coffee Shop Cheers!</h3>
            <p>
                <strong>We are open 4:00 PM to 9:00 PM.</strong>
            </p>
            <a class="btn btn-dark text-decoration-none" onclick="redirectCart()">Order Now!</a>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="about" id="about">
        <h1 class="heading"> <span>About</span> Us</h1>
        <div class="row g-0" style="box-shadow: 0 0 40px #e7a891 ; ">
            <div class="image">
                <img src="assets/images/about-img.png" alt="" class="img-fluid">
            </div>
            <div class="content">
                <h3>Welcome!</h3>
                <p>
                    At our Coffee Shop, we are passionate about coffee and believe
                    that every cup tells a story. We are a cozy coffee shop located
                    in the heart of the city, dedicated to providing an exceptional
                    coffee experience to our customers. Our love for coffee has led
                    us on a voyage of exploration and discovery, as we travel the
                    world in search of the finest coffee beans, carefully roasted
                    and brewed to perfection.
                </p>
                <p>
                    But coffee is not just a drink, it's an experience. Our warm and
                    inviting atmosphere at our shop is designed to be a haven
                    for coffee lovers, where they can relax, connect, and embark
                    on their own coffee voyages.
                </p>
                <a href="#contact" class="btn btn-dark text-decoration-none">Contact us</a>
            </div>
        </div>
    </section>

    <!-- MENU SECTION -->
    <?php
    require ('users\db.php'); // Include your database connection file
    
    $sqlDefault = "SELECT * FROM MenuItems WHERE IsDefault = TRUE";
    $sqlHidden = "SELECT * FROM MenuItems WHERE IsDefault = FALSE";

    $resultDefault = $con->query($sqlDefault);
    $resultHidden = $con->query($sqlHidden);
    ?>
    <section class="menu" id="menu">
        <h1 class="heading">Our <span>Menu</span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <?php
                    // Display default items
                    foreach ($resultDefault as $item) {
                        echo '<div class="col-md-4">
                            <div class="box">
                                <form id="addToCart" action="ordernowdupp\index.html" method="POST">
                                <input type="hidden" value="' . htmlspecialchars($item["ItemID"]) . '" name="ItemID">
                                <input type="hidden" value="' . htmlspecialchars($item["Image"]) . '" name="ItemImage">
                                <input type="hidden" value="' . htmlspecialchars($item["Title"]) . '" name="ItemTitle">
                                <input type="hidden" value="' . htmlspecialchars($item["Price"]) . '" name="ItemPrice">
                                <img src="' . htmlspecialchars($item["Image"]) . '" alt="" class="product-img">
                                <h3 class="product-title">' . htmlspecialchars($item["Title"]) . '</h3>
                                <div class="price">$' . htmlspecialchars($item["Price"]) . '</div>
                                <a  class="btn add-cart" onclick="redirectCart()">Order Now!</a>
                            </div>
                        </div>';
                    }
                    ?>
                </div>

                <!-- Hidden rows to be toggled -->
                <div class="row row-to-hide" style="display: none;">
                    <?php
                    // Display hidden items
                    foreach ($resultHidden as $item) {
                        echo '<div class="col-md-4">
                            <div class="box">
                            
                        <form id="addToCart" action="ordernowdupp\index.html" method="POST">
                        <input type="hidden" value="' . htmlspecialchars($item["ItemID"]) . '" name="ItemID">
                        <input type="hidden" value="' . htmlspecialchars($item["Image"]) . '" name="ItemImage">
                        <input type="hidden" value="' . htmlspecialchars($item["Title"]) . '" name="ItemTitle">
                        <input type="hidden" value="' . htmlspecialchars($item["Price"]) . '" name="ItemPrice">
                        <img src="' . htmlspecialchars($item["Image"]) . '" alt="" class="product-img">
                        <h3 class="product-title">' . htmlspecialchars($item["Title"]) . '</h3>
                        <div class="price">$' . htmlspecialchars($item["Price"]) . '</div>
                        <a class="btn add-cart" onclick="redirectCart()">Order Now!</a>
                        </form>
                        
                            </form>
                            </div>
                          </div>';
                    }
                    ?>
                </div>

                <!-- Toggle button -->
                <center>
                    <button id="showHideBtn" class="btn btn-dark">SHOW MORE</button>
                </center>
            </div>
        </div>
    </section>


    <!-- BLOGS SECTION -->


    <?php
    require ('users\db.php'); // Include your database connection file
    
    // Query to fetch all blogs
    $query = "SELECT * FROM blogs";
    $result = mysqli_query($con, $query);

    if ($result) {
        $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $blogs = [];
    }
    ?>
    <section class="blogs" id="blogs">
        <h1 class="heading">Our <span>Blogs</span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <?php foreach ($blogs as $blog): ?>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image">
                                </div>
                                <div class="content">
                                    <a href="<?php echo htmlspecialchars($blog['link']); ?>" target="_blank"
                                        class="title text-decoration-none">
                                        <?php echo htmlspecialchars($blog['title']); ?>
                                    </a>
                                    <span>by <?php echo htmlspecialchars($blog['author']); ?></span>
                                    <p><?php echo htmlspecialchars($blog['description']); ?></p>
                                    <center>
                                        <a href="<?php echo htmlspecialchars($blog['link']); ?>" target="_blank"
                                            class="btn">Read More</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>





    <!-- TESTIMONIALS SECTION -->
    <?php
    require ('users\db.php');
    $query = "SELECT * FROM testimonials";
    $result = mysqli_query($con, $query);

    if ($result) {
        $testimonials = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $testimonials = [];
    }

    ?>
    <section class="review" id="review">
        <h1 class="heading"><span>Testimo</span>nials</h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="col-md-4">
                            <div class="box">
                                <img src="assets/images/quote-img.png" alt="Quote" class="quote">
                                <p>
                                    <?php echo htmlspecialchars($testimonial['content']); ?>
                                </p>
                                <img src="<?php echo htmlspecialchars($testimonial['user_image']); ?>" alt="User"
                                    class="user">
                                <h3><?php echo htmlspecialchars($testimonial['user_name']); ?></h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>


    <!-- CONTACT US SECTION -->
    <section class="contact" id="contact">
        <h1 class="heading"><span>Contact</span> Us</h1>
        <div class="row">

            <form name="contact" method="POST" action="https://formspree.io/f/xbjnbjkj">
                <h3> Get in touch!</h3>
                <div class="inputBox" style="box-shadow: 0 0 25px #e7a891 ; ">
                    <span class="fas fa-envelope"></span>
                    <input type="email" name="email" placeholder="Email Address">
                </div>
                <div class="inputBox">
                    <textarea name="message" placeholder="Enter your message..."
                        style="box-shadow: 0 0 25px #e7a891 ; "></textarea>
                </div>
                <button type="submit" class="btn">Contact Now</button>
            </form>

        </div>
    </section>

    <!-- FOOTER SECTION -->
    <?php require ('users\footer.php'); ?>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper.js and Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>


    <!-- Other scripts -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap"
        async defer></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap"
        async defer></script>


    <script>
        // CODE FOR THE FORMSPREE
        window.onbeforeunload = () => {
            for (const form of document.getElementsByTagName('form')) {
                form.reset();
            }
        }


        // CODE FOR THE SHOW MORE & SHOW LESS BUTTON IN MENU
        $(document).ready(function () {
            $(".row-to-hide").hide();
            $("#showHideBtn").text("SHOW MORE");
            $("#showHideBtn").click(function () {
                $(".row-to-hide").toggle();
                if ($(".row-to-hide").is(":visible")) {
                    $(this).text("SHOW LESS");
                } else {
                    $(this).text("SHOW MORE");
                }
            });
        });

      
        // CODE FOR THE REDIRECT CART
        function redirectCart() {
            // Check if the user is logged in
            if (!"<?php echo isset($_SESSION["email"]) ?>") {
                // Redirect the user to the login page
                alert("You are not logged in. Please log into your account and try again.");
                window.location.href = "users/login.php";
            }
            else
            window.location.href = "ordernowdupp/index.php";
        }
    </script>

</body>

</html>