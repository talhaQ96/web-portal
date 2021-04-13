<?php
	include('../database/database-connection.php');

	if($_REQUEST){
		$id = $_REQUEST['std_id'];
		$query = mysqli_query($con,"SELECT course_code FROM students_enrolled WHERE student_id = '$id'")or die(mysqli_error());
		$count = mysqli_num_rows($query);
    	
		$codes = array();

		while ($row = mysqli_fetch_assoc($query)) {
			$codes[] = $row;
		}

		echo json_encode($codes);
	}
?>