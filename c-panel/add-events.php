<?php
$success = '';
$failure = '';
$script_ready = '';
/*
 * Save And Updating The Data
 */
error_reporting(E_ALL);

ini_set("display_errors", 0);
ob_start();
include_once('common/functions-admin.php');
session_start();
if ($_SESSION['admin']) {
    $session_check = $_SESSION['admin']['user_name'];
    $privilege_type = $_SESSION['admin']['privilege_type'];
}

if (!$session_check) {
    header('Location:index.php');
    exit();
} else {
    if (($privilege_type != 1) && ($privilege_type != 2)) {
        header('Location:index.php');
        exit();
    } else if ($privilege_type == 2) {
        include_once('common/lms_page_header.php');
    } else if ($privilege_type == 1) {
        include_once('common/page_header.php');
    }
}

if (isset($_POST['submit'])) {
    extract($_POST);
    extract($_FILES);
    $ch_file = $_FILES;
    $ceck_file = $ch_file['fileUpload'];
    $check_file = $ceck_file['name'];
    // if(!empty($check_file[0])){
    // 	print_r("not empty");
    // 	die();
    // }else {
    // 	print_r("empty");
    // 	die();
    // }
    $event_pic = array();
    $way = '../images/event-images/';
    if(!empty($check_file[0])){
	    $files = $_FILES['fileUpload'];
	    for ($i = 0; $i < count($files['name']); $i++) {
	        $_FILES['file']['name'] = $files['name'][$i];
	        $_FILES['file']['type'] = $files['type'][$i];
	        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
	        $_FILES['file']['error'] = $files['error'][$i];
	        $_FILES['file']['size'] = $files['size'][$i];
	        $withou_extn = str_replace($extn, "", $files['name'][$i]);
	        $newFileName = $withou_extn;
	        $uploadPath = "../images/event-images/" . $newFileName;
	        $uploadPath = str_replace(" ", "-", $uploadPath);
	        $image_upload[] = $uploadPath;

	        if (move_uploaded_file($files['tmp_name'][$i], $uploadPath)) {
	//                         $im = new Imagick();
	//                         $im->readImage($uploadPath);
	//                         $im->setImageCompression(imagick::COMPRESSION_LOSSLESSJPEG);
	//                         $im->setImageCompressionQuality(50);
	//                         $va = $im->writeImage($uploadPath);
	//                         return $uploadPath;
	        }
	    }
	}
    // if ($_FILES['image']['error'] == 0 && $_FILES['image']['name'] != '') {
    //     $event_pic = upload_img($image, $way);
    // } else {
    //     $event_pic = $image_name;
    // }
    $title = $_POST['title'];
    if(!empty($check_file[0])){
    	$event_pic = implode(",", $image_upload);
    }else{
    	$event_pic = $_POST['image_name'];
    }
    

    $slug_value = slug(trim($title));

    $data['table'] = 'events';
    $about = htmlentities($aboutthatplace);
    $keyhigh = htmlentities($keyhighlights);
    $cont = htmlentities($contact);

    $temptimestr1 = strtotime($from_date);
    $temp_date1 = date('Y-m-d', $temptimestr1);

    $temptimestr2 = strtotime($to_date);
    $temp_date2 = date('Y-m-d', $temptimestr2);

    $data['fields'] = array('title', 'cost', 'from_date', 'to_date', 'aboutthatplace', 'keyhighlights', 'contact', 'event_image', 'seo_title', 'seo_url', 'seo_image', 'seo_imgtitle', 'seo_description', 'create_date', 'slug','link');
    $data['details'] = array($title, $cost, $temp_date1, $temp_date2, $about, $keyhigh, $cont, $event_pic, $seo_title, $seo_url, $seo_image, $seo_imgtitle, $seo_description, date('Y-m-d H:i:s'), $slug_value,$link);
    $data['edit_id'] = array($edit_id);
    $data['condition'] = ' WHERE `event_id`="' . $edit_id . '"';
    $result = insert_update_data($data);
    if ($result == 1) {
        if ($edit_id == 0) {
            $success = 'Inserted Succesfully';
        } else {
            $success = 'Updated Sucessfully';
            $_REQUEST['edit_id'] = 0;
        }
    } else {
        if ($edit_id == 0) {
            $failure = 'Failed To Insert';
        } else {
            $failure = 'Failed To Update';
        }
    }
}
/*
 * Editing The Data
 */
if (!empty($_REQUEST['edit_id'])) {
    $edit = $_REQUEST['edit_id'];
    $res = select_specific_event($edit);
    extract($res[0]);
}
?>  
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
<div class="col-lg-9 padding-0">
    <div class="right-sec">
        <h3>Add New Events</h3>
<?php if (isset($success) && !empty($success)) {
    echo "<span class='alert alert-custom alert-success'>" . $success . "<a class='alert-success close-alert' onClick='alertClose(this);'>×</a></span>";
} ?>
<?php if (isset($failure) && !empty($failure)) {
    echo "<span class='alert alert-custom alert-danger'>" . $failure . "<a class='alert-failure close-alert' onClick='alertClose(this);'>×</a></span>";
} ?>
        <form role="form" id="subs_blog" name="subs_blog" class="form-inline" action="add-events.php" enctype="multipart/form-data" method="post" >
            <input type="hidden" class="editid" name="edit_id" id="edit_id" value="<?php if (isset($event_id)) echo $event_id;
else echo 0; ?>" />
            <input type="hidden" class="imageid" name="image_name" id="image_name" value="<?php if (isset($event_image)) echo $event_image; ?>" />
            <div class="row">
                <div class="col-lg-6 col-md-6 pad-lft-0">
                    <div class="form-group">
                        <h5>Events Title</h5>
                        <input type="text" placeholder="Enter Title" id="title" name="title" class="form-control checksco" value="<?php
                            if (isset($title))
                                echo $title;
                            else
                                echo '';
                            ?>" required>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 pad-rt-0">
                    <div class="form-group">
                        <h5>Cost</h5>
                        <input type="text" placeholder="Cost" id="cost" name="cost" class="form-control checksco" value="<?php
                            if (isset($cost))
                                echo $cost;
                            else
                                echo '';
                            ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 pad-lft-0">
                    <div class="form-group">
                        <h5>From Date</h5>
                        <input type="text" placeholder="Select From Date" id="from_date" name="from_date" class="form-control checksco" value="<?php
                            if (isset($from_date))
                                echo $from_date;
                            else
                                echo '';
                            ?>" required>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 pad-rt-0">
                    <div class="form-group">
                        <h5>To Date</h5>
                        <input type="text" placeholder="Select To Date" id="to_date" name="to_date" class="form-control checksco" value="<?php
                            if (isset($to_date))
                                echo $to_date;
                            else
                                echo '';
                            ?>" required>
                    </div>
                </div>
            </div>
            <div class="description-packed">
                <div class="description clearfix toselect">
                    <h5>About the place</h5>
                    <textarea id="aboutthatplace" class="form-control value" rows="3" name="aboutthatplace" placeholder="Add Here" required><?php if (isset($aboutthatplace)) {
                                   echo $aboutthatplace;
                               } ?></textarea>
                </div>
            </div>
            <div class="description-packed">
                <div class="description clearfix toselect">
                    <h5>Key Highlights</h5>
                    <textarea id="keyhighlights" class="form-control value" rows="3" name="keyhighlights" placeholder="Add Here" required><?php if (isset($keyhighlights)) {
                                   echo $keyhighlights;
                               } ?></textarea>
                </div>
            </div>
            <div class="description-packed">
                <div class="description clearfix toselect">
                    <h5>Contact</h5>
                    <textarea id="contact" class="form-control value" rows="3" name="contact" placeholder="Add Here" required><?php if (isset($contact)) {
                                   echo $contact;
                               } ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 pad-lft-0">
                    <div class="form-group">
                        <h5>Seo Title</h5>
                        <input type="text" placeholder="Title" id="seo_title" name="seo_title" class="form-control checksco" value="<?php
                            if (isset($seo_title))
                                echo $seo_title;
                            else
                                echo '';
                            ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 pad-rt-0">
                    <div class="form-group">
                        <h5>Seo Description</h5>
                        <textarea class="form-control checksco" rows="3" id="seo_description" name="seo_description"><?php
                            if (isset($seo_description))
                                echo $seo_description;
                            else
                                echo '';
                            ?></textarea>
                    </div>
                </div>

                 <div class="form-group">
                        <h5>Booking link</h5>
                        <input type="text" placeholder="Link" id="link" name="link" class="form-control checksco" value="<?php
                            if (isset($link))
                                echo $link;
                            else
                                echo '';
                            ?>">
                    </div>
            </div>

            <div class="browse toselect">
                <div class="col-lg-7 col-md-6 padding-0">
                    <div class="form-group">
                        <h5>Seo Image Alt</h5>
                        <input type="text" placeholder="Image" id="seo_image" name="seo_image" class="form-control checksco" value="<?php
                            if (isset($seo_image))
                                echo $seo_image;
                            else
                                echo '';
                            ?>">
                    </div>
                    <div class="form-group">
                        <h5>Seo Image Title</h5>
                        <input type="text" placeholder="ImageTitle" id="seo_imgtitle" name="seo_imgtitle" class="form-control checksco" value="<?php
                            if (isset($seo_imgtitle))
                                echo $seo_imgtitle;
                            else
                                echo '';
                            ?>">
                    </div>


                </div>
                <h5>Event Image</h5>
                <a name="file_browse" >
                <input name="fileUpload[]" id="fileUpload" type="file" multiple="multiple"/>
                    <!-- <input type='file' name="image" class="value" id='file_browse' onChange="imgPrev(this);"/> -->
                    <span>Browse</span>
                </a>
                <!-- <img id="img" name="prev" src="<?php if (isset($event_image)) {
                                echo $event_image;
                            } else {
                                echo 'img/brose-doc-img.png';
                            } ?>"/> -->


                    
            </div>

            <div class="buttons pull-right">
                <a><input class="save-publish" type="submit" name="submit" value="Save" /></a>
                <a href="welcome-admin.php"><input class="save" type="button" onClick="CKcancel('subs_blog');" value="Cancel" /></a>
            </div>
        </form>
    </div>
</div>
<?php
include_once('common/page_footer.php');
?>
<script>
    
    $(document).ready(function ()
    {
        CKEDITOR.replace('aboutthatplace', {
            allowedContent: true
        });
        CKEDITOR.replace('keyhighlights', {
            allowedContent: true
        });
        CKEDITOR.replace('contact', {
            allowedContent: true
        });
        document.forms['subs_blog'].reset();
        $('.subs_ex').children("ul").slideToggle();
        $('.subs_ex').find('a.toggle-list').addClass('active');
        $('.subs_ex').find('a.toggle-list').append('<span class="sprite right-arrow"></span>');
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#doc-multiple').multiselect({numberDisplayed: 2});

    });

    $(document).ready(function () {
        $('#cex-multiple').multiselect({numberDisplayed: 2});

    });
</script>
  <script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from_date" )
        .datepicker({
            minDate: 2, 
            maxDate: '+2M'
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to_date" ).datepicker({
        minDate: 2, 
        maxDate: '+2M'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  $(document).ready(function () {
    $("#fileUpload").on('change', function () {
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#image-holder");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            alert("Pls select only images");
        }
    });
});
  </script>
  <script type="text/javascript">
    var con_res = '<?php echo $success; ?>';
        if (con_res) {
            // $('.success').html('<span class="display-success">Contact Registered <span>');
            window.location = 'view-events.php';
        }
  </script>