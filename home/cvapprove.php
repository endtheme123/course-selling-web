<?php 
session_start();
include "../db_conn.php";


$sql2 = "INSERT INTO interview(
    UserID, 
    JobID,
    InterviewDate) 
VALUES ("
    .$_GET['UserID'].","
    .$_GET['JobID'].",DATE_ADD(NOW(), INTERVAL 1 DAY));";
echo $sql2;
$result2 = mysqli_query($conn, $sql2);

$sql3 = "update cv_submit
SET State = 'Interview'
WHERE UserID = ".$_GET['UserID']. " AND JobID = ".$_GET["JobID"];
echo $sql3;
$result3 = mysqli_query($conn, $sql3);




header("Location: CVCheck.php")
?>