<?php 
  session_start(); 
  include('../database/database-connection.php');
  if(empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $id = $_REQUEST['id'];
    $designation = $_POST['designation'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    
    mysqli_query($con,"UPDATE admins SET fname = '$fname', lname = '$lname', designation = '$designation' WHERE admin_id = '$id' ")or die(mysqli_error($con));
    echo "<script type='text/javascript'>alert('Successfully updated admin!');</script>";
    echo "<script>document.location='../page-templates/dashboard.php'</script>";
  }