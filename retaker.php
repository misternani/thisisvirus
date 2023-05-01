<?php
session_start();
include_once 'dbConnection.php';
$eid      = $_GET['eid'];
$total     =$_GET['total'];
$c=$_GET['c'];
$username = $_SESSION['username'];


$result = mysqli_query($con, "DELETE FROM history WHERE username = '$username' and eid = '$eid'") or die('Error');
$result = mysqli_query($con, "DELETE FROM user_answer WHERE username = '$username' and eid = '$eid'") or die('Error');
$r = mysqli_query($con, "SELECT category from quiz WHERE  eid = '$eid'") or die('Error');
 while ($rol = mysqli_fetch_row($r)) {$pat=$rol[0];}
$c=$pat;
$string="?cat={$c}&user={$username}";
header("location:catwiser.php".$string);


?>