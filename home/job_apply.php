<?php 
session_start();
include "../db_conn.php";


$sql3 = "INSERT INTO cv_submit(
    UserID, 
    JobID,
    SubmitDate,
    State) 
VALUES ("
    .$_SESSION['id'].","
    .$_GET['JobID'].",now(), 'Awaiting');";
echo $sql3;
$result3 = mysqli_query($conn, $sql3);




header("Location: find_job.php")
?>