<?php
	include('../database/database-connection.php');
  if (empty($_POST)){
  	header('Location: ../index.php');
  }

  else{
		$query = mysqli_query($con,"SELECT * FROM students_enrolled")or die(mysqli_error());
    $count = mysqli_num_rows($query);
    if($count == 0){
      mysqli_query($con, "TRUNCATE TABLE students_enrolled;")or die(mysqli_error($dbCon));
    }

		if(isset($_POST['courses']) && isset($_POST['student'])){
      /*getting student name from students table using student id*/
		  $std_id = $_POST['student'];
		  $stdquery = mysqli_query($con,"SELECT fname, lname FROM students WHERE student_id='$std_id'")or die(mysqli_error($con));
		  $stdrow = mysqli_fetch_array($stdquery);
		  $std_fname = $stdrow["fname"];
		  $std_lname = $stdrow["lname"];

      foreach($_POST['courses'] as $course){
        /*getting course name from courses table using course code*/
        $course_code = $course;
        $course_query = mysqli_query($con,"SELECT c_name FROM courses WHERE code='$course_code'")or die(mysqli_error($con));
        $course_row = mysqli_fetch_array($course_query);
        $course_name = $course_row['c_name'];

        /*checking if student is already enrolled in course or not*/
        $check_query =  mysqli_query($con,"SELECT * FROM students_enrolled WHERE student_id='$std_id' AND course_code='$course_code'")or die(mysqli_error($con));
        $count_check_query = mysqli_num_rows($check_query);

        if ($count_check_query == 0){
          mysqli_query($con,"INSERT INTO students_enrolled (student_id, fname, lname, course_code, course_name) VALUES ('$std_id', '$std_fname', '$std_lname', '$course_code', '$course_name')")or die(mysqli_error($con));  
        }  
      }

      /*Delete/Update Course*/
      $del_query = mysqli_query($con,"SELECT * FROM students_enrolled WHERE student_id='$std_id'")or die(mysqli_error($con));
      while ($del_query_row = mysqli_fetch_array($del_query)){
        $find_course = false;
        $code = $del_query_row['course_code'];
        foreach($_POST['courses'] as $course){
          if ($code == $course){
            $find_course = true;
          }
        }
        if ($find_course == false) {
          mysqli_query($con,"DELETE FROM students_enrolled WHERE student_id ='$std_id' AND course_code='$code'")or die(mysqli_error($con));
        }
      } 
		}
    echo "<script>document.location='../page-templates/dashboard.php'</script>";  
  }
?>