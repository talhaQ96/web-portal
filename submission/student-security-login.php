<?php 
	session_start();
  include('../database/database-connection.php');

	if(empty($_POST)){
		header('Location:../index.php');
	}

  else{
    $id = $_SESSION['id'];  
    $current_pwd = $_POST['c_pwd'];
    $new_pwd = $_POST['new_pwd'];
    $retype_pwd = $_POST['re_pwd'];
    $email = $_POST['email'];
    $current_pwd_encrypt = mysqli_real_escape_string($con,$current_pwd);
    $new_pwd_encrypt = mysqli_real_escape_string($con,$new_pwd);
    $retype_pwd_encrypt = mysqli_real_escape_string($con,$retype_pwd);

    $query = mysqli_query($con,"SELECT password FROM students WHERE student_id='$id'")or die(mysqli_error($con));
    $pwd_in_db = mysqli_fetch_array($query);

    if ($pwd_in_db['password'] != $current_pwd_encrypt) {
      echo "<script type='text/javascript'>alert('Incorrect Current Password!');</script>";
      echo "<script>document.location='../page-templates/student-dashboard.php'</script>";
    }

    else{
      if ($new_pwd_encrypt != $retype_pwd_encrypt ) {
        echo "<script type='text/javascript'>alert('You must enter the same password twice in order to confirm it.');</script>";
        echo "<script>document.location='../page-templates/student-dashboard.php'</script>";
      }
      else{
        mysqli_query($con,"UPDATE admins SET password = '$new_pwd_encrypt' WHERE admin_id='$id'")or die(mysqli_error($con));
        echo "<script type='text/javascript'>alert('Password has been changed successfully.');</script>";
        echo "<script>document.location='../page-templates/student-dashboard.php'</script>";
      }
    }
  }
     	
?>
