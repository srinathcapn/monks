<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
include_once('common/functions-admin.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/master.css" rel="stylesheet" type="text/css">
        <link href="css/developer.css" rel="stylesheet" type="text/css">
        <title>Admin</title>
    </head>

    <body>
        <header role="banner" id="top" class="custom-head navbar navbar-static-top bs-docs-nav">
            <div class="container">
                <div class="navbar-header"> <a class="navbar-brand" href="#"><img src="img/logo.png"></a> </div>

                <span id="span"></span>
                
                <nav role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <h4>Welcome Admin</h4>
                        </li>
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" role="button" id="drop2" href="#"><b class="caret"></b></a>
                            <ul aria-labelledby="drop2" role="menu" class="dropdown-menu">
                                <!-- <li role="presentation"><a href="#" tabindex="-1" role="menuitem">Settings</a></li> -->
                                <li role="presentation"><a href="logout.php" tabindex="-1" role="menuitem">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 padding-0">
                        <aside>
                            <ul>
                                <div id="toggle">
                                    <li class="ul-list server"><a href="javascript:;" class="toggle-list"><span class="sprite server"></span><span class="text-holder">Blogs</span></a>
                                        <ul class="sub-list">
                                            <li><a href="add-blog.php">Add Blogs</a></li>
                                            <li><a href="view-blog.php">View Blogs</a></li>
                                        </ul>
                                    </li>
                                    <li class="ul-list server"><a href="javascript:;" class="toggle-list"><span class="sprite server"></span><span class="text-holder">Media</span></a>
                                        <ul class="sub-list">
                                            <li><a href="add-media.php">Add Media</a></li>
                                            <li><a href="view-media.php">View Media</a></li>
                                        </ul>
                                    </li>
                                    <li class="ul-list server"><a href="javascript:;" class="toggle-list"><span class="sprite server"></span><span class="text-holder">Events</span></a>
                                        <ul class="sub-list">
                                            <li><a href="add-events.php">Add Events</a></li>
                                            <li><a href="view-events.php">View Events</a></li>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </aside>
                    </div>
