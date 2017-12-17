<?php
error_reporting(E_ALL);

ini_set("display_errors", 0);
ob_start();
include_once('common/functions-admin.php');
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
    else if($privilege_type==2)
    {
        include_once('common/lms_page_header.php');
    }
    else if($privilege_type==1)
    {
        include_once('common/page_header.php');
    } 
}
     
    $per_page = 10;
    $sql = "SELECT count(blog_id) FROM blogs where delete_flag=0 ";
    $retval = mysqli_query( $GLOBALS['link'], $sql );
    $row = mysqli_fetch_array ($retval);
    $page = 0;
    $total_pages = ceil(($row[0]) / ($per_page)); //total pages we going to have
    //-------------if page is setcheck------------------//
    if (isset($_GET['page'])) 
    {
        $show_page = $_GET['page']; //current page
        if ($show_page > 0 && $show_page <= $total_pages) 
        {
            $start = ($show_page - 1) * $per_page;
            $end = $start + $per_page;
        } 
        else 
        {
    // error - show first set of results
            $start = 0;
            $end = $per_page;
        }
    } 
    else 
    {
    // if page isn't set, show first set of results
        $start = 0;
        $end = $per_page;
        $show_page=1;
    }
    // display pagination
    $page = intval($_GET['page']);
    $tpages = $total_pages;
    if ($page <= 0)
        $page = 1;

    $details = display_blogs();
?>
<style>
    .pagination-sm li.currentpage a
    {
        color: #fff;
        background-color: #369;
    }
</style>

<div class="col-lg-9 padding-0">
    <div class="right-sec">
        <h3>View Blogs</h3>
        <div class="table-holder">
            <div class="table-responsive">
                <?php
                    echo '<table class="table">
                            <thead>
                                <tr>
                                    <th width="11%">S.No</th>
                                    <th width="31%">Blog Title</th>
                                    <th width="31%">Blog Image</th>
                                    <th width="25%">SEO Status</th>
                                    <th width="9%">Edit</th>
                                    <th width="13%">Delete</th>
                                </tr>
                            </thead>
                            <tbody>';
                        for ($i = $start; $i < $end; $i++) 
                        {
                            if ($i == $row[0]) 
                            {                                
                                break;
                            }
                            if($details[$i]['seo_title'])
                            {
                                $seo_title="Done";
                            }else{
                                $seo_title="Not Done";
                            }
                            echo'<tr id="row_'.$details[$i]['spl_cexid'].'">
                                <td>'.($i + 1).'</td>
                                <td>'.$details[$i]['blog_title'].'</td>
                                <td><img class="img_size" src="'.$details[$i]['blog_image'].'"></td>
                                <td>'.$seo_title.'</td>';      
                            echo '<td class="button-holder"><a href=add-blog.php?edit_id='.$details[$i]['blog_id'].'>Edit</a></td>
                                <td class="button-holder"><a class="del_class_blog" href="javascript:;" id='.$details[$i]['blog_id'].'>Delete</a></td>
                            </tr>';
                        }
                        echo '</tbody>
                    </table>';
                    $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
                     $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
                    echo '<div style="float:right;">
                            <ul class="pagination pagination-sm">';
                                if ($total_pages >= 0) 
                                {
                                    echo paginate($reload, $show_page, $total_pages);
                                }
                        echo "</ul>
                    </div>";
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('common/page_footer.php');     
?>      
<script type="text/javascript">
   $(document).ready(function() {
 $('.subv_ex').children("ul").slideToggle();
         $('.subv_ex').find('a.toggle-list').addClass('active');
        $('.subv_ex').find('a.toggle-list').append('<span class="sprite right-arrow"></span>');
    });
</script>