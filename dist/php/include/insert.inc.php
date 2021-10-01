<?php
session_start();

if (isset($_POST["insert"])){

  date_default_timezone_set('Asia/Manila');
  $user_registration_date = date('d-m-y H:i:s');
  $user_name = $_POST["user_name"];
  $user_password = $_POST["user_password"];
  $user_isAdmin = $_POST["user_isAdmin"];

  require_once "functions.inc.php";
  require_once "db.inc.php";

  if (incompleteCredentials($user_name, $user_password) !== false){
    header("location: ../dashboard.php?error=incomplete_credentials");
    exit();
  }

  if (usernameExists($conn, $user_name)){
    header("location: ../dashboard.php?error=username_already_exists");
    exit();
  } else{
    if ( insertRecord($conn, $user_name, $user_password, $user_isAdmin, $user_registration_date) !== false){
      header("location: ../dashboard.php?insert_record=success");
      exit();
    } else {
      header("location: ../dashboard.php?insert_record=failed");
      exit();
    }
  }
}
