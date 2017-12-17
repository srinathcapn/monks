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
    $blog_pic = array();
    $way = '../images/blog-images/';
    if ($_FILES['image']['error'] == 0 && $_FILES['image']['name'] != '') {
        $blog_pic = upload_img($image, $way);
    } else {
        $blog_pic = $image_name;
    }
    $blog_title = $_POST['title'];
    
    $slug_value = slug(trim($blog_title));

    $data['table'] = 'blogs';
    $desc = htmlentities($description);
    $data['fields'] = array('blog_title', 'blog_image', 'blog_description', 'seo_title', 'seo_image', 'seo_imgtitle', 'seo_description', 'create_date', 'slug');
    $data['details'] = array($title, $blog_pic, $desc, $seo_title, $seo_image, $seo_imgtitle, $seo_description, date('Y-m-d H:i:s'), $slug_value);
    // print_r($data['details']);
    // die();
    $data['edit_id'] = array($edit_id);
    $data['condition'] = ' WHERE `blog_id`="' . $edit_id . '"';
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
    if ($edit != 0) {
        $res = select_specific_blog($edit);
        extract($res[0]);
    }
}
?>  
<div class="col-lg-9 padding-0">
    <div class="right-sec">
        <h3>Add New Blog</h3>
<?php if (isset($success) && !empty($success)) {
    echo "<span class='alert alert-custom alert-success'>" . $success . "<a class='alert-success close-alert' onClick='alertClose(this);'>×</a></span>";
} ?>
<?php if (isset($failure) && !empty($failure)) {
    echo "<span class='alert alert-custom alert-danger'>" . $failure . "<a class='alert-failure close-alert' onClick='alertClose(this);'>×</a></span>";
} ?>
        <form role="form" id="subs_blog" name="subs_blog" class="form-inline" action="add-blog.php" enctype="multipart/form-data" method="post" >
            <input type="hidden" class="editid" name="edit_id" id="edit_id" value="<?php if (isset($blog_id)) echo $blog_id;
else echo 0; ?>" />
            <input type="hidden" class="imageid" name="image_name" value="<?php if (isset($blog_image)) echo $blog_image; ?>" />
            <div class="row">


                
                



                <div class="col-lg-6 padding-0">
                    <h4 class="txt-padding">Blog Title</h4>  
                    <div class="form-group toselect">
                        <input type="text" placeholder="Enter Title" name="title" id="title" class="form-control value" value="<?php if (isset($blog_title)) echo $blog_title; ?>" onkeypress ="return onlyAlphabets(event);" required/>
                    </div>
                </div>
            </div>
            <div class="description-packed">
                <div class="description clearfix toselect">
                    <h5>Blog Description</h5>
                    <textarea id="text_descrip" class="form-control value" rows="3" name="description" placeholder="Add Here" required><?php if (isset($blog_description)) {
                                   echo $blog_description;
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
                <h5>Blog Image</h5>
                <a name="file_browse" >
                    <input type='file' name="image" class="value" id='file_browse' onChange="imgPrev(this);" required/>
                    <span>Browse</span>
                </a>
                <img id="img" name="prev" src="<?php if (isset($blog_image)) {
                                echo $blog_image;
                            } else {
                                echo 'img/brose-doc-img.png';
                            } ?>"/>
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
        CKEDITOR.replace('description', {
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