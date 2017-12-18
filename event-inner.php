<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
include_once ('c-panel/common/functions-admin.php');

$share_url = $_SERVER['REQUEST_URI'];
$url = substr($share_url, strrpos($share_url, "/") + 1);

$display_events = select_specific_event_slug($url);
if(empty($display_events)){
    header("Location: http://www.monksonwheels.com/#getHere");
}
?>

<!DOCTYPE html>
<html>

<head>
    <link type="text/css" rel="stylesheet" href="/css/style.css" media="screen,projection" />
    <link href="/plugins/fancybox/css/jquery.fancybox.css" rel="stylesheet">
    <link href="/font/proxima/stylesheet.css" rel="stylesheet">
    <link href="/plugins/fancybox/css/jquery.fancybox.css" rel="stylesheet">
    <link href="/plugins/owl-carousel/css/owl.carousel.css" rel="stylesheet">
    <link href="/plugins/owl-carousel/css/owl.theme.css" rel="stylesheet">
    <link rel="icon" href="../images/favicon.ico" type="image/gif" sizes="32x32">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>MOW</title>
</head>

<body class="profile-settings scholarship-details">
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
                    <a class="navbar-brand hidden-xs hidden-sm" href="http://monksonwheels.com"><img src="http://monksonwheels.com/images/logo.png" alt="logo" /></a>
                    <a class="navbar-brand hidden-md hidden-lg" href="http://monksonwheels.com"><img src="http://monksonwheels.com/images/logo-mobile.png" alt="logo mobile" /></a>
                    <a class="hidden-sm hidden-md hidden-lg float-right-image blue-btn" href="index.php">Book now</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://monksonwheels.com/about.php">About Us</a></li>
                        <li><a href="http://monksonwheels.com/#getHere">Events</a></li>
                        <li><a href="http://monksonwheels.com/#testimonials">Testimonials</a></li>
                        <!--<li><a href="#">Team</a></li>-->
                        <li><a href="http://monksonwheels.com/contact.php">Contact Us</a></li>
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
        <section class="cover-photo-holder">
        <div class="cover-pic-div">
            <div class="wow fadeIn">
                <div id="owl-demo-2" class="owl-carousel owl-theme">
                    <?php 
                    $array_img = explode(',', $display_events[0]['event_image']);
                    foreach($array_img as $image) {
                    ?>
                    <div class="item">
                        <img class="img-responsive" src="<?php echo $image; ?>" alt="cover photo">
                    </div>
                    <?php }
                    ?>
                </div>
                <div class="customNavigation">
                    <a class="prev2"><span class="sprite left-arr"></span></a>
                    <a class="next2 pull-right"><span class="sprite right-arr"></span></a>
                </div>
            </div>
            <div class="overlay-div">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-6">
                            <div class="inline-block">
                                <h2><?php echo $display_events[0]['title']; ?></h2>
                                <h6>3 days</h6>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-6">
                            <ul class="amount-deadline">
                                <li>
                                    <p>Travel Date</p>
                                    <p>
                                    <?php 
                                        $current = explode('-',$display_events[0]['from_date']);
                                        $date = explode(' ', $current[2]);
                                        $monthName = date("F", mktime(0, 0, 0, $current[1], 10));

                                        $current1 = explode('-', $display_events[0]['to_date']);
                                        $date1 = explode(' ', $current1[2]);
                                        $monthName1 = date("F", mktime(0, 0, 0, $current1[1], 10));
                                        echo $monthName.' '.$date[0].' - '.$monthName1.' '.$date1[0];
                                    ?>   
                                    </p>
                                    <!-- <p>12th - 14th Aug,2017</p> -->
                                </li>
                                <li>
                                    <p>Cost</p>
                                    <p>&#8377; <?php echo $display_events[0]['cost']; ?>/-* per head</p>
                                </li>
                                <li class="fixed-for-bottom-btn">
                                    <a class="blue-small-btn yellow-color-btn" href="https://www.eventshigh.com/bangalore/monks+on+wheels">Book Now</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="settings-holder">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12">
                    <div class="border">
                        <div id="about" class="holders">
                            <h4>About the place</h4>
                            <p><?php echo html_entity_decode($display_events[0]['aboutthatplace']); ?></p>
                        </div>
                        <div id="eligibility" class="holders">
                            <h4>Key highlights</h4>
                            <p><?php echo html_entity_decode($display_events[0]['keyhighlights']); ?></p>
                        </div>
                     <!--   <div id="deadline" class="holders">
                            <h4>Cost</h4>
                            <p>Cost for the trip will be <?php echo $display_events[0]['cost']; ?>INR</p>
                        </div> -->
                        <div id="contact" class="holders">
                            <h4>Contact</h4>
                            <p><?php echo html_entity_decode($display_events[0]['contact']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script type="text/javascript" src="/plugins/jquery/jquery-2.2.1.min.js"></script>
    <script type="text/javascript" src="/plugins/bootstrap/css/assets/javascripts/bootstrap.min.js"></script>
    <script src="/plugins/owl-carousel/js/owl.carousel.min.js" /></script>
    <script>
        var owl2 = $("#owl-demo-2");
        owl2.owlCarousel({
            items: 1, //10 items above 1000px browser width
            itemsDesktop: [1100, 1], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 1], // betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0
            slideSpeed: 500,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
        });
        // Custom Navigation Events
        $(".next2").click(function() {
            owl2.trigger('owl.next');
        });
        $(".prev2").click(function() {
            owl2.trigger('owl.prev');
        });

    </script>
    <script>
    $(window).bind("load", function () {
// $('header').addClass('active');
var type = window.location.hash.substr(1);
$("html, body").animate({scrollTop: $('#' + type).offset().top - 70}, 1000);
});
</script>
</body>

</html>
