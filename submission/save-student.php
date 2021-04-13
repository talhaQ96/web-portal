<?php 
  include('../database/database-connection.php'); 
  if (empty($_POST)){
    header('Location: ../index.php');
  }

  else{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];

    $truncateQuery = mysqli_query($con,"SELECT * FROM students")or die(mysqli_error());
    $truncateCount = mysqli_num_rows($truncateQuery);

    if ($truncateCount == 0) {
      mysqli_query($con, "TRUNCATE TABLE students")or die(mysqli_error());
      mysqli_query($con, "ALTER TABLE students AUTO_INCREMENT=30000")or die(mysqli_error());
    }
  
    if (!empty($_POST['id'])) {
      $id = $_POST['id'];
      $query = mysqli_query($con,"SELECT * FROM students WHERE student_id='$id'")or die(mysqli_error());
      $count = mysqli_num_rows($query);

      if ($count>0){
        echo "<script type='text/javascript'>alert('Student already exist!');</script>";
        echo "<script>document.location='../page-templates/dashboard.php'</script>";
      }

      else{
        mysqli_query($con,"INSERT INTO students (student_id, fname, lname, semester, year) VALUES('$id', '$fname', '$lname', '$semester', '$year')")or die(mysqli_error($con));
        echo "<script type='text/javascript'>alert('Successfully added student!');</script>";
        echo "<script>document.location='../page-templates/dashboard.php'</script>";
      }
    }

    else{
      mysqli_query($con,"INSERT INTO students (fname, lname, semester, year) VALUES('$fname', '$lname', '$semester', '$year')")or die(mysqli_error($con));
      echo "<script type='text/javascript'>alert('Successfully added student!');</script>";
      echo "<script>document.location='../page-templates/dashboard.php'</script>";
    }   
  }
?>
