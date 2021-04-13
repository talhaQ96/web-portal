<?php
	session_start(); 
	include('../database/database-connection.php'); 
	if(empty($_POST)){
		header('Location: ../index.php');
	}

	else{
		$user_unsafe = $_POST['userId'];
		$pass_unsafe = $_POST['password'];
		$role = $_POST['role'];
		$userId = 	mysqli_real_escape_string($con,$user_unsafe);
		$password = mysqli_real_escape_string($con,$pass_unsafe);

		$encryptedPass = md5($password);

		if ($role == 'admin') {
			$query = mysqli_query($con,"SELECT * FROM admins WHERE admin_id='$userId' AND password='$encryptedPass'")or die(mysqli_error($con));
		}

		else{
			$query = mysqli_query($con,"SELECT * FROM students WHERE student_id='$userId' AND password='$encryptedPass'")or die(mysqli_error($con));
		}	

		$row = mysqli_fetch_array($query);
    	$counter = mysqli_num_rows($query);

		if ($counter == 0) {	
			echo "<script type='text/javascript'>alert('Invalid Username or Password!');document.location='../index.php'</script>";
		}

		else{
			$_SESSION['id'] = $userId;

			if ($role == 'admin') {
				echo "<script>document.location='../page-templates/dashboard.php'</script>"; 
			}

			else{
				echo "<script>document.location='../page-templates/student-dashboard.php'</script>"; 
			}
			
		}	
	} 
?>