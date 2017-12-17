<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ob_start();
session_start();
if($_SESSION['lmsadmin'])
{
    $session_check = $_SESSION['lmsadmin']['user_name'];
    $privilege_type=$_SESSION['lmsadmin']['privilege_type'];

}
else if($_SESSION['admin'])
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
    if($privilege_type!=3 && $privilege_type!=2)
    {
       header('Location:index.php');
       exit();
    } 
}
?>
<?php
    include_once('common/lms_page_header.php');
?>
        <section>
            <div>
                <div class="row">
                    <div class="col-lg-12 padding-0">
                        <div class="table-holder">
                            <center><h3 class="pad-btm-25">Contact-Us List</h3></center>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Email ID</th>
                                            <th>Contact Number</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="contact-main">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        include_once('common/page_footer.php');
        ?>
         <script>
             $(document).ready(function() {
                $('.contact').children("ul").slideToggle();
                $('.contact').find('a.toggle-list').addClass('active');
                $('.contact').find('a.toggle-list').append('<span class="sprite right-arrow"></span>');
                search_contact();
            });
            function search_contact() {
                $('.contact-main').html('');
                //        console.log($(text).val());
                //        var q = $(text).val();
                $.ajax({
                    url: 'common/functions-admin.php?action=list_contact',
                    type: 'GET',
                    //            data: 'q=' + q,
                    success: function(res) {
                        var mresp = JSON.parse(res);
                        $('.contact-main').append(mresp.html);
                    }
                });
            }
            </script>
</body></html>
