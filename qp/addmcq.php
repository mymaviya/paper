<?php include ('includes/connection.php'); 
include "includes/adminheader.php";
if (isset($_SESSION['role'])) {
$currentrole = $_SESSION['role'];
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
                <h3 align="center" class="page-header">Add New Multiple Choice Question(MCQ) </h3>
            </div>
            
        </div>
                            
            <!-- Page Content -->
            <div class="blank-page-content">

                <!-- Page Info -->
                <div class="outer-w3-agile mt-3">
<?php
if($currentrole !='superadmin'){ echo "<script>alert('Coming Soon!');
    window.location.href= 'index.php';</script>"; }    
    

if (isset($_POST['addmcq'])) {
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $book = $_POST['book'];
    $lesson = $_POST['lesson'];
    $ques = $_POST['ques'];
    $opt_A = $_POST['opta'];
    $opt_B = $_POST['optb'];
    $opt_C = $_POST['optc'];
    $opt_D = $_POST['optd'];
    $ans = $_POST['ans'];
    $qus_level = $_POST['qus_level'];
    
    
    $query = "INSERT INTO mcqs(class_id, subject_id, book_id, ln_id, question, opt_a, opt_b, opt_c, opt_d, ans_id, level_id) VALUES ('$class' ,'$subject' , '$book' , '$lesson' , '$ques', '$opt_A','$opt_B','$opt_C','$opt_D','$ans','$qus_level') ";
    $result = mysqli_query($conn , $query) or die(mysqli_error($conn)); 
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> alert('Question added successfully.It will be published after admin approves it');                
        window.location.href='addmcq.php';</script>";
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

        <label class="mb-2 mr-sm-4 col-md-1">Book</label>
            <select class="form-control mb-2 mr-sm-3 col-md-2" name="book" id="book" required>
                <option selected disabled value="">Select Book</option>
            </select>


    </div>
    <div class="form-inline">
        <label class="mb-2 mr-sm-4 col-md-1">Lesson</label>
        <select class="form-control mb-2 mr-sm-3 col-md-9" name="lesson" id="lesson" required>
                <option selected disabled value="">Select Lesson Name</option>
            </select>
    </div>
    <div class="form-inline">
        <label class="mb-2 mr-sm-4 col-md-1">Question</label>
        <input type="text" name="ques" placeholder = "Question" value= "<?php if(isset($_POST['publish'])) { echo $post_lnname; } ?>"  class="form-control mb-2 mr-sm-3 col-md-9" required>
    </div> 
    <div class="form-inline">
        <label class="mb-2 mr-sm-4 col-md-1">Option: A)</label>
        <input type="text" name="opta" placeholder = "Question" value= "<?php if(isset($_POST['publish'])) { echo $post_lnname; } ?>"  class="form-control mb-2 mr-sm-3 col-md-4" required>
        <label class="mb-2 mr-sm-4 col-md-1">Option: B)</label>
        <input type="text" name="optb" placeholder = "Question" value= "<?php if(isset($_POST['publish'])) { echo $post_lnname; } ?>"  class="form-control mb-2 mr-sm-3 col-md-4" required>
    </div>
    <div class="form-inline">
        <label class="mb-2 mr-sm-4 col-md-1">Option: C)</label>
        <input type="text" name="optc" placeholder = "Question" value= "<?php if(isset($_POST['publish'])) { echo $post_lnname; } ?>"  class="form-control mb-2 mr-sm-3 col-md-4" required>
        <label class="mb-2 mr-sm-4 col-md-1">Option: D)</label>
        <input type="text" name="optd" placeholder = "Question" value= "<?php if(isset($_POST['publish'])) { echo $post_lnname; } ?>"  class="form-control mb-2 mr-sm-3 col-md-4" required>
    </div>
    <div class="form-inline">
        <label class="mb-2 mr-sm-4 col-md-1">Answer:</label>
        <?php
        $query = $conn->query("SELECT * FROM mcq_options WHERE status=1");
                $rowCount = $query->num_rows;
                ?>
        <select class="form-control mb-2 mr-sm-3 col-md-4" name="ans" id="ans" required>
            <option selected disabled value="">Select Answer</option>
                <?php
                    if($rowCount > 0){
                        while($row = $query->fetch_assoc()){ 
                            echo '<option value="'.$row['option_ID'].'">'.$row['option_name'].'</option>';
                            }
                        }else{
                            echo '<option value="">Category not available</option>';
                        }
                    ?>
        </select>
        <label class="mb-2 mr-sm-4 col-md-1">Ques Level: </label>
        <?php
        $query = $conn->query("SELECT * FROM level WHERE status=1");
                $rowCount = $query->num_rows;
                ?>
        <select class="form-control mb-2 mr-sm-3 col-md-4" name="qus_level" required>
            <option selected disabled value="">Select Question Level</option>
                <?php
                    if($rowCount > 0){
                        while($row = $query->fetch_assoc()){ 
                            echo '<option value="'.$row['level_id'].'">'.$row['level'].'</option>';
                            }
                        }else{
                            echo '<option value="">Category not available</option>';
                        }
                    ?>
        </select>
    </div>
    <br>

    
   
    <div class="form-group">
        <div class="col-md-8">
            <button type="submit" name="addmcq" class="btn btn-primary" value="Add"> Add </button>
        </div>
    </div>

</form>
                </div>
                <!--// Page Info -->


            </div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#class').on('change',function(){
        var classID = $(this).val();
        if(classID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'class_id='+classID,
                success:function(html){
                    $('#subject').html(html);
                    $('#book').html('<option value="">Select subject first</option>');
                    $('#lesson').html('<option value="">Select Book first</option>');
                }
            }); 
        }else{
            $('#subject').html('<option value="">Select class first</option>'); 
        }
    });

    $('#subject').on('change',function(){
        var bookID = $(this).val();
        if(bookID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'book_id='+bookID,
                success:function(html){
                    $('#book').html(html);
                }
            }); 
        }else{
            $('#book').html('<option value="">Select subject first</option>'); 
        }
    });

    $('#book').on('change',function(){
        var lessonID = $(this).val();
        if(lessonID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'lesson_id='+lessonID,
                success:function(html){
                    $('#lesson').html(html);
                }
            }); 
        }else{
            $('#lesson').html('<option value="">Select Book first</option>'); 
        }
    });

});
    </script>
            <!-- Footer -->
            <?php include ('includes/adminfooter.php');  ?>
            <!--// Footer -->
