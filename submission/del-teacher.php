<?php 
	session_start();
	include('../database/database-connection.php'); 
	if(empty($_REQUEST) || empty($_SESSION['id'])){
		header('Location: ../index.php');
	}
	
	else{
		$id = $_REQUEST['id'];
		$query = mysqli_query($con,"SELECT * FROM teachers WHERE teacher_id='$id'")or die(mysqli_error());
    	$count = mysqli_num_rows($query);

    	if ($count == 0) {
    		echo "<script>document.location='../page-templates/dashboard.php'</script>";
    	}

    	else{
			$query = mysqli_query($con,"DELETE FROM teachers WHERE teacher_id ='$id'") or die(mysqli_error($con));
			echo "<script type='text/javascript'>alert('Teacher deleted successfully!');</script>";	
			echo "<script>document.location='../page-templates/dashboard.php'</script>";
    	}
	}
?>