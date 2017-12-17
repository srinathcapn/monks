
<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
//include_once('common/page_header.php');
session_start();
$session_check = $_SESSION['admin']['user_name'];
@$privilege_type=$_SESSION['admin']['privilege_type'];

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
        <section>
            <div class="container">
                <div class="login-holder">
                    <div align="center"><img  src="img/logo.png"></div>
                    <div align="center" class="login">
                        <h3>Admin Login </h3>
                        <p id="error"></p>
                        <form action="login_function.php" method="post" name="frm_login" id="frm_login"> 
                            <div class="form-group">
                                <input type="hidden" placeholder="user name" name="action" id="action" value="login" class="form-control">
                                <input type="text" placeholder="user name" name="user_name" id="user_name" class="form-control">
                                <input type="password" placeholder="password" name="password" id="password" class="form-control">
                                <select class="form-control" id="login_type" name="login">
                                    <option value=0>Select</option>
                                    <option value=1>Admin</option>
                                    <option value=2>LMS</option>
                                  
                                </select>
                            </div>
                            <a href="javascript:;" id="login" onclick="admin_login()">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
        <script src="js/bootstrap.min.js"></script>
        <script>
                             
                                function admin_login() {
                                    console.log('hjere');
                                    var data = $('#frm_login').serialize();
                                    var username=$('#user_name').val();
                                    var password=$('#password').val();
                                    var login_type=$('#login_type').val();
                                    $.ajax({
                                            type: "GET",
                                            async: true,
                                            url: 'common/functions-admin.php?action=chk_pvlg',
                                            data: {user_name:username,password:password,login_type:login_type },
                                            dataType:'json',
                                            success: function(response)
                                            {
                                                $(".error-msg").remove();
                                                 
                                                var result=response.res;
                                                if(result)
                                                {
                                                     $.ajax({
                                                        type: "POST",
                                                        async: true,
                                                        url: 'common/functions-admin.php?action=login',
                                                        data: data,
                                                        dataType:'json',
                                                        success:function(response){
                                                            if(response==1)
                                                            {
                                                                window.location = 'welcome-admin.php';
                                                            }
                                                            else
                                                            {
                                                                window.location = 'welcome-lms.php';
                                                            }
                                                        }
                                                    });

                                                }
                                                 else
                                                {
                                                    $('#login_type').after('<span class="error-msg"> Sorry you dont have the privilege to access</span>');
                                                }
                                            }
                                        });
                                }

                                var lgn = document.getElementById("user_name");
                                
                                lgn.addEventListener("keydown", function(e) {
                                    if (e.keyCode === 13) {
                                        admin_login();
                                    }
                                });
                                var pwd = document.getElementById("password");
                                pwd.addEventListener("keydown", function(e) {
                                    if (e.keyCode === 13) {
                                        admin_login();
                                    }
                                });
          
        </script>
    </body>
</html>

