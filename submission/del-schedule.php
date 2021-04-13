<?php 
	session_start();
	include('../database/database-connection.php'); 

	if(empty($_SESSION['id'])){
		header('Location: ../index.php');
	}
	
	else{
		mysqli_query($con,"UPDATE slots SET status = 'Vacant'") or die(mysqli_error());
		mysqli_query($con,"UPDATE courses SET status = 'Unassigned'") or die(mysqli_error());
		mysqli_query($con,"UPDATE students_enrolled SET status = 'Unassigned'") or die(mysqli_error());
		mysqli_query($con,"TRUNCATE TABLE schedule;") or die(mysqli_error());

		echo "<script type='text/javascript'>alert('Schedule deleted successfully!');</script>";	
		echo "<script>document.location='../page-templates/dashboard.php'</script>"; 
	}
?>