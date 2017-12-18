<!-- <?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
include_once ('c-panel/common/functions-admin.php');
$display_events = display_all_current_events();
$display_past_events = display_all_past_events();
?> -->
<!DOCTYPE html>
<html>

<head>
    <link type="text/css" rel="stylesheet" href="css/style.css" media="screen,projection" />
    <link href="plugins/owl-carousel/css/owl.carousel.css" rel="stylesheet">
    <link href="plugins/owl-carousel/css/owl.theme.css" rel="stylesheet">
    <link href="plugins/fancybox/css/jquery.fancybox.css" rel="stylesheet">
    <link href="plugins/animate/css/animate.css" rel="stylesheet">
    <link href="font/proxima/stylesheet.css" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico" type="image/gif" sizes="32x32">
    <meta name="theme-color" content="#0086bf" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>Monks on wheels</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <a class="navbar-brand hidden-xs hidden-sm" href="index.php"><img src="images/logo.png" alt="logo" /></a>
                    <a class="navbar-brand hidden-md hidden-lg" href="index.php"><img src="images/logo-mobile.png" alt="logo mobile" /></a>
                    <a class="hidden-sm hidden-md hidden-lg float-right-image blue-btn" href="index.php">Book now</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://monksonwheels.com/about.php">About Us</a></li>
                        <li><a href="#getHere">Events</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li class="hidden-xs"><a class="blue-btn" href="https://www.eventshigh.com/bangalore/monks+on+wheels">Book now</a></li>
                        <!--<li class="call-li hidden-xs" style="position: relative;">
                            <a class="call-btn" href="tel:080123456"><span class="sprite call"></span></a>
                            <div class="pos-abs" id="call-div">
                                <div class="dialogue-box">
                                    <div class="triangle-holder">
                                        <div class="triangle"></div>
                                    </div>
                                    <p class="doubt">Have a doubt about something on our website?</p>
                                    <p class="bold">Call us at : <span><a class="call-btn" href="tel:080123456">080 - 123456</a></span></p>
                                </div>
                            </div>
                        </li>-->
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    	
 <section class="main-banner-holder">
        <div class="container">
            <div class="content-holder">
                <h2 class="wow fadeInDown">Every Land has a story.<br>Travel. Wander. Discover.</h2>
            </div>
        </div>
    </section>
    <section class="section-three" id="getHere">
        <div class="container">
            <h2 class="head-text wow fadeInDown ">Upcoming events</h2>
            
            <div class="row">
            <?php foreach ($display_events as $details) { 
                $img = explode(",",$details['event_image']);
                $image = str_replace('../', ' ',$img[0]);

                $current = explode('-', $details['from_date']);
                $date = explode(' ', $current[2]);
                $monthName = date("F", mktime(0, 0, 0, $current[1], 10));

                $current1 = explode('-', $details['to_date']);
                $date1 = explode(' ', $current1[2]);
                $monthName1 = date("F", mktime(0, 0, 0, $current1[1], 10));
            ?>
                <div class="col-md-4">
                    <a href="/events/<?php echo $details['slug']; ?>">
                        <div class="awards-holder">
                            <div class="img-holder">
                                <!-- <img src="<?php echo $image; ?>" alt="awards"> -->
                                <img src="<?php echo $image; ?>" alt="awards">
                            </div>
                            <h4><?php echo $details['title']; ?></h4>
                            <?php if($monthName == $monthName1){ ?>
                            <h5><?php echo $monthName.' '.$date[0].' - '.$date1[0]; ?></h5>
                            <?php } else { ?>
                            <h5><?php echo $monthName.' '.$date[0].' - '.$monthName1.' '.$date1[0]; ?></h5>
                            <?php } ?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section-three" id="getHere">
        <div class="container">
            <h2 class="head-text wow fadeInDown ">Past events</h2>
            
            <div class="row">
            <?php foreach ($display_past_events as $details) { 
                $img = explode(",",$details['event_image']);
                $image = str_replace('../', ' ',$img[0]);

                $current = explode('-', $details['from_date']);
                $date = explode(' ', $current[2]);
                $monthName = date("F", mktime(0, 0, 0, $current[1], 10));

                $current1 = explode('-', $details['to_date']);
                $date1 = explode(' ', $current1[2]);
                $monthName1 = date("F", mktime(0, 0, 0, $current1[1], 10));
            ?>
                <div class="col-md-4">
                    <a href="/events/<?php echo $details['slug']; ?>">
                        <div class="awards-holder">
                            <div class="img-holder">
                                <!-- <img src="<?php echo $image; ?>" alt="awards"> -->
                                <img src="<?php echo $image; ?>" alt="awards">
                            </div>
                            <h4><?php echo $details['title']; ?></h4>
                            <?php if($monthName == $monthName1){ ?>
                            <h5><?php echo $monthName.' '.$date[0].' - '.$date1[0]; ?></h5>
                            <?php } else { ?>
                            <h5><?php echo $monthName.' '.$date[0].' - '.$monthName1.' '.$date1[0]; ?></h5>
                            <?php } ?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section-four" id="testimonials">
        <div class="carousel-holder">
            <h2 class="head-text wow fadeInDown">Reviews</h2>
            <div class="wow fadeIn">
                <div id="owl-demo-2" class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                      <!--          <li class="pic-holder">
                                    <img src="images/testimonials/1.jpg" alt="testimonial-image" />
                                </li> -->
                                <li>
                                    <p>Nikitha Surendra</p>
                                    <!--<span>Perspiciatis unde</span>-->
                                </li>
                            </ul>
                            <p class="comment">
                                An amazing weekend at Malnad with Monks on wheels. It was an exhilarating experience with some wonderful people and a lot of fun. Some amazing memories captured. A thrilling trek and fun at the waterfalls. Thanks to Ashwin and Chethan for organizing such an amazing trip and executing it so well. Kudos to all you wonderful people
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                      <!--          <li class="pic-holder">
                                    <img src="images/testimonials/1.jpg" alt="testimonial-image" />
                                </li> -->
                                <li>
                                    <p>Bhumika Khona</p>
                                </li>
                            </ul>
                            <p class="comment">
                                This was my first trip with Monks on wheels.. But I felt I knew them from way ago... Awesome fun, amazing location, excellent stay and the most wonderful set of people to travel with... I love travelling solo, but this one just showed me that you can have fun with a lot of people as well while travelling. Well done Monks !!hope to travel with you all soon again.
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Reshma N Krishna</p>
                                </li>
                            </ul>
                            <p class="comment">
                                Monks on wheels have the best group of people who organises, coordinates and enjoys with passion and seamlessness.Starting from the ice-breaking activity, the trek, rain dance, camp-fire and loads of activities to not get us bored was really awesome. Thank you guys for making this trek so special. Cheers !!!!
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Lavanya Saxena</p>
                                </li>
                            </ul>
                            <p class="comment">
                                Went to Gokarna with this group. The trip was planned in a great way. The organisers' team consists of some of the coolest people!! Keep up the great work Monks on Wheels! I had a wonderful time! Looking forward to more such trips with you!! P.s. I would recommend everyone to travel with these guys!
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Abhipsa Das</p>
                                </li>
                            </ul>
                            <p class="comment">
                                Trip to kudremukh was my first trip and it was really a wonderful one..meeting new people was fun, the best part was trekking with too many people and enjoying the sunrise..Beyond expectation..
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Megha Madhavan</p>
                                </li>
                            </ul>
                            <p class="comment">
                                They redefined travelling for me! The hospitality was very good and they made everyone feel comfortable.would recommend to everyone to travel with these cool Monks
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Keshav Unnikrishnan</p>
                                </li>
                            </ul>
                            <p class="comment">
                                As the name says these monks are very friendly people and feels like I have known them for years ... these school friends are very unique and made me feel like I'm a part of them .. I would really suggest monks on wheels eveny to anyone all around the world
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Chandrashekar Adiga</p>
                                </li>
                            </ul>
                            <p class="comment">
                                Sea sand expedition to Gokarna on last weekend of Feb 2017....really had a gr8 time after a long time...Abhinav & team is really energetic & well organized... Group of 50 for trekking....gr8 initiative... Cheers to monks on wheels...
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Rupal Sinha</p>
                                </li>
                            </ul>
                            <p class="comment">
                                These organizers are really awesome .. they are school friends and made me remember my school days..Nostalgia was hitting hard on me.. If you wanna travel then monks on wheels are the people you need to go with
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-holder">
                            <ul class="name-pic-holder">
                                <li>
                                    <p>Nithyapriya Veeraraghavan</p>
                                </li>
                            </ul>
                            <p class="comment">
                                With the monks, it's not just travel.. It's an experience!! Highly recommended!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="customNavigation">
                    <a class="prev2"><span class="sprite left-arr"></span></a>
                    <a class="next2"><span class="sprite right-arr"></span></a>
                </div>
            </div>
        </div>
    </section>



<!--sponsors-->
 <section class="section-five">
        <div class="carousel-holder">
            <div class="small-container">
                <h2 class="head-text wow fadeInDown">Partners</h2>
                <div id="owl-demo-3" class="owl-carousel owl-theme wow fadeIn">
                    <div class="item">
                        <div class="awards-holder">
                            <div class="img-holder">
                                <img src="images/sponsor/oyo.png" alt="awards" />
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="awards-holder">
                            <div class="img-holder">
                                <img src="images/sponsor/epix.png" alt="awards" />
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="awards-holder">
                            <div class="img-holder">
                                <img src="images/sponsor/doorpix.png" alt="sponsor" />
                            </div>
                        </div>
                    </div>
                     <div class="item">
                        <div class="awards-holder">
                            <div class="img-holder">
                                <img src="images/sponsor/4.jpg" alt="sponsor" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="customNavigation">
                    <a class="prev3"><span class="sprite left-arr"></span></a>
                    <a class="next3"><span class="sprite right-arr"></span></a>
                </div>
            </div>
        </div>
    </section> 

   
    <footer>
        <div class="container">
        <div class="text-center">
        <h5 class="followUs">Follow us</h5>    
        <ul class="social-icons">
                            <li><a href="https://www.facebook.com/Monksonwheels/" target="_blank"><span class="sprite fb"></span></a></li>
                            <li><a href="https://twitter.com/monkswheels/status/883617158512685056" target="_blank"><span class="sprite tweet"></span></a></li>
                            <li><a href="https://www.instagram.com/monksonwheels/" target="_blank"><span class="sprite linkedin"></span></a></li>
                            <li><a href="https://www.youtube.com/channel/UCTmW0OkW6xNlDVz9OYRjuew" target="_blank"><span class="sprite gplus"></span></a></li>
                            
        </ul>
        </div>
            <ul class="footer-links">
                <li class="wow fadeIn" data-wow-delay=".1s"><a href="about.php">ABOUT US</a></li>
                <li class="wow fadeIn" data-wow-delay=".3s"><a href="terms.php">TERMS & CONDITIONS</a></li>
                <li class="wow fadeIn" data-wow-delay=".5s"><a href="privacy.php">PRIVACY POLICY</a></li>
                <li class="wow fadeIn" data-wow-delay=".7s"><a href="contact.php">CONTACT US</a></li>
                <li class="floatr wow fadeIn" data-wow-delay=".9s">
                    
                Copyright &copy; MOW.</li>
            </ul>
        </div>
    </footer>
    <script type="text/javascript" src="plugins/jquery/jquery-2.2.1.min.js"></script>
    <script type="text/javascript" src="plugins/bootstrap/css/assets/javascripts/bootstrap.min.js"></script>
    <script src="plugins/owl-carousel/js/owl.carousel.min.js" /></script>
    <script src="plugins/animate/js/wow.min.js" /></script>
    <script>
        var owl1 = $("#owl-demo-1");
        owl1.owlCarousel({
            items: 3, //10 items above 1000px browser width
            itemsDesktop: [1100, 3], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0
            slideSpeed: 500,
            itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
        });
        // Custom Navigation Events
        $(".next1").click(function() {
            owl1.trigger('owl.next');
        });
        $(".prev1").click(function() {
            owl1.trigger('owl.prev');
        });
        var owl2 = $("#owl-demo-2");
        owl2.owlCarousel({
            items: 4, //10 items above 1000px browser width
            itemsDesktop: [1100, 3], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0
            slideSpeed: 500,
            itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
        });
        // Custom Navigation Events
        $(".next2").click(function() {
            owl2.trigger('owl.next');
        });
        $(".prev2").click(function() {
            owl2.trigger('owl.prev');
        });

        var owl3 = $("#owl-demo-3");
        owl3.owlCarousel({
            items: 3, //10 items above 1000px browser width
            itemsDesktop: [1100, 3], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0
            slideSpeed: 500,
            itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
        });
        // Custom Navigation Events
        $(".next3").click(function() {
            owl3.trigger('owl.next');
        });
        $(".prev3").click(function() {
            owl3.trigger('owl.prev');
        });
        var owl4 = $("#owl-demo-4");
        owl4.owlCarousel({
            items: 4, //10 items above 1000px browser width
            itemsDesktop: [1100, 3], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 3], // betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0
            slideSpeed: 500,
            itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
        });
        // Custom Navigation Events
        $(".next4").click(function() {
            owl4.trigger('owl.next');
        });
        $(".prev4").click(function() {
            owl4.trigger('owl.prev');
        });
    </script>
    <script>
        new WOW().init();
    </script>
    <script>
        if ($(window).width() < 768) {
            $('*').removeClass('wow');
        }
    </script>
</body>

</html>
