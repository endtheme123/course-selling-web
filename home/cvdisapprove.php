<?php 
session_start();
include "../db_conn.php";




$sql3 = "update cv_submit
SET State = 'Fail'
WHERE UserID = ".$_GET['UserID']. " AND JobID = ".$_GET["JobID"];
echo $sql3;
$result3 = mysqli_query($conn, $sql3);




header("Location: CVCheck.php")
?>