<?php
require_once 'db.inc.php';
require_once 'functions.inc.php';

$q = $_POST['q'];
searchRecord($conn, $q, 'search');
