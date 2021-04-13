<?php
	session_start();

	if(empty($_SESSION['id'])){
		header('Location: ../index.php');
	}
	
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
		$queryElective = mysqli_query($con,"SELECT * FROM courses WHERE semester = 'Elective' AND status = 'Unassigned'")or die(mysqli_error());
		$electiveCount = mysqli_num_rows($queryElective);

		if (empty($row) && $electiveCount != 0){
			return getCourse('Elective');
		}

		else{
			return $row;
		}
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

	for ($day = 1; $day <= 9 ; $day++){ 
		$slot = 1;
		$semester = 1;
		$course = getCourse($semester);
		$courseCode = $course['code'];
		$courseName = $course['c_name'];
		$courseStrenght = $course['strenght'];
		$courseCredit = $course['cr_hrs'];

		while ($courseStrenght > 0) {
			
			if ($courseCredit != 1){
				$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND rooms.room_type = '' AND slots.status = 'Vacant' AND slots.day LIKE '%$day' AND slots.slot LIKE '%$slot' ORDER BY slots.slot, slots.room_no LIMIT 1")or die(mysqli_error($con));
			}

			else{
				if ($courseCode == 'EE101-L') {
					$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND rooms.room_type = 'Electronics Lab' AND slots.status = 'Vacant' AND slots.day LIKE '%$day' AND slots.slot LIKE '%$slot' ORDER BY slots.day, slots.slot, slots.room_no LIMIT 1")or die(mysqli_error($con));
				}

				elseif ($courseCode == 'EE201-L' || $courseCode == 'TE421-L' ) {
					$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND rooms.room_type = 'Digital Signal Processing & FPGA Lab' AND slots.status = 'Vacant' AND slots.day LIKE '%$day' AND slots.slot LIKE '%$slot' ORDER BY slots.day, slots.slot, slots.room_no LIMIT 1")or die(mysqli_error($con));
				}

				elseif ($courseCode == 'EE301-L') {
					$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND rooms.room_type LIKE '%Microprocessor%' AND slots.status = 'Vacant' AND slots.day LIKE '%$day' AND slots.slot LIKE '%$slot' ORDER BY slots.day, slots.slot, slots.room_no LIMIT 1")or die(mysqli_error($con));
				}

				elseif ($courseCode == 'CS402-L') {
					$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND rooms.room_type = 'Embedded Systems & Robotics Lab' AND slots.status = 'Vacant' AND slots.day LIKE '%$day' AND slots.slot LIKE '%$slot' ORDER BY slots.day, slots.slot, slots.room_no LIMIT 1")or die(mysqli_error($con));
				}

				else{
					$slotQuery = mysqli_query($con, "SELECT * FROM rooms, slots WHERE rooms.room_no = slots.room_no AND rooms.room_type = 'Computer Lab' AND slots.status = 'Vacant' AND slots.day LIKE '%$day' AND slots.slot LIKE '%$slot' ORDER BY slots.day, slots.slot, slots.room_no LIMIT 1")or die(mysqli_error($con));
				}
			}

			$slotRow = mysqli_fetch_array($slotQuery);
			$slotCapacity = $slotRow['room_capacity'];
			$slotNo = $slotRow['slot_no'];
			$roomNo = $slotRow['room_no'];
			$examDay = $slotRow['day'];
			$startTime = $slotRow['start_time'];
			$endTime = $slotRow['end_time'];

			while ($slotCapacity > 0){
				$enrollQuery = mysqli_query($con,"SELECT * FROM students_enrolled WHERE course_code = '$courseCode' AND status = 'Unassigned' LIMIT 1")or die(mysqli_error());
				$enrollRow = mysqli_fetch_array($enrollQuery);
				$stdID = $enrollRow['student_id'];

			 	mysqli_query($con,"INSERT INTO schedule (student_id, room_no, day, start_time, end_time, course_code, course_name) VALUES('$stdID', '$roomNo', '$examDay', '$startTime', '$endTime', '$courseCode', '$courseName')")or die(mysqli_error($con));
			 	mysqli_query($con,"UPDATE students_enrolled SET status = 'Assigned' WHERE student_id = '$stdID' AND course_code = '$courseCode'")or die(mysqli_error($con));

				$slotCapacity --;
				$courseStrenght --;

				if ($slotCapacity == 0){
					mysqli_query($con,"UPDATE slots SET status = 'Occupied' WHERE slot_no = '$slotNo'")or die(mysqli_error($con));
				}

				if ($courseStrenght == 0) {
					break;
				}
			}

			if ($courseStrenght == 0) {
				echo $day.' - '.$semester.' - '.$course['c_name'].'<br>';
				mysqli_query($con,"UPDATE courses SET status = 'Assigned' WHERE code = '$courseCode'")or die(mysqli_error($con));
				$semester ++;

				if ($semester == 9) {
					break;
				}

				if ($semester % 2 == 0) {
					$course = clashfreeCourse($semester, $courseCode);
					if (empty($course)){
						$course = clashfreeCourse('Elective', $courseCode);
					}
					if (empty($course) && $slot != 4) {
						$slot++;
						$course = getCourse($semester);
					}
				}

				else{
					$course = getCourse($semester);
					$slot++;
				}

				$courseCode = $course['code'];
				$courseName = $course['c_name'];
				$courseStrenght = $course['strenght'];
				$courseCredit = $course['cr_hrs'];
			}
		}
	}
?>