<?php 
  session_start(); 
  include('../database/database-connection.php');
  if(empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $room_no = $_REQUEST['id'];
    $floor_no = $_POST['floor_no'];
    $room_capacity = $_POST['room_capacity'];
    $room_type = $_POST['room_type'];

    mysqli_query($con,"UPDATE rooms SET floor_no = '$floor_no', room_capacity = '$room_capacity', room_type = '$room_type' WHERE room_no = '$room_no'")or die(mysqli_error($con));
    echo "<script type='text/javascript'>alert('Successfully updated room!');</script>";
    echo "<script>document.location='../page-templates/dashboard.php'</script>";
  }