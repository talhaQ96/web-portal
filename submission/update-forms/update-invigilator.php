<?php 
  session_start(); 
  include('../../database/database-connection.php');
  if(empty($_REQUEST) || empty($_SESSION['id'])){
    header('Location: ../index.php');
  }
  
  require ("../../header.php");

  $userId = $_REQUEST['id'];
  $query = mysqli_query($con,"SELECT * FROM invigilators WHERE invigilator_id='$userId'")or die(mysqli_error($con));
  $row = mysqli_fetch_array($query);
  $count = mysqli_num_rows($query);

  if($count == 0){
    header('Location: ../index.php');
  }
?>

<!-- Invigilator Form Popup -->
<div class="w3-container update-form">
  <div id="updt-invigilator-form" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
      <div class="multicolor-border"></div>
      <div class="w3-center"><br>
        <span onclick="document.getElementById('updt-invigilator-form').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
      <form class="clearfix popupForm" method="post" action="http://localhost/portal/submission/update-invigilator.php?id=<?php echo $userId; ?>">
        <p>Please provide the following details for invigilator.</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input value="<?php echo $row['invigilator_id'] ?>" type="number" class="form-control" placeholder="ID" pattern="[0-9]*" min="1" max="99999"max="99999" name="id" required>
          </div>
          <div class="form-group col-6">
            <input value=" <?php echo $row['designation'] ?>" type="name" class="form-control" placeholder="Designation" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="designation" required>
          </div>
          <div class="form-group col-6">
            <input value=" <?php echo $row['fname'] ?>" type="name" class="form-control" placeholder="First Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="fname" required>
          </div>
          <div class="form-group col-6">
            <input value=" <?php echo $row['lname'] ?>" type="name" class="form-control" placeholder="Last Name" pattern="[a-zA-Z][a-zA-Z ]{1,}" name="lname" required>
          </div>
        </div>
        <button type="submit" class="lnkbtn">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<?php require("../../footer.php"); ?>