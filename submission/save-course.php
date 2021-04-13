<?php 
  include('../database/database-connection.php'); 
  if (empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $code = $_POST['code'];
    $cr_hrs = $_POST['cr_hrs'];
    $cname = $_POST['cname'];
    $semester = $_POST['semester_no'];

    $query = mysqli_query($con,"SELECT * FROM courses WHERE code='$code'")or die(mysqli_error($con));
    $count = mysqli_num_rows($query);

    if ($count>0){
      echo "<script type='text/javascript'>alert('Course already exist!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    }
    
    else{
      mysqli_query($con,"INSERT INTO courses (code, cr_hrs, c_name, semester) VALUES('$code', '$cr_hrs', '$cname', '$semester')")or die(mysqli_error($con));
      echo "<script type='text/javascript'>alert('Course added successfully!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    } 
  }	
?>
