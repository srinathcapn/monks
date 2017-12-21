<?php
error_reporting(E_ALL);

ini_set("display_errors", 0);
include ('conn.php');
/*
 * Functions
 */

// File Uploading
$action = '';
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}

if ($action == 'contact_details') {
    ini_set("display_errors", 1);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $message = $_POST['message'];
    $query = 'INSERT INTO `contact` (`name`,`email`,`mobile`,`message`)VALUES("' . $name . '","'. $email . '","' . $mobile . '","' . $message . '")';
    $result = mysqli_query($link, $query) or die('Error in Query.' . mysqli_error($link));
    $req_id = mysqli_insert_id($link);
     $email_array = array('veema3008@gmail.com');
        
            for($e=0;$e<count($email_array);$e++)
            {
                $to  =  $email_array[$e];
                $subject = 'Contact Us Enquiry';
                // define the message to be sent. Each line should be separated with \n
                $message = "<html>
                                <body>
                                    <table>
                                        <tr><td>Name</td><td>:</td><td>".$name."</td></tr> 
                                        <tr><td>Phone Number</td><td>:</td><td>".$mobile."</td></tr>
                                        <tr><td>Email</td><td>:</td><td>".$email_id."</td></tr>
                                        <tr><td>Message</td><td>:</td><td>".$message."</td></tr>
                                       
                                    </table>
                                </body>
                            </html>";   
                
                $from='info@monks.com';
                            
                // define the headers we want passed. Note that they are separated with \r\n0
                $headers  = "From: " . strip_tags($from) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($email_id) . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";     
                $mail_sent = mail($to, $subject, $message, $headers);

            } 
    echo json_encode($req_id);
    mysqli_close($link);
}

//login functions
function just_clean($string) {
// Replace other special chars  
    $specialCharacters = array(
        '#' => '',
        '’' => '',
        '`' => '',
        '\'' => '',
        '$' => '',
        '%' => '',
        '&' => '',
        '@' => '',
        '.' => '',
        '€' => '',
        '+' => '',
        '=' => '',
        '§' => '',
        '\\' => '',
        '/' => '',
        '`' => '',
        '•' => '',
        '"' => ''
    );

    while (list($character, $replacement) = each($specialCharacters)) {
        $string = str_replace($character, '', $string);
    }

    $string = strtr($string, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"
    );

    // Remove all remaining other unknown characters   
    $string = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $string);
    $string = preg_replace('/^[\-]+/', '', $string);
    $string = preg_replace('/[\-]+$/', '', $string);
    $string = preg_replace('/[\-]{2,}/', ' ', $string);

    return $string;
}

function paginate($reload, $page, $tpages) {
    $adjacents = 2;
    $prevlabel = "«";
    $nextlabel = "»";
    $out = "";

    // previous
    if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span></li>\n";
    } elseif ($page == 2) {
        $out.="<li><a href=\"" . $reload . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.="<li><a href=\"" . $reload . "&amp;page=" . ($page - 1) . "\">" . $prevlabel . "</a>\n</li>";
    }
    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li class='currentpage'><a href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li><a href=" . $reload . ">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li><a href=" . $reload . "&amp;page=" . $i . ">" . $i . "</a>\n</li>";
        }
    }
    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a href=" . $reload . "&amp;page=" . $tpages . ">" . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li><a href=" . $reload . "&amp;page=" . ($page + 1) . ">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span>" . $nextlabel . "</span></li>\n";
    }
    $out.= "";
    return $out;
}

function login_check() {

    if (isset($_SESSION['user'])) {
        return 1;
    } else {
        session_destroy();
        header('location:login.php');
        exit();
    }
}

if(!empty($_GET['action'])) {
    if ($_GET['action'] == 'chk_pvlg') {
        $user_name = $_GET['user_name'];
        $password =$_GET['password'];
        $privilege=$_GET['login_type'];
       
        $pass = md5($password);
        $query = "select privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if($row['privilege_type']==$privilege){
            $res=true;
        }
        else
        {
            $res=false;
        }
        echo json_encode(array('res'=>$res));
     }
}
/*
*   Code Below For Checking the Admin Login - Validating using ajax call in admin/ index.php 
*/
if (isset($_POST)) {
    extract($_POST);
    if ($action == 'login') {

        $pass = md5($password);
        $query = "select emp_id,emp_name,privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) > 0) {
            $cur_time = date('Y-m-d H:i:s');
            $query1 = "update emp_mst set last_litime='$cur_time' where emp_name='$user_name'";
            mysqli_query($GLOBALS['link'], $query1);

//            session_start();
//            $_SESSION['user'] = md5($user_name . rand());
            $privilege=$row['privilege_type'];
            session_start();
            $curr_admin = array();
            $curr_admin['user_id'] = $row['emp_id'];
            $curr_admin['user_name'] = $row['emp_name'];
            $curr_admin['privilege_type']=$privilege;
            //                $curr_admin['user_email'] = $luser_email;
            $_SESSION['admin'] = $curr_admin;
            setcookie("username", $row['emp_id'], time() + 7600);
           // print_r($_SESSION);exit();

            echo $privilege;
        } elseif ($password == null || $password == '') {
            echo'PWF';
        } else {
            echo'UNF';
        }
    }
}

// LMS Login function
if (isset($_POST)) {
    extract($_POST);
    // print_r($_POST);
    //*** Campign Login Check ***//
    if($action == 'campign_login')
    {
        $pass = md5($password);
        $query = "select emp_id,emp_name,privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) > 0) {
            $cur_time = date('Y-m-d H:i:s');
            $query1 = "update emp_mst set last_litime='$cur_time' where emp_name='$user_name'";
            mysqli_query($GLOBALS['link'], $query1);

//            session_start();
//            $_SESSION['user'] = md5($user_name . rand());
            
            $privilege=$row['privilege_type'];
            session_start();
            $curr_lmsadmin = array();
            $curr_lmsadmin['user_id'] = $row['emp_id'];
            $curr_lmsadmin['user_name'] = $row['emp_name'];
            $curr_lmsadmin['privilege_type']=$privilege;
            //                $curr_admin['user_email'] = $luser_email;
            $_SESSION['lmsadmin'] = $curr_lmsadmin;
            setcookie("username", $row['emp_id'], time() + 7600);
           // print_r($_SESSION);exit();

            echo $privilege;
        } elseif ($password == null || $password == '') {
            echo'PWF';
        } else {
            echo'UNF';
        }
    }

     if ($action == 'lms_login') {
        $pass = md5($password);
        $query = "select emp_id,emp_name,privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) > 0) {
            $cur_time = date('Y-m-d H:i:s');
            $query1 = "update emp_mst set last_litime='$cur_time' where emp_name='$user_name'";
            mysqli_query($GLOBALS['link'], $query1);

//            session_start();
//            $_SESSION['user'] = md5($user_name . rand());
            
            $privilege=$row['privilege_type'];
            session_start();
            $curr_lmsadmin = array();
            $curr_lmsadmin['user_id'] = $row['emp_id'];
            $curr_lmsadmin['user_name'] = $row['emp_name'];
            $curr_lmsadmin['privilege_type']=$privilege;
            //                $curr_admin['user_email'] = $luser_email;
            $_SESSION['lmsadmin'] = $curr_lmsadmin;
            setcookie("username", $row['emp_id'], time() + 7600);
           // print_r($_SESSION);exit();

            echo $privilege;
        } elseif ($password == null || $password == '') {
            echo'PWF';
        } else {
            echo'UNF';
        }
    }
    //**Patient Care Login**///
    if($action == 'pntcare_login')
    {
        $pass = md5($password);
        $query = "select emp_id,emp_name,privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) > 0) {
            $cur_time = date('Y-m-d H:i:s');
            $query1 = "update emp_mst set last_litime='$cur_time' where emp_name='$user_name'";
            mysqli_query($GLOBALS['link'], $query1);

//            session_start();
//            $_SESSION['user'] = md5($user_name . rand());
            
            $privilege=$row['privilege_type'];
            session_start();
            $curr_lmsadmin = array();
            $curr_lmsadmin['user_id'] = $row['emp_id'];
            $curr_lmsadmin['user_name'] = $row['emp_name'];
            $curr_lmsadmin['privilege_type']=$privilege;
            //                $curr_admin['user_email'] = $luser_email;
            $_SESSION['lmsadmin'] = $curr_lmsadmin;
            setcookie("username", $row['emp_id'], time() + 7600);
           // print_r($_SESSION);exit();

            echo $privilege;
        } elseif ($password == null || $password == '') {
            echo'PWF';
        } else {
            echo'UNF';
        }
    }

    if($action == 'saktips_login')
    {
        $pass = md5($password);
        $query = "select emp_id,emp_name,privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) > 0) {
            $cur_time = date('Y-m-d H:i:s');
            $query1 = "update emp_mst set last_litime='$cur_time' where emp_name='$user_name'";
            mysqli_query($GLOBALS['link'], $query1);

//            session_start();
//            $_SESSION['user'] = md5($user_name . rand());
            
            $privilege=$row['privilege_type'];
            session_start();
            $curr_admin = array();
            $curr_admin['user_id'] = $row['emp_id'];
            $curr_admin['user_name'] = $row['emp_name'];
            $curr_admin['privilege_type']=$privilege;
            //                $curr_admin['user_email'] = $luser_email;
            $_SESSION['admin'] = $curr_admin;
            setcookie("username", $row['emp_id'], time() + 7600);
           // print_r($_SESSION);exit();

            echo $privilege;
        } elseif ($password == null || $password == '') {
            echo'PWF';
        } else {
            echo'UNF';
        }
    }

    //**End**//

    //** Career Login **//
    if($action == 'career_login')
    {
        $pass = md5($password);
        $query = "select emp_id,emp_name,privilege_type from emp_mst where emp_name='$user_name' and emp_password='$pass'";
        $result = mysqli_query($GLOBALS['link'], $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) > 0) {
            $cur_time = date('Y-m-d H:i:s');
            $query1 = "update emp_mst set last_litime='$cur_time' where emp_name='$user_name'";
            mysqli_query($GLOBALS['link'], $query1);

//            session_start();
//            $_SESSION['user'] = md5($user_name . rand());
            
            $privilege=$row['privilege_type'];
            session_start();
            $curr_lmsadmin = array();
            $curr_lmsadmin['user_id'] = $row['emp_id'];
            $curr_lmsadmin['user_name'] = $row['emp_name'];
            $curr_lmsadmin['privilege_type']=$privilege;
            //                $curr_admin['user_email'] = $luser_email;
            $_SESSION['lmsadmin'] = $curr_lmsadmin;
            setcookie("username", $row['emp_id'], time() + 7600);
           // print_r($_SESSION);exit();

            echo $privilege;
        } elseif ($password == null || $password == '') {
            echo'PWF';
        } else {
            echo'UNF';
        }
    }
    //**End***//

}

//login functions end

function random_numbers($digits) {
    $min = pow(10, $digits - 1);
    $max = pow(10, $digits) - 1;
    return mt_rand($min, $max);
}

function upload_file() {
    extract($_FILES['doc_image']);
    $name = explode(".", $name);
    $arr = explode("/", $type);
    if ($size >= 2000000) {
        echo 'File size exceed';
        exit();
    } else {
        if ($arr[1] == 'jpg' or $arr[1] == 'jpeg' or $arr[1] == 'png') {
            $img_name = $name[0] . '.' . $arr[1];
            $path = '../images/doctors/' . $img_name;
            move_uploaded_file($tmp_name, $path);
            return $path;
        } else {
            return 'Invalid File Format';
        }
    }
}


if ($action == 'delete_media') {
    extract($GLOBALS);
    $mediaid = $_REQUEST['data'];
    $sel_query = 'UPDATE `media` SET `delete_flag`="1" WHERE `media_id`="' . $mediaid . '"';
    $result = mysqli_query($link, $sel_query);
    echo json_encode($result);
}




//delete blog
if ($action == 'del_blog') {
    extract($GLOBALS);
    $blogid = $_REQUEST['value'];
    $sel_query = 'UPDATE `blogs` SET `delete_flag`="1" WHERE `blog_id`="' . $blogid . '"';
    $result = mysqli_query($link, $sel_query);
    echo json_encode($result);
}

//publish blog
if ($action == 'del_media') {
    extract($GLOBALS);
    $mediaid = $_REQUEST['value'];
    $modi_date = date('Y-m-d H:i:s');
    $sel_query = 'UPDATE `media` SET `delete_flag`="1" WHERE `media_id`="' . $mediaid . '"';
    $result = mysqli_query($link, $sel_query);
    echo json_encode($result);
}

if ($action == 'del_event') {
    extract($GLOBALS);
    $eventid = $_REQUEST['value'];
    $modi_date = date('Y-m-d H:i:s');
    $sel_query = 'UPDATE `events` SET `delete_flag`="1" WHERE `event_id`="' . $eventid . '"';
    $result = mysqli_query($link, $sel_query);
    echo json_encode($result);
}

/*
 * File Uploading
 */

function upload_img($image, $way) {
    extract($_FILES['image']);
    $name = explode(".", $name);
    $arr = explode("/", $type);
    $img_name = $name[0] . '-' . rand(111, 1111) . '.' . $name[1];
    $path = $way.''.$img_name;
    $res=move_uploaded_file($tmp_name, $path);
    return $path;
}

/*
 *  Inserting The Data Into true-Stories, Upcoming-Events, Immportant Announcement and Blog
 */

function insert_update_data($data)
{
    extract($data);
    if ($edit_id[0] == 0) 
    {   
        $query = 'INSERT INTO `'.$table.'`';
        
        $str1=' (';        
        for( $i=0; $i<sizeof($fields);$i++)
        { 
            if($i==0 ) 
            { 
                $str1 .='`'.$fields[$i].'`'; 
            } 
            else 
            { 
                $str1 .=',`'.$fields[$i].'`'; 
            }
        }
        $str1 .=' )';
        
        $str2 ='VALUES ('; 
        for( $k=0; $k<sizeof($details);$k++)
        { 
            if($k==0 ) 
            { 
                $str2 .='"'.$details[$k].'"'; 
            } 
            else 
            { 
                $str2 .=',"'.$details[$k].'"'; 
            }
        }
        $str2 .=' )';
        
        //echo this ins query to see the complete query
        $ins_query = $query.$str1.$str2;
          return ( mysqli_query($GLOBALS['link'],$ins_query) );
    }
    else
    {
        $query = 'UPDATE `'.$table.'` SET';
        
        $str ='';
        for( $i=0; $i<sizeof($fields);$i++)
        { 
            if($i==0 ) 
            { 
                $str .='`'.$fields[$i].'` =  "'.$details[$i].'"'; 
            } 
            else 
            { 
                $str .=', `'.$fields[$i].'` =  "'.$details[$i].'"'; 
            }
        }

        $ins_query = $query.$str.$condition;
        
        return( mysqli_query($GLOBALS['link'],$ins_query));
    }
    
}

/*
 * Display All Values
 */

function display_blog() 
{
    extract($GLOBALS);
    $query = "SELECT * FROM `blog` WHERE blog_delete='N' ORDER BY `blog_id` DESC ";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $arr[] = $row;
    }
    return $arr;
}
 
function select_specific_blog($edit)
{
    extract($GLOBALS);
    $query = "SELECT * FROM `blogs` WHERE blog_id=$edit";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result))
    {
        $arr[] = $row;
    }
    return($arr);
}

function select_specific_media($edit)
{
    extract($GLOBALS);
    $query = "SELECT * FROM `media` WHERE media_id=$edit";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result))
    {
        $arr[] = $row;
    }
    return($arr);
}

function select_specific_event($edit)
{
    extract($GLOBALS);
    $query = "SELECT * FROM `events` WHERE event_id=$edit";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result))
    {
        $arr[] = $row;
    }
    return($arr);
}

function select_specific_event_slug($slug)
{
    extract($GLOBALS);
    $query = "SELECT * FROM `events` WHERE slug='$slug' and delete_flag='0'";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result))
    {
        $arr[] = $row;
    }
    return($arr);
}

function display_blogs() 
{
    extract($GLOBALS);
    $query = "select * from blogs where delete_flag = 0 ORDER BY blog_id DESC";
    // $query = "SELECT a.*,b.`cex_name` FROM `speciality_extrablog` AS a JOIN `center_ex_mst` AS b 
    // WHERE a.`spl_blogdelete`=0 AND a.`spl_cexid`= b.`cex_id` ORDER BY a.`spl_blogid` DESC";
    $result = mysqli_query($link, $query) or die('Error querying database.');

    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $arr[] = $row;
    }
    return $arr;
}

/*
* Function for contact admin
*/
if(isset($_GET['action']))
{
    if($_GET['action']=='list_contact'){
        extract($GLOBALS);
        $query = "SELECT * FROM `contact` order by `id` desc";
        $res=mysqli_query($link,$query);
        $arr = array();
        while ($rows = mysqli_fetch_assoc($res)) {
            $arr[] = $rows;
        }
        $html = '';
        foreach ($arr as $key => $row) {
            $key = $key + 1;
            $time=$row['date'];
            $date_str = explode(' ',$time);
            $dtime= explode('-',$date_str[0]);
            $time_format = $dtime[2] . '/' . $dtime[1] . '/' . $dtime[0];
            $html.='<tr id=' . $row['id'] . '>';
            $html.='<td>' . $key . '</td>';
            $html.='<td>' . $time_format . '</td>';
            $html.='<td>' . $row['name'] . '</td>';
            $html.='<td>' . $row['email'] . '</td>';
            $html.='<td>' . $row['mobile'] . '</td>';
            $html.='<td>' . $row['message'] . '</td>';
            $html.='</tr>';
        }
        $results['html'] = $html;
        echo json_encode($results);
    }
}

//Function View Media Details Starts
function display_all_media() {
    extract($GLOBALS);
    $query = "select * from media where delete_flag = 0 ORDER BY media_id DESC";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    return($arr);
}
//Function View Media Details Ends

//Function View event Details Starts
function display_all_events() {
    extract($GLOBALS);
    $query = "select * from events where delete_flag = 0 ORDER BY event_id DESC";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    return($arr);
}
//Function View event Details Ends

//Function View current event Details Starts
function display_all_current_events() {
    extract($GLOBALS);

    $query = "SELECT * FROM events WHERE `from_date` >= DATE(NOW()) and delete_flag = 0 ORDER BY event_id DESC";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    return($arr);
}
//Function View current event Details Ends

//Function View past event Details Starts
function display_all_past_events() {
    extract($GLOBALS);

    $query = "SELECT * FROM events WHERE `from_date` < DATE(NOW()) and delete_flag = 0 ORDER BY event_id DESC";
    $result = mysqli_query($link, $query) or die('Error querying database.');
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    return($arr);
}
//Function View past event Details Ends

//function for creating slug
function slug($var) {
    $var = preg_replace('/[^a-zA-Z0-9]/s', ' ', $var);
    $var = preg_replace('/\s+/', '-', $var);
    return strtolower($var);
}
?>
