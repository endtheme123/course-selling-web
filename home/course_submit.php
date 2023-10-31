<?php 
session_start();
include "../db_conn.php";


$sql3 = "INSERT INTO courseownership(
    UserID, 
    CourseID,
    StartDate,
    Finish) 
VALUES ("
    .$_SESSION['id'].","
    .$_GET['CourseID'].",now(),"
    ."0".
    

");";
$result3 = mysqli_query($conn, $sql3);




header("Location: course.php")
?>