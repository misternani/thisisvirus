<?php
session_start();
include_once 'dbConnection.php';
$eid      = $_GET['eid'];
$total     =$_GET['total'];
$username = $_SESSION['username'];


$result = mysqli_query($con, "DELETE FROM history WHERE username = '$username' and eid = '$eid'") or die('Error');
$result = mysqli_query($con, "DELETE FROM user_answer WHERE username = '$username' and eid = '$eid'") or die('Error');
header("location:account.php?q=1");


?>