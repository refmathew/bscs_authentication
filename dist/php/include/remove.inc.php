<?php

require_once "db.inc.php";
require_once "functions.inc.php";

$q = $_POST['q'];
$removeRecord = removeRecord($conn, $q);

if ($removeRecord !== true){
  header("location: ../dashboard.php?remove_failed");
} else{
  header("location: ../dashboard.php?remove_success");
}
