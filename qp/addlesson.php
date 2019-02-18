<?php include ('includes/connection.php'); 
include "includes/adminheader.php";
if (isset($_SESSION['role'])) {
$currentrole = $_SESSION['role'];
$catID = $_SESSION['category'];
}
?>
<style type="text/css">
    label {
        font-weight: bold;
    }
</style>
<div class="wrapper">
<?php include ('includes/sidenav.php');?>
            <!--// top-bar -->
        <div class="row">
            <div class="col-md-12">
                <h3 align="center" class="page-header">Add New Lesson</h3>
            </div>
            
        </div>
                            
            <!-- Page Content -->
            <div class="blank-page-content">

                <!-- Page Info -->
                <div class="outer-w3-agile mt-3">
<?php
if($currentrole !='superadmin'){ echo "<script>alert('Coming Soon!');
    window.location.href= 'index.php';</script>"; }    
    
$post_catg = "";
if (isset($_POST['publish'])) {
    if($_POST['class']=='1' || $_POST['class']=='2' || $_POST['class']=='3'){ $post_catg='1'; }
    elseif($_POST['class']=='4' || $_POST['class']=='5' || $_POST['class']=='6' || $_POST['class']=='7' || $_POST['class']=='8'){ $post_catg='2'; }
    elseif($_POST['class']=='9' || $_POST['class']=='10' || $_POST['class']=='11'){ $post_catg='3'; }
    elseif($_POST['class']=='12' || $_POST['class']=='13'){ $post_catg='4'; }else{$post_catg='5';}
    $post_class = $_POST['class'];
    $post_subject = $_POST['subject'];
    $post_lnname = $_POST['ln_name'];
    $post_lnno = $_POST['ln_no'];
    $post_author= $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];  
    $post_status = 'draft';
    $post_content = $_POST['content'];
    $post_date = date('Y-m-d');
    
    $query = "INSERT INTO tabl_main (category,class,sub,ln_no,ln_name,content,author,crdate,status) VALUES ('$post_catg' ,'$post_class' , '$post_subject' , '$post_lnno' , '$post_lnname', '$post_content','$post_author','$post_date','$post_status') ";
    $result = mysqli_query($conn , $query) or die(mysqli_error($conn)); 
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> alert('Lesson added successfully.It will be published after admin approves it');                 window.location.href='lessons.php';</script>";
        }
        else {
            "<script> alert('Error while posting..try again');</script>";
        }
    }
?>                

<form role="form" action="" method="POST" enctype="multipart/form-data">

    <div class="form-inline">
        <label class="mb-2 mr-sm-4 col-md-1">Class</label>
        <?php
              include 'includes/connection.php';
                if($currentrole == 'superadmin'){
                $statement = "classes WHERE status=1"; } else {
                $statement = "classes WHERE category_id=$catID AND status=1";} 
                $query = $conn->query("SELECT * FROM {$statement}");
                $rowCount = $query->num_rows;
                ?>
            <select class="form-control mb-2 mr-sm-3 col-md-2" name="class" id="class" required>
                <option selected disabled value="">Select Class</option>
                    <?php
                        if($rowCount > 0){
                            while($row = $query->fetch_assoc()){ 
                                echo '<option value="'.$row['class_id'].'">'.$row['class_name'].'</option>';
                            }
                        }else{
                            echo '<option value="">Category not available</option>';
                        }
                    ?>
            </select>

        <label class="mb-2 mr-sm-4 col-md-1">Subject </label>
            <select class="form-control mb-2 mr-sm-3 col-md-2" name="subject" id="subject" required>
                <option selected disabled value="">Select Subject</option>
            </select>

        <label class="mb-2 mr-sm-4 col-md-1">Ln No. </label>
            <input type="text" name="ln_no" placeholder = "Lesson No. " value= "<?php if(isset($_POST['publish'])) { echo $post_lnno; } ?>"  class="form-control mb-2 mr-sm-3 col-md-2" required>


    </div>
    <br>
    <div class="form-inline">
        
        <label class="mb-2 mr-sm-4 col-md-1">Lesson Name</label>
        <input type="text" name="ln_name" placeholder = "Lesson Name" value= "<?php if(isset($_POST['publish'])) { echo $post_lnname; } ?>"  class="form-control mb-2 mr-sm-3 col-md-6" required>
    </div> 
    <br>
    
    <div class="form-group">
        <div class="col-md-12 ">
            <label for="post_content">Lesson Description</label>
        </div>
        <div class="col-md-12" >
            <textarea name="content" cols="100" rows="15">Add your content that will be editable.</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8">
            <button type="submit" name="publish" class="btn btn-primary" value="Add Lesson">Add Lesson</button>
        </div>
    </div>

</form>
                </div>
                <!--// Page Info -->


            </div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#category').on('change',function(){
        var categoryID = $(this).val();
        if(categoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'category_id='+categoryID,
                success:function(html){
                    $('#class').html(html);
                    $('#subject').html('<option value="">Select class first</option>'); 
                }
            }); 
        }else{
            $('#class').html('<option value="">Select category first</option>');
            $('#subject').html('<option value="">Select class first</option>'); 
        }
    });
    
    $('#class').on('change',function(){
        var classID = $(this).val();
        if(classID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'class_id='+classID,
                success:function(html){
                    $('#subject').html(html);
                }
            }); 
        }else{
            $('#subject').html('<option value="">Select class first</option>'); 
        }
    });
});
    </script>
            <!-- Footer -->
            <?php include ('includes/adminfooter.php');  ?>
            <!--// Footer -->
