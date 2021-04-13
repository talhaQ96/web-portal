<?php 
  session_start(); 
  include('../../database/database-connection.php');
  if(empty($_REQUEST) || empty($_SESSION['id'])){
    header('Location: ../index.php');
  }
  
  require ("../../header.php");

  $code = $_REQUEST['id'];
  $query = mysqli_query($con,"SELECT * FROM courses WHERE code='$code'")or die(mysqli_error($con));
  $row = mysqli_fetch_array($query);
  $count = mysqli_num_rows($query);

  if($count == 0){
    header('Location: ../index.php');
  }
?>

<!-- Course Form Popup -->
<div class="w3-container update-form">
  <div id="updt-course-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('updt-course-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/update-course.php?id=<?php echo $code ?>">
        <p>Please provide the following details for course.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input value="<?php echo $row['code'] ?>" type="text" class="form-control" placeholder="Code" name="code" required disabled>
          </div>
          <div class="form-group col-6">
            <input value="<?php echo $row['cr_hrs'] ?>" type="number" class="form-control" placeholder="Cr. Hours" pattern="[0-9]*" min="1" max="3"name="cr_hrs" required>
          </div>
          <div class="form-group col-6">
            <input value="<?php echo $row['c_name'] ?>" type="name" class="form-control" placeholder="Course Name" name="cname" required>
          </div>
          <div class="form-group col-6">
            <select class="form-control" name="semester_no">
              <option disabled>Semester</option>
              <option <?php if($row['semester']==1){echo "selected";}?>value="1">1st Semester</option>
              <option <?php if($row['semester']==2){echo "selected";}?>value="2">2nd Semester</option>
              <option <?php if($row['semester']==3){echo "selected";}?>value="3">3rd Semester</option>
              <option <?php if($row['semester']==4){echo "selected";}?>value="4">4th Semester</option>
              <option <?php if($row['semester']==5){echo "selected";}?>value="5">5th Semester</option>
              <option <?php if($row['semester']==6){echo "selected";}?>value="6">6th Semester</option>
              <option <?php if($row['semester']==7){echo "selected";}?>value="7">7th Semester</option>
              <option <?php if($row['semester']==8){echo "selected";}?>value="8">8th Semester</option>
              <option <?php if($row['semester']=="Elective"){echo "selected";} ?>value="Elective">Elective</option>
            </select>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<?php require("../../footer.php"); ?>