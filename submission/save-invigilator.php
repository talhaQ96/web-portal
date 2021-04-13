<?php 
  include('../database/database-connection.php'); 
  if (empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $id = $_POST['id'];
    $designation = $_POST['designation'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $query = mysqli_query($con,"SELECT * FROM invigilators WHERE invigilator_id='$id'")or die(mysqli_error($con));
    $count = mysqli_num_rows($query);
    
    if ($count>0){
      echo "<script type='text/javascript'>alert('Invigilator already exist!');</script>";
    }

    else{
      mysqli_query($con,"INSERT INTO invigilators (invigilator_id, designation, fname, lname) VALUES('$id', '$designation', '$fname', '$lname')")or die(mysqli_error($con));
      echo "<script type='text/javascript'>alert('Invigilator added successfully!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    } 
  }	
?>
