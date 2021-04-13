<?php 
	session_start();
  include('../database/database-connection.php');

	if(empty($_POST)){
		header('Location:../index.php');
	}

  else{
    $id = $_SESSION['id'];  
    $currentPassword = $_POST['c_pwd'];
    $newPassword = $_POST['new_pwd'];
    $retypedPassword = $_POST['re_pwd'];
    $email = $_POST['email'];

    $encryptedPasswordcurr = md5($currentPassword);
    $encryptedPasswordnew = md5($newPassword);
    $encryptedPasswordretype = md5($retypedPassword);

    $query = mysqli_query($con,"SELECT password FROM admins WHERE admin_id='$id'")or die(mysqli_error($con));
    $passwordDatabase = mysqli_fetch_array($query);

    if ($passwordDatabase['password'] != $encryptedPasswordcurr) {
      echo "<script type='text/javascript'>alert('Incorrect Current Password!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    }

    else{
      if ($encryptedPasswordnew != $encryptedPasswordretype) {
        echo "<script type='text/javascript'>alert('You must enter the same password twice in order to confirm it.');</script>";
        echo "<script>document.location='../page-templates/dashboard.php'</script>";
      }
      
      else{
        mysqli_query($con,"UPDATE admins SET password = '$encryptedPasswordnew' WHERE admin_id='$id'")or die(mysqli_error($con));
        echo "<script type='text/javascript'>alert('Password has been changed successfully.');</script>";
        echo "<script>document.location='../page-templates/dashboard.php'</script>";
      }
    }
  }
     	
?>
