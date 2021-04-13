<?php
  session_start();
  include('database/database-connection.php');
  require ("header.php");
  
  if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $query = mysqli_query($con,"SELECT * FROM students WHERE student_id='$userId'")or die(mysqli_error($con));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
     echo "<script>document.location='page-templates/student-dashboard.php'</script>";
    }

    else{
      echo "<script>document.location='page-templates/dashboard.php'</script>";
    }
  }
?>

<section class="secLogin">
  <video autoplay muted loop>
    <source src="assets/images/iqraaa.mp4" type="video/mp4">
  </video>
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-7">
        <div class="formWrap">
          <h1 class="title">Welcome Back</h1>
          <p>Login to manage your account.</p>
          <form class="clearfix" action="http://localhost/portal/submission/login.php" method="post">
            <div class="form-group">
              <label>USER ID</label>
              <input class="form-control" type="number" placeholder="User Id" name="userId">
            </div>
            <div class="form-group">
              <label>
                <span>PASSWORD</span>
              </label>
              <input class="form-control" type="password" placeholder="Password" name="password">
            </div>
            <div class="form-group">
              <label>
                <span>Login as</span>
              </label>
              <select class="form-control" name="role">
                <option value="admin" selected>Admin</option>
                <option value="student">Student</option>
              </select>
            </div>
            <button type="submit" class="lnkbtn">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require("footer.php"); ?>
