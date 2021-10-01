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

function showRecord($conn){
  $sql = "SELECT * FROM user_account";

  if ( $result = $conn->query($sql) ){
    while($row = $result->fetch_assoc()){
      $user_id = $row["user_id"];
      $user_name = $row["user_name"];
      $user_password = $row["user_password"];
      $user_isAdmin = $row["user_isAdmin"];
      $user_isDeleted = $row["user_isDeleted"];
      $user_registration_date = $row["user_registration_date"];

      if ($user_isDeleted == 0){
        echo "
        <tr>
          <td>$user_id</td>
          <td>$user_name</td>
          <td>$user_password</td>
          <td>$user_isAdmin</td>
          <td>$user_isDeleted</td>
          <td>$user_registration_date</td>
        </tr> 
    ";
      }
    }
  }
}


function searchRecord($conn, $q, $for){
  $sql = "SELECT * FROM user_account WHERE user_name = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $q);
  $stmt->execute();

  $sqlData = mysqli_stmt_get_result($stmt);
  $result = mysqli_fetch_assoc($sqlData);

  $user_id = $result['user_id'];
  $user_name = $result['user_name'];
  $user_password = $result['user_password'];
  $user_isAdmin = $result['user_isAdmin'];

  if ($for === "search"){
    if ($result['user_isDeleted'] === 0){
      echo "
          <p><span>Id: </span>{$result['user_id']}</p>
          <p><span>Username: </span>{$result['user_name']}</p>
          <p><span>Password: </span>{$result['user_password']}</p>
          <p><span>Admin: </span>{$result['user_isAdmin']}</p>
          <p><span>Date registered: </span>{$result['user_registration_date']}</p>
        ";
    } else{
      header("location: ../dashboard.php?search_error=user_notfound");
    }
  } elseif($for === "modify"){
    echo "
          <input type='hidden' value='{$user_id}' name='user_id' />
          <input class='main__page__modify-inc-page__form__username' type='text' value='{$user_name}' name='user_name' placeholder='Username...' />
          <input class='main__page__modify-inc-page__form__password' type='password' value='{$user_password}' name='user_password' placeholder='Password...' />
          <div class='main__page__modify-inc-page__form__admin'>
              <input type='hidden' name='user_isAdmin' value='0' />
              <input class='main__page__modify-inc-page__form__admin__checkbox' type='checkbox' name='user_isAdmin' id='user_isAdmin' value='{$user_isAdmin}' />
              <label for='user_isAdmin' class='main__page__modify-inc-page__form__admin__label'>Admin</label>
          </div>
          <button class='login-section__form__login-button' type='submit' name='modify'>
            Modify
          </button>
  ";
  }
}

function passwordSame($conn, $user_id, $user_password){
  $sql = "SELECT user_password FROM user_account WHERE user_id = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $databasePassword = mysqli_stmt_get_result($stmt);
   
  
  if ($user_password == $databasePassword){
    return true;
  } else{
    return false;
  }

  $stmt->close();
  $conn->close();
}

function updateRecord($conn, $user_name, $user_password, $user_isAdmin, $user_id){
  $sql = "UPDATE user_account SET user_name = ?, user_password = ?, user_isAdmin = ? WHERE user_id = ?;";

  $processed_user_password = "";
  if (passwordSame($conn, $user_id, $user_password !== false)){
    $processed_user_password = $user_password;
  } else{
    $processed_user_password = password_hash($user_password, PASSWORD_DEFAULT); 
  }

  $updateSuccess = "";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssii", $user_name, $processed_user_password, $user_isAdmin, $user_id);
  if ($stmt->execute() === true){
    $updateSuccess = true;
  } else{
    $updateSuccess = false;
  }

  return $updateSuccess;

  $stmt->close;
  $conn->close;
}

function removeRecord($conn, $q){
  $user_isDeleted = 1;
  $sql = "UPDATE user_account SET user_isDeleted = ? WHERE user_name = ?;";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $user_isDeleted, $q);
  $stmt->execute();

  $removalSuccess = "";
  if ($stmt->execute() != true){
    $removalSuccess = false;
  } else{
    $removalSuccess = true;
  }

  return $removalSuccess;
}

function recoverRecord($conn, $q){
  $user_isDeleted = 0;
  $sql = "UPDATE user_account SET user_isDeleted = ? WHERE user_name = ?;";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $user_isDeleted, $q);
  $stmt->execute();

  $removalSuccess = "";
  if ($stmt->execute() != true){
    $removalSuccess = false;
  } else{
    $removalSuccess = true;
  }

  return $removalSuccess;
}
