<?php 
  session_start(); 
  include('../../database/database-connection.php');
  if(empty($_REQUEST) || empty($_SESSION['id'])){
    header('Location: ../index.php');
  }
  
  require ("../../header.php");

  $room_no = $_REQUEST['id'];
  $query = mysqli_query($con,"SELECT * FROM rooms WHERE room_no = '$room_no'")or die(mysqli_error($con));
  $row = mysqli_fetch_array($query);
  $count = mysqli_num_rows($query);

  if($count == 0){
    header('Location: ../index.php');
  }
?>

<!-- Room Form Popup -->
<div class="w3-container update-form">
  <div id="updt-room-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('updt-room-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/update-room.php?id=<?php echo $room_no ?>">
        <p>Please provide the following details for room.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input value="<?php echo $row['room_no'] ?>" type="number" class="form-control" placeholder="Room #" pattern="[0-9]*" min="1" name="room_no" required disabled>
          </div>
          <div class="form-group col-6">
            <select class="form-control" name="floor_no">
              <option disabled>Floor #</option>
              <option <?php if($row['floor_no'] == 'Ground')    {echo ('selected');} ?> value="Ground">Ground Floor  </option>
              <option <?php if($row['floor_no'] == '1st Floor') {echo ('selected');} ?> value="1st Floor">1st Floor  </option>
              <option <?php if($row['floor_no'] == '2nd Floor') {echo ('selected');} ?> value="2nd Floor">2nd Floor  </option>
              <option <?php if($row['floor_no'] == '3rd Floor') {echo ('selected');} ?> value="3rd Floor">3rd Floor  </option>
              <option <?php if($row['floor_no'] == '4th Floor') {echo ('selected');} ?> value="4th Floor">4th Floor  </option>
              <option <?php if($row['floor_no'] == '5th Floor') {echo ('selected');} ?> value="5th Floor">5th Floor  </option>
              <option <?php if($row['floor_no'] == '6th Floor') {echo ('selected');} ?> value="6th Floor">6th Floor  </option>
              <option <?php if($row['floor_no'] == '7th Floor') {echo ('selected');} ?> value="7th Floor">7th Floor  </option>
              <option <?php if($row['floor_no'] == '8th Floor') {echo ('selected');} ?> value="8th Floor">8th Floor  </option>
              <option <?php if($row['floor_no'] == '9th Floor') {echo ('selected');} ?> value="9th Floor">9th Floor  </option>
              <option <?php if($row['floor_no'] == '10th Floor'){echo ('selected');} ?> value="10th Floor">10th Floor</option>
              <option <?php if($row['floor_no'] == '11th Floor'){echo ('selected');} ?> value="11th Floor">11th Floor</option>
              <option <?php if($row['floor_no'] == '12th Floor'){echo ('selected');} ?> value="12th Floor">12th Floor</option>
            </select>
          </div>
          <div class="form-group col-6">
            <input value="<?php echo $row['room_capacity'] ?>" type="number" id="my-number-input" class="form-control" placeholder="Room Capacity" pattern="[0-9]*" min="1" name="room_capacity" required>
          </div>
          <div class="form-group col-6">
            <input value="<?php echo $row['room_type'] ?>" type="name" class="form-control" placeholder="Room Type" name="room_type" pattern="[a-zA-Z&][a-zA-Z& ]{1,}">
          </div>
        </div>
        <button type="submit" class="lnkbtn">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<?php require("../../footer.php"); ?>