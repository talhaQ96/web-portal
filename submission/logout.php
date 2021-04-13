<?php 
  session_start();
  include('../database/database-connection.php');
  require ("../header.php");
  if(empty($_SESSION['id'])){
    header('Location:../index.php');
  }

  session_destroy();
  echo "<script>document.location='../index.php'</script>";
?>

