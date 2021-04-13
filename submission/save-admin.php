<?php 
  include('../database/database-connection.php'); 
  if (empty($_POST)){
    header('Location: ../index.php');
  }
  
  else{
    $id = $_POST['id'];
    $pass_unsafe = "admin123";
    $pass = mysqli_real_escape_string($con,$pass_unsafe);
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $designation = $_POST['designation'];
  
    $query = mysqli_query($con,"SELECT * FROM admins WHERE admin_id='$id'")or die(mysqli_error($con));
    $count = mysqli_num_rows($query);

    if ($count>0){
      echo "<script type='text/javascript'>alert('Admin already exist!');</script>";
    }
    
    else{
      mysqli_query($con,"INSERT INTO admins (admin_id, designation, fname, lname, password) VALUES('$id', '$designation', '$fname', '$lname', '$pass')")or die(mysqli_error($con));
      echo "<script type='text/javascript'>alert('Admin added successfully!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    } 
  }	
?>
