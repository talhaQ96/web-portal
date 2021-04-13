<?php 
  session_start(); 
  include('../database/database-connection.php');
  if(empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $code = $_REQUEST['id'];
    $cr_hrs = $_POST['cr_hrs'];
    $cname = $_POST['cname'];
    $semester = $_POST['semester_no'];

    mysqli_query($con,"UPDATE courses SET cr_hrs = '$cr_hrs', c_name = '$cname', semester = '$semester' WHERE code = '$code'")or die(mysqli_error($con));
    echo "<script type='text/javascript'>alert('Successfully updated course!');</script>";
    echo "<script>document.location='../page-templates/dashboard.php'</script>";
  }