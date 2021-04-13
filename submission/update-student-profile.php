<?php 
  session_start();
  include('../database/database-connection.php');
  
  if(empty($_POST)){
    header('Location:../index.php');
  }

  else{
    $coverphoto_name = $id . '_' . time() .'_'. $_FILES['coverphoto']['name'];
    $targetcoverImg_folder = '../assets/images/users/' . $coverphoto_name;
    $profilephoto_name = $id . '_' . time() .'_'. $_FILES['profilephoto']['name'];
    $targetprofileImg_folder = '../assets/images/users/' . $profilephoto_name;

    if (move_uploaded_file($_FILES['coverphoto']['tmp_name'], $targetcoverImg_folder)) {
      mysqli_query($con, "UPDATE students SET cover_img_name = '$coverphoto_name' WHERE student_id='$id'")or die(mysqli_error($con));
    }

    if (move_uploaded_file($_FILES['profilephoto']['tmp_name'], $targetprofileImg_folder)) {
      mysqli_query($con, "UPDATE students SET profile_img_name = '$profilephoto_name' WHERE student_id='$id'")or die(mysqli_error($con));
    }

    echo "<script type='text/javascript'>alert('Information updated successfully!');</script>";
    echo "<script>document.location='../page-templates/student-dashboard.php'</script>";
  }
?>