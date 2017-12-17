<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
session_start();
if($_SESSION['admin'])
{
$session_check = $_SESSION['admin']['user_name'];
$privilege_type=$_SESSION['admin']['privilege_type'];
}

if(!$session_check)
{
    header('Location:index.php');
    exit();
}
else
{
    if(($privilege_type!=1) &&($privilege_type!=2))
    {
       header('Location:index.php');
       exit();
    } 
    if($privilege_type==1)
    {
      header('Location:index.php');
       exit();
    } 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/master.css" rel="stylesheet" type="text/css">
<title>Admin</title>
</head>

<body>
<header role="banner" id="top" class="custom-head navbar navbar-static-top bs-docs-nav">
  <div class="container">
    <div class="navbar-header"> <a class="navbar-brand" href="#"><img src="img/logo.png"></a> </div>
    <nav role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <h4>Welcome Admin</h4>
        </li>
        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" role="button" id="drop2" href="#"><b class="caret"></b></a>
          <ul aria-labelledby="drop2" role="menu" class="dropdown-menu">
            <li role="presentation"><a href="logout.php" tabindex="-1" role="menuitem">Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</header>
<section>
  <div class="container">
    <div  class="welcome-holder">
    <h3>Welcome Admin</h3>
    <ul class="choose">
        
        <li><a href="contact-us.php" class="contact-big"><span class="sprite1"></span>Contact List</a></li>
        
    </ul>
    </div>
  </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>