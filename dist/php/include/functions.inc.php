<?php
function incompleteCredentials($user_name, $user_password){
  $result = "";

  if (empty($user_name) || empty($user_password)){
    $result = true;
  } else{
    $result = false;
  }

  return $result;
}

function userExists ($conn, $user_name, $user_password) {
  /* $sql = "SELECT * FROM user_account WHERE user_name = ? AND user_password = ?;"; */

  /* $result = array(); */
  /* $stmt = $conn->prepare($sql); */
  /* $stmt->bind_param("ss", $user_name, $user_password); */
  /* $stmt->execute(); */

  /* $sqlData = mysqli_stmt_get_result($stmt); */

  /* if ($row = mysqli_fetch_assoc($sqlData)) { */

  /*   if ( $user_name === $row['user_name'] && $user_password === $row['user_password'] ){ */
  /*     /1* check if a user exists *1/ */
  /*     $result[0] = true; */

  /*     /1* return the user's data *1/ */
  /*     $result[1] = $row['user_id']; */
  /*     $result[2] = $row['user_name']; */
  /*     $result[3] = $row['user_password']; */
  /*     $result[4] = $row['user_isAdmin']; */
  /*     $result[5] = $row['user_isDeleted']; */
  /*     $result[6] = $row['user_registration_date']; */
  /*   } else { */
  /*     $result[0] = false; */
  /*   } */
  /* } else { */
  /*   $result[0] = false; */
  /* } */

  /* return $result; */

  /* $stmt->close(); */
  /* $conn->close(); */

 $sql = "SELECT * FROM user_account WHERE user_name = ?;";

  $result = array();
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $user_name);
  $stmt->execute();
  $sqlData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($sqlData)) {

    
    $checkPwd = password_verify( $user_password, $row['user_password'] );

    if ( $user_name === $row['user_name'] && $checkPwd === true ){
      /* check if a user exists */
      $result[0] = true;

      /* return the user's data */
      $result[1] = $row['user_id'];
      $result[2] = $row['user_name'];
      $result[3] = $row['user_password'];
      $result[4] = $row['user_isAdmin'];
      $result[5] = $row['user_isDeleted'];
      $result[6] = $row['user_registration_date'];
    } else {
      $result[0] = false;
    }
  } else {
    $result[0] = false;
  }

  return $result;

  $stmt->close();
  $conn->close();
}

function usernameExists ($conn, $user_name) {
  $sql = "SELECT * FROM user_account WHERE user_name = ?;";

  $result = "";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $user_name);
  $stmt->execute();

  $sqlData = mysqli_stmt_get_result($stmt);
  if (mysqli_fetch_assoc($sqlData)) {
    $result = true; 
  } else{
    $result = false;
  }

  return $result;

  $stmt->close;
  $conn->close;
}

function insertRecord($conn, $user_name, $user_password, $user_isAdmin, $user_registration_date){
  $sql = "INSERT INTO user_account (user_name, user_password, user_isAdmin, user_registration_date) VALUES (?, ?, ?, ?);";

  $hashed_user_password = password_hash($user_password, PASSWORD_DEFAULT);

  $insertionSuccess = "";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssis", $user_name, $hashed_user_password, $user_isAdmin, $user_registration_date);

  if ($stmt->execute() === true){
    $insertionSuccess = true;
  } else{
    $insertionSuccess = false;
  }

  return $insertionSuccess;

  $stmt->close;
  $conn->close;
}
