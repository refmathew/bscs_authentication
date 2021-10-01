<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../dist/style.css" />
</head>
<body class="dashboard-body">
  <?php
    if (isset($_POST["modify"])){

      $user_id = $_POST['user_id'];
      $user_name = $_POST['user_name'];
      $user_password = $_POST['user_password'];
      $user_isAdmin = $_POST['user_isAdmin'];


      if (incompleteCredentials($user_name, $user_password) !== false){
        header("location: includes/modify.inc.php?error=incomplete_credentials");
        exit();
      }


      /* $updateStatus = updateRecord($conn, $user_name, $user_password, $user_isAdmin, $user_id); */

      /* if ( $updateStatus !== true){ */
      /*   header("location: dashboard.php?update_record=failed"); */
      /*   exit(); */
      /* } else { */
      /*   header("location: dashboard.php?update_record=success"); */
      /*   exit(); */
      /* } */
    }  
  ?>
</body>
</html>
