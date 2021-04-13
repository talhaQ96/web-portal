<?php 
	session_start();
	include('../database/database-connection.php'); 
	if(empty($_REQUEST) || empty($_SESSION['id'])){
		header('Location: ../index.php');
	}
	
	else{
		$room_no = $_REQUEST['id'];
		$query = mysqli_query($con,"SELECT * FROM rooms WHERE room_no='$room_no'")or die(mysqli_error());
    	$count = mysqli_num_rows($query);

    	if ($count == 0) {
    		echo "<script>document.location='../page-templates/dashboard.php'</script>";
    	}

    	else{
			
			$query = mysqli_query($con,"DELETE FROM rooms WHERE room_no ='$room_no'") or die(mysqli_error());
			echo "<script type='text/javascript'>alert('Room deleted successfully!');</script>";	
			echo "<script>document.location='../page-templates/dashboard.php'</script>"; 
    	}
	}
?>