<?php
if (isset($_POST["login"])){

  $user_name = $_POST["user_name"];
  $user_password = $_POST["user_password"];

  require_once 'db.inc.php';
  require_once 'functions.inc.php';

  /* check if the input fields were filled */
  if (incompleteCredentials($user_name, $user_password) !== false){
    header("location: ../login.php?error=incomplete_credentials");
    exit();
  }

  /* check if the user exists in the database */
  $result = userExists($conn, $user_name, $user_password);
  echo $user_name;

  if ($result[0] !== false && $result[5] == 0){

    /* check if the user is an admin or not */
    if ( $result[4] == true){
      session_start();
      $_SESSION["user_id"] = $result[1];
      $_SESSION["user_name"] = $result[2];
      $_SESSION["user_password"] = $result[3];
      $_SESSION["user_isAdmin"] = $result[4];
      $_SESSION["user_isDeleted"] = $result[5];
      $_SESSION["user_registration_date"] = $result[6];
      header("location: ../dashboard.php");
      exit();
    } else{
      header ("location: ../normal_user.php");
      exit();
    }
  } else{
    header("location: ../login.php?error=login_failed");
    exit();
  }

} else{
  header("location: ../login.php");
  exit();
}
