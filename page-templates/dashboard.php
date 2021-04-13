<?php 
  session_start();
  if(empty($_SESSION['id'])){
    header('Location:../index.php');
  }
  $userId = $_SESSION['id'];
  include('../database/database-connection.php');
  require ("../header.php");

  $query = mysqli_query($con,"SELECT * FROM students WHERE student_id='$userId'")or die(mysqli_error($con));
  $count = mysqli_num_rows($query);

  if ($count > 0) {
    header('Location:../index.php');
  }

  $query = mysqli_query($con,"SELECT * FROM admins WHERE admin_id='$userId'")or die(mysqli_error($con));
  $row = mysqli_fetch_array($query);

  if (empty($row['profile_img_name'])) {$profileImg_url = "http://localhost/portal/assets/images/default-profile.png";}
  else{$profileImg_url = "http://localhost/portal/assets/images/users/".$row['profile_img_name'];}
  
  $coverImg_url =  "http://localhost/portal/assets/images/users/".$row['cover_img_name'];
?>
  <section class="dashboard">
    <div class="container-fluid">
      <div class="top-nav">
        <p><span><img src="<?php echo $profileImg_url ?>" class="thumb"></span><?php echo $row['fname']." ".$row['lname'] ?><i class="fa fa-cog" id="gear"></i></p>
      </div>
      <div class="sidebar">
        <ul class="nav">
          <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#std"><span><img src="../assets/images/student-icon.png"></span>Students</a></li>
<!--           <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#teacher"><span><img src="../assets/images/teacher-icon.png"></span>Teachers</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#invigilator"><span><img src="../assets/images/invigilator-icon.png"></span>Invigilators</a></li> -->
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#admin"><span><img src="../assets/images/admin-icon.png"></span>Admins</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#course"><span><img src="../assets/images/course-icon.png"></span>Courses</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#room"><span><img src="../assets/images/room-icon.png"></span>Rooms</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#enrollStd"><span><img src="../assets/images/refresh-button.png"></span>Enroll Students</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#slots"><span><img src="../assets/images/slots.png"></span>Slots</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#schedule"><span><img src="../assets/images/timetable.png"></span>Schedule</a></li>
        </ul>
      </div>
      <div class="tab-content">
        <!-- Students Tab -->
        <div class="tab-pane fade show active" id="std">
          <div class="tab-head">
            <h1 class="title">Students</h1>
            <button onclick="document.getElementById('std-form').style.display='flex'" class="lnkbtn">Add Student</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Semester</th>
                <th scope="col">Year</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM students");
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th scope="row"><?php echo $row ["student_id"]; ?></th>
                    <td><?php echo $row ["fname"]; ?></td>
                    <td><?php echo $row ["lname"]; ?></td>
                    <td><?php echo $row ["semester"]; ?></td>
                    <td><?php echo $row ["year"]; ?></td>
                    <td>
                      <a href="http://localhost/portal/submission/del-student.php?id=<?php echo $row ["student_id"]; ?>"><i class="fa fa-trash"></i></a>
                      <a href="http://localhost/portal/submission/update-forms/update-student.php?id=<?php echo $row ["student_id"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>           
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Teachers Tab -->
        <div class="tab-pane fade" id="teacher">
          <div class="tab-head">
            <h1 class="title">Teachers</h1>
            <button onclick="document.getElementById('teacher-form').style.display='flex'" class="lnkbtn">Add Teacher</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM teachers");
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th scope="row"><?php echo $row ["teacher_id"]; ?></th>
                    <td><?php echo $row ["fname"]; ?></td>
                    <td><?php echo $row ["lname"]; ?></td>
                    <td><?php echo $row ["designation"]; ?></td>
                    <td>
                      <a href="http://localhost/portal/submission/del-teacher.php?id=<?php echo $row ["teacher_id"]; ?>"><i class="fa fa-trash"></i></a>
                      <a href="http://localhost/portal/submission/update-forms/update-teacher.php?id=<?php echo $row ["teacher_id"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>           
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Invigilators Tab -->
        <div class="tab-pane fade" id="invigilator">
          <div class="tab-head">
            <h1 class="title">Invigilators</h1>
            <button onclick="document.getElementById('invigilator-form').style.display='flex'" class="lnkbtn">Add Invigilator</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM invigilators");
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th scope="row"><?php echo $row ["invigilator_id"]; ?></th>
                    <td><?php echo $row ["fname"]; ?></td>
                    <td><?php echo $row ["lname"]; ?></td>
                    <td><?php echo $row ["designation"]; ?></td>
                    <td>
                      <a href="http://localhost/portal/submission/del-invigilator.php?id=<?php echo $row ["invigilator_id"]; ?>"><i class="fa fa-trash"></i></a>
                      <a href="http://localhost/portal/submission/update-forms/update-invigilator.php?id=<?php echo $row ["invigilator_id"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>           
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Admin Tab -->
        <div class="tab-pane fade" id="admin">
          <div class="tab-head">
            <h1 class="title">Admins</h1>
            <button onclick="document.getElementById('admin-form').style.display='flex'" class="lnkbtn">Add Admin</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM admins");
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th scope="row"><?php echo $row ["admin_id"]; ?></th>
                    <td><?php echo $row ["fname"]; ?></td>
                    <td><?php echo $row ["lname"]; ?></td>
                    <td><?php echo $row ["designation"]; ?></td>
                    <td>
                      <a href="http://localhost/portal/submission/del-admin.php?id=<?php echo $row ["admin_id"]; ?>"><i class="fa fa-trash"></i></a>
                      <a href="http://localhost/portal/submission/update-forms/update-admin.php?id=<?php echo $row ["admin_id"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>           
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Course Tab -->
        <div class="tab-pane fade" id="course">
          <div class="tab-head">
            <h1 class="title">Cources</h1>
            <button onclick="document.getElementById('course-form').style.display='flex'" class="lnkbtn">Add Cource</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Code</th>
                <th scope="col">Cr. Hrs</th>
                <th scope="col">Name</th>
                <th scope="col">Semester</th>
                <th scope="col">Strenght</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM courses ORDER BY semester");
                while ($row = mysqli_fetch_array($query)):
                  $code = $row["code"];
                  $strengthQuery = mysqli_query($con,"SELECT * FROM students_enrolled WHERE course_code ='$code'")or die(mysqli_error($con));
                  $strengthCount = mysqli_num_rows($strengthQuery);
                  mysqli_query($con,"UPDATE courses SET strenght = '$strengthCount' WHERE code = '$code' ")or die(mysqli_error($con));
              ?>
                  <tr>
                    <th scope="row"><?php echo $row ["code"]; ?></th>
                    <td><?php echo $row ["cr_hrs"]; ?></td>
                    <td><?php echo $row ["c_name"]; ?></td>
                    <td><?php echo $row ["semester"]; ?></td>
                    <td><?php echo $row ["strenght"]; ?></td>
                    <td style="font-weight: bold; <?php if($row["status"] == 'Unassigned'){echo "color: #f44336";} else{echo "color: #66B032";} ?>"><?php echo $row ["status"]; ?></td>
                    <td>
                      <a href="http://localhost/portal/submission/del-course.php?id=<?php echo $row ["code"]; ?>"><i class="fa fa-trash"></i></a>
                      <a href="http://localhost/portal/submission/update-forms/update-course.php?id=<?php echo $row ["code"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>           
              <?php endwhile; ?>

            </tbody>
          </table>
        </div>

        <!-- Room Tab -->
        <div class="tab-pane fade" id="room">
          <div class="tab-head">
            <h1 class="title">Rooms</h1>
            <button onclick="document.getElementById('room-form').style.display='flex'" class="lnkbtn">Add Room</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Room #</th>
                <th scope="col">Floor #</th>
                <th scope="col">Capacity</th>
                <th scope="col">Room Type</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM rooms ORDER BY room_no ASC");
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th scope="row"><?php echo $row ["room_no"]; ?></th>
                    <td><?php echo $row ["floor_no"]; ?></td>
                    <td><?php echo $row ["room_capacity"]; ?></td>
                    <td><?php echo $row ["room_type"]; ?></td>
                    <td>
                      <a href="http://localhost/portal/submission/del-room.php?id=<?php echo $row ["room_no"]; ?>"><i class="fa fa-trash"></i></a>
                      <a href="http://localhost/portal/submission/update-forms/update-room.php?id=<?php echo $row ["room_no"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </td>
                  </tr>           
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Enroll Students Tab -->
        <div class="tab-pane fade" id="enrollStd">
          <form class="clearfix" method="post" action="http://localhost/portal/submission/enroll-students.php">
            <div class="tab-head">
              <h1 class="title">Enroll Students</h1>
              <?php $query = mysqli_query($con,"SELECT student_id, fname, lname FROM students ORDER BY student_id"); ?>
              <select class="form-control" id="std-list" name="student">
                <option value="" selected disabled>Select Student</option>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                  <option value="<?php echo $row["student_id"] ?>"><?php echo $row["student_id"]." - ".$row["fname"]." ".$row["lname"] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Code</th>
                  <th scope="col">Cr. Hrs</th>
                  <th scope="col">Name</th>
                  <th scope="col">Semester</th>
                  <th scope="col">Strenght</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = mysqli_query($con,"SELECT * FROM courses ORDER BY semester");
                  while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                      <td><input class="courseChk" type="checkbox" name="courses[]" value="<?php echo $row ["code"]; ?>"></td>
                      <th scope="row"><?php echo $row ["code"]; ?></th>
                      <td><?php echo $row ["cr_hrs"]; ?></td>
                      <td><?php echo $row ["c_name"]; ?></td>
                      <td><?php echo $row ["semester"]; ?></td>
                      <td><?php echo $row ["strenght"]; ?></td>
                    </tr>           
                <?php endwhile; ?>
              </tbody>
            </table>
            <button type="submit" class="lnkbtn" style="float: right;">Submit</button>
          </form>
        </div>

        <!-- Slots Tabs -->
        <div class="tab-pane" id="slots">
          <div class="tab-head">
            <h1 class="title">Slots</h1>
            <button onclick="document.getElementById('slots-form').style.display='flex'" class="lnkbtn">Add Slot</button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Slot No.</th>
                <th scope="col">Day</th>
                <th scope="col">Room No.</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con,"SELECT * FROM slots ORDER BY day, room_no, start_time");
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th><?php echo $row ["slot_no"]; ?></th>
                    <td><?php echo $row ["day"]; ?></td>
                    <td><?php echo $row ["room_no"]; ?></td>
                    <td><?php echo $row ["start_time"]; ?></td>
                    <td><?php echo $row ["end_time"]; ?></td>
                    <td style="font-weight: bold; <?php if($row["status"] == 'Vacant'){echo "color: #66B032";} else{echo "color: #f44336";} ?>"><?php echo $row ["status"]; ?></td>
                  </tr>           
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>


        <!-- Generate Schedule Tab -->
        <div class="tab-pane fade" id="schedule">
          <div class="tab-head">
            <h1 class="title">Exam Schedule</h1>
            <div class="button-group">
              <a href="http://localhost/portal/submission/generate-schedule.php" target= "_blank" class="lnkbtn">Generate Schedule</a>
              <a href="http://localhost/portal/submission/del-schedule.php" target= "_blank" class="lnkbtn">Clear Schedule</a>
            </div>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Room No.</th>
                <th scope="col">Day</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Course Code</th>
                <th scope="col">Course</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con, "SELECT * FROM schedule GROUP BY course_code, room_no ORDER BY day, room_no, start_time")or die(mysqli_error($con));
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <th><?php echo $row ["room_no"]; ?></th>
                    <td><?php echo $row ["day"]; ?></td>
                    <td><?php echo $row ["start_time"]; ?></td>
                    <td><?php echo $row ["end_time"]; ?></td>
                    <td><?php echo $row ["course_code"]; ?></td>
                    <td><?php echo $row ["course_name"]; ?></td>
                  </tr>
                <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

<!-- Profile Popup -->
<?php
  $userId = $_SESSION['id'];
  $query = mysqli_query($con,"SELECT * FROM admins WHERE admin_id='$userId'")or die(mysqli_error($con));
  $row = mysqli_fetch_array($query);
?>
<div class="profile-popup">
  <i class="fa fa-times" aria-hidden="true"></i>
  <div class="wrap">
    <div class="profile">
      <p><span><img src="<?php echo $profileImg_url ?>" class="thumb"></span><?php echo $row['fname']." ".$row['lname'] ?></p>
    </div>
    <div class="lnk-list">
      <ul>
        <li onclick="document.getElementById('settings-form').style.display='flex'"><i class="fa fa-cogs" aria-hidden="true"></i><span>General Settings</span></li>
        <li onclick="document.getElementById('security-form').style.display='flex'"><i class="fa fa-lock" aria-hidden="true"></i><span>Security & Login</span></li>
      </ul>
    </div>
    <div class="actions">
      <a href="http://localhost/portal/page-templates/dashboard.php"><i class="fa fa-home"></i></a>
      <a href="http://localhost/portal/submission/logout.php"><i class="fa fa-power-off"></i></a>
    </div>
  </div>
</div>

<!-- General Settings Form Popup -->
<div class="w3-container">
  <div id="settings-form" class="w3-modal">
    <i class="fa fa-times" onclick="document.getElementById('settings-form').style.display='none'" aria-hidden="true"></i>
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <form class="clearfix popupForm" action="http://localhost/portal/submission/update-admin-profile.php" method="post"enctype="multipart/form-data">
        <div class="head">
          <div class="cover" style="background-image: url('<?php echo $coverImg_url ?>');">
            <label for="coverphoto"><i class="fa fa-camera" aria-hidden="true"></i></label>
            <input type="file" id="coverphoto" name="coverphoto" style="display: none;">
          </div>
          <div class="profile-pic" style="background-image: url('<?php echo $profileImg_url ?>')">
            <label for="profilephoto"><i class="fa fa-camera" aria-hidden="true"></i></label>
            <input type="file" id="profilephoto" name="profilephoto" style="display: none;">
          </div>
        </div>
        <div class="clearfix bottom">
          <p>Please provide the details for admin to be updated.</p>
          <div class="form-row">
            <div class="form-group col-6">
              <input type="number" class="form-control" placeholder="ID" pattern="[0-9]*" value="<?php echo $row['admin_id']?>" disabled>
            </div>
            <div class="form-group col-6">
              <input type="name" class="form-control" placeholder="Designation" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="designation" value="<?php echo $row['designation'] ?>" required>
            </div>
            <div class="form-group col-6">
              <input type="name" class="form-control" placeholder="First Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="fname" value="<?php echo $row['fname'] ?>" required>
            </div>
            <div class="form-group col-6">
              <input type="name" class="form-control" placeholder="Last Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="lname" value="<?php echo $row['lname'] ?>" required>
            </div>
          </div>
          <button type="submit" class="lnkbtn">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Security Form Popup -->
<div class="w3-container">
  <div id="security-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('security-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/security-login.php">
        <p>Please provide the following details for admin to be updated.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="password" class="form-control" placeholder="Current Password" autocomplete="new-password" name="c_pwd" required>
          </div>
          <div class="form-group col-6">
            <input type="password" class="form-control" placeholder="New Password" name="new_pwd" required>
          </div>
          <div class="form-group col-6">
            <input type="password" class="form-control" placeholder="Retype New Password" name="re_pwd" required>
          </div>
          <div class="form-group col-6">
            <input type="email" class="form-control" placeholder="Email Address" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+[.]+[a-zA-Z]{2,3}$" name="email" required>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<!-- Student Form Popup -->
<div class="w3-container">
  <div id="std-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('std-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-student.php">
        <p>Please provide the following details for student.</p>
        <div class="form-row">
          <div class="form-group col-12">
            <input type="number" class="form-control" placeholder="Reg #" pattern="[0-9]*" min="1" name="id">
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="First Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="fname" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Last Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="lname" required>
          </div>
          <div class="form-group col-6">
            <select class="form-control" name="semester">
              <option value="Spring">Spring</option>
              <option value="Summer">Summer</option>
              <option value="Fall">Fall</option>
            </select>
          </div>
          <div class="form-group col-6">
            <?php $years = range(1998, strftime("%Y", time())); ?>
            <select class="form-control" name="year" required>
              <option disabled selected>Select Year</option>
              <?php foreach($years as $year) : ?>
                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Student</button>
      </form>
    </div>
  </div>
</div>

<!-- Teacher Form Popup -->
<div class="w3-container">
  <div id="teacher-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('teacher-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-teacher.php">
        <p>Please provide the following details for teacher.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="number" class="form-control" placeholder="ID" pattern="[0-9]*" name="id">
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Designation" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="designation" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="First Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="fname" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Last Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="lname" required>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Teacher</button>
      </form>
    </div>
  </div>
</div>

<!-- Invigilator Form Popup -->
<div class="w3-container">
  <div id="invigilator-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('invigilator-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-invigilator.php">
        <p>Please provide the following details for invigilator.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="number" class="form-control" placeholder="ID" pattern="[0-9]*" min="1" max="99999"max="99999" name="id" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Designation" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="designation" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="First Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="fname" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Last Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="lname" required>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Invigilator</button>
      </form>
    </div>
  </div>
</div>

<!-- Admin Form Popup -->
<div class="w3-container">
  <div id="admin-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('admin-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-admin.php">
        <p>Please provide the following details for admin.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="number" class="form-control" placeholder="ID" pattern="[0-9]*" min="1" max="99999" name="id" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Designation" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="designation" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="First Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="fname" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Last Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="lname" required>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Admin</button>
      </form>
    </div>
  </div>
</div>

<!-- Course Form Popup -->
<div class="w3-container">
  <div id="course-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('course-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-course.php">
        <p>Please provide the following details for course.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="text" class="form-control" placeholder="Code" name="code" required>
          </div>
          <div class="form-group col-6">
            <input type="number" class="form-control" placeholder="Cr. Hours" pattern="[0-9]*" min="1" max="3"name="cr_hrs" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Course Name" name="cname" required>
          </div>
          <div class="form-group col-6">
            <select class="form-control" name="semester_no">
              <option selected disabled>Semester</option>
              <option value="1">1st Semester</option>
              <option value="2">2nd Semester</option>
              <option value="3">3rd Semester</option>
              <option value="4">4th Semester</option>
              <option value="5">5th Semester</option>
              <option value="6">6th Semester</option>
              <option value="7">7th Semester</option>
              <option value="8">8th Semester</option>
              <option value="Elective">Elective</option>
            </select>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Course</button>
      </form>
    </div>
  </div>
</div>

<!-- Room Form Popup -->
<div class="w3-container">
  <div id="room-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('room-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-room.php">
        <p>Please provide the following details for room.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="number" class="form-control" placeholder="Room #" pattern="[0-9]*" min="1" name="room_no" required>
          </div>
          <div class="form-group col-6">
            <select class="form-control" name="floor_no">
              <option selected disabled>Floor #</option>
              <option value="Ground">Ground Floor</option>
              <option value="1st Floor">1st Floor</option>
              <option value="2nd Floor">2nd Floor</option>
              <option value="3rd Floor">3rd Floor</option>
              <option value="4th Floor">4th Floor</option>
              <option value="5th Floor">5th Floor</option>
              <option value="6th Floor">6th Floor</option>
              <option value="7th Floor">7th Floor</option>
              <option value="8th Floor">8th Floor</option>
              <option value="9th Floor">9th Floor</option>
              <option value="10th Floor">10th Floor</option>
              <option value="11th Floor">11th Floor</option>
              <option value="12th Floor">12th Floor</option>
            </select>
          </div>
          <div class="form-group col-6">
            <input type="number" id="my-number-input" class="form-control" placeholder="Room Capacity" pattern="[0-9]*" min="1" name="room_capacity" required>
          </div>
          <div class="form-group col-6">
            <input type="name" class="form-control" placeholder="Room Type" name="room_type" pattern="[a-zA-Z][a-zA-Z ]{1,}">
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Room</button>
      </form>
    </div>
  </div>
</div>

<!-- Slots Form Popup -->
<div class="w3-container">
  <div id="slots-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('slots-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/save-slot.php">
        <p>Please provide the following details for slot.</p>
        <div class="form-row">
          <div class="form-group col-6">
              <?php $query = mysqli_query($con,"SELECT room_no, room_type FROM rooms ORDER BY room_no"); ?>
              <select class="form-control" name="room_no" required>
                <option value="" selected disabled>Select Room</option>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                  <option value="<?php echo $row["room_no"] ?>"><?php echo $row["room_no"].' - '.$row["room_type"] ?></option>
                <?php endwhile; ?>
              </select>
          </div>
          <div class="form-group col-6">
            <select class="form-control" name="time-slots" required>
              <option value="" selected disabled>Select Time Slot</option>
              <option value="slot1">09.00 - 12.30</option>
              <option value="slot2">01.00 - 03.30</option>
              <option value="slot3">04.00 - 06.30</option>
              <option value="slot4">07.00 - 08.30</option>
            </select>
          </div>
          <div class="form-group col-12">
            <select class="form-control" name="day" required>
              <option value="" selected disabled>Select Day</option>
              <option value="Day-1">Day 1</option>
              <option value="Day-2">Day 2</option>
              <option value="Day-3">Day 3</option>
              <option value="Day-4">Day 4</option>
              <option value="Day-5">Day 5</option>
              <option value="Day-6">Day 6</option>
              <option value="Day-7">Day 7</option>
              <option value="Day-8">Day 8</option>
            </select>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Add Slot</button>
      </form>
    </div>
  </div>
</div>
<?php require("../footer.php"); ?>