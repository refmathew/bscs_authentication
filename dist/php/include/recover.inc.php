<?php

require_once "db.inc.php";
require_once "functions.inc.php";

$q = $_POST['q'];
$recoverRecord = recoverRecord($conn, $q);

if ($recoverRecord !== true){
  header("location: ../dashboard.php?recover_failed");
} else{
  header("location: ../dashboard.php?recover_success");
}
