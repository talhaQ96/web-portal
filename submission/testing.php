<?php
	session_start();

	function database (){
    	static $con;
    	if ($con===NULL){ 
        	$con = mysqli_connect ("localhost", "root", "", "portal_db");
    	}
    	return $con;
	}

	function getCourse ($semester){
		$con = database();
		$query = mysqli_query($con,"SELECT * FROM courses WHERE semester = '$semester' AND status = 'Unassigned' LIMIT 1")or die(mysqli_error());
		$row = mysqli_fetch_array($query);
		return $row;
	}

	function nextCourse ($semester){
		$con = database();
		$query = mysqli_query($con,"SELECT * FROM courses WHERE semester = '$semester' AND status = 'Unassigned' AND clash = 'NO' LIMIT 1")or die(mysqli_error());
		$row = mysqli_fetch_array($query);
		return $row;
	}


	function clashfreeCourse($semester, $prevcourseCode){
		$con = database();
		$query = mysqli_query($con,"SELECT * FROM courses WHERE semester = '$semester'")or die(mysqli_error());
		while ($row = mysqli_fetch_array($query)) {
			$courseFound = false;
			$course = nextCourse($semester);
			$nextcourseCode = $course['code'];
			$prevCourse = mysqli_query($con,"SELECT * FROM students_enrolled WHERE course_code = '$prevcourseCode'")or die(mysqli_error());

			while ($prevCourseRow = mysqli_fetch_array($prevCourse)){
				$nextCourse = mysqli_query($con,"SELECT * FROM students_enrolled WHERE course_code = '$nextcourseCode'")or die(mysqli_error());
				$stdID = $prevCourseRow['student_id'];
				while ($nextCourseRow = mysqli_fetch_array($nextCourse)){
					if ($stdID != $nextCourseRow['student_id']){
						$courseFound = true;
						$returnCourseRow = $course; 
					}

					else{
						$courseFound = false;
						$returnCourseRow = "";
					}
				}
			}

			if ($courseFound == true) {
				mysqli_query($con,"UPDATE courses SET clash = 'NO'")or die(mysqli_error($con));
				return $returnCourseRow;
				break;
			}

			else{
				mysqli_query($con,"UPDATE courses SET clash = 'YES' WHERE code = '$nextcourseCode'")or die(mysqli_error($con));
			}
		}
	}

	$con = database();

	$day =1;
	$slot=1;
	$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND slots.day LIKE '%$day' = $day AND slots.slot LIKE '%$slot' ORDER BY slots.slot, slots.room_no")or die(mysqli_error($con));

	while ($row = mysqli_fetch_array($slotQuery)) {
		echo $row['room_no'].'<br>';
	}
	
	
?>