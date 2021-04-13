<?php
  include('../database/database-connection.php'); 
  if (empty($_POST)){
    header('Location: ../index.php');
  }

  else{
  	$roomNo = $_POST['room_no'];
  	$slotTime = $_POST['time-slots'];
  	$day = $_POST['day'];

	$truncateQuery = mysqli_query($con,"SELECT * FROM slots")or die(mysqli_error());
    $truncateCount = mysqli_num_rows($truncateQuery);
    if($truncateCount == 0){
      mysqli_query($con, "TRUNCATE TABLE slots;")or die(mysqli_error($dbCon));
    }

  	$query = mysqli_query($con,"SELECT * FROM slots WHERE room_no='$roomNo' AND day='$day'")or die(mysqli_error());
    $count = mysqli_num_rows($query);

    if($count >= 4){
    	echo "<script type='text/javascript'>alert('Room can not have more than 4 slots in a single day');</script>";
    	echo "<script>document.location='../page-templates/dashboard.php'</script>";
    }

  	$slotQuery = mysqli_query($con,"SELECT * FROM slots WHERE room_no='$roomNo' AND slot = '$slotTime' AND day = '$day'")or die(mysqli_error());
    $slotCount = mysqli_num_rows($slotQuery);

    if($slotCount > 0){
    	echo "<script type='text/javascript'>alert('Slot Already Exist');</script>";
    	echo "<script>document.location='../page-templates/dashboard.php'</script>";
    }

    else{
    	if ($slotTime == 'slot1'){
    		$startTime = ('09:00');
    		$endTime = ('11:30');
    	}

    	elseif ($slotTime == 'slot2') {
    		$startTime = ('12:00');
    		$endTime = ('14:30');
    	}

    	elseif ($slotTime == 'slot3') {
    		$startTime = ('15:00');
    		$endTime = ('17:30');
    	}

    	else{
    		$startTime = ('18:00');
    		$endTime = ('20:30');
    	}

    	mysqli_query($con,"INSERT INTO slots (room_no, day, slot, start_time, end_time) VALUES('$roomNo', '$day', '$slotTime', '$startTime', '$endTime')")or die(mysqli_error($con));
    	echo "<script type='text/javascript'>alert('Successfully added slot!');</script>";
      	echo "<script>document.location='../page-templates/dashboard.php'</script>";
    }
  }



?>