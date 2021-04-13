<?php 
  include('../database/database-connection.php'); 
  if (empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $room_no = $_POST['room_no'];
    $floor_no = $_POST['floor_no'];
    $room_capacity = $_POST['room_capacity'];
    $room_type = $_POST['room_type'];
  
    $query = mysqli_query($con,"SELECT * FROM rooms WHERE room_no='$room_no'")or die(mysqli_error());
    $count = mysqli_num_rows($query);

    if ($count>0){
      echo "<script type='text/javascript'>alert('Room already exist!');</script>";
    }

    else{
      mysqli_query($con,"INSERT INTO rooms (room_no, floor_no, room_capacity, room_type) VALUES('$room_no', '$floor_no', '$room_capacity', '$room_type')")or die(mysqli_error($con));
      echo "<script type='text/javascript'>alert('Successfully added room!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    } 
  }	
?>
