<?php 
  session_start();
  if(empty($_SESSION['id'])){
    header('Location:../index.php');
  }
  $userId = $_SESSION['id'];
  include('../database/database-connection.php');
  require ("../header.php");

  $query = mysqli_query($con,"SELECT * FROM admins WHERE admin_id='$userId'")or die(mysqli_error($con));
  $count = mysqli_num_rows($query);

  if ($count > 0) {
    header('Location:../index.php');
  }


  $query = mysqli_query($con,"SELECT * FROM students WHERE student_id='$userId'")or die(mysqli_error($con));
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
          <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#schedule"><span><img src="../assets/images/timetable.png"></span>Schedule</a></li>
        </ul>
      </div>
      <div class="tab-content">
        <!-- Schedule Tab -->
        <div class="tab-pane fade show active" id="schedule">
          <div class="tab-head">
            <h1 class="title">Exam Schedule</h1>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Day</th>
                <th scope="col">Room No.</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Course Code</th>
                <th scope="col">Course</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = mysqli_query($con, "SELECT * FROM schedule WHERE student_id = '$userId' ORDER BY day, room_no, start_time")or die(mysqli_error($con));
                while ($row = mysqli_fetch_array($query)): ?>
                  <tr>
                    <td><?php echo $row ["day"]; ?></td>
                    <th><?php echo $row ["room_no"]; ?></th>
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
  $query = mysqli_query($con,"SELECT * FROM students WHERE student_id='$userId'")or die(mysqli_error($con));
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
      <form class="clearfix popupForm" action="http://localhost/portal/submission/update-student-profile.php" method="post" enctype="multipart/form-data">
        <div class="head" style="padding-bottom: 20px">
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
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/student-security-login.php">
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

<?php require("../footer.php"); ?>