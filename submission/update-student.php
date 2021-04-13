<?php 
  session_start(); 
  include('../database/database-connection.php');
  if(empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $id = $_REQUEST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];

    mysqli_query($con,"UPDATE students SET fname = '$fname', lname = '$lname', semester = '$semester', year = '$year' WHERE student_id = '$id' ")or die(mysqli_error($con));
    echo "<script type='text/javascript'>alert('Successfully updated student!');</script>";
    echo "<script>document.location='../page-templates/dashboard.php'</script>";
  }