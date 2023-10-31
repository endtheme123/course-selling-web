<?php 
session_start();
include "../db_conn.php";
if (isset($_POST[$_SESSION['last_row']])) {
    $_SESSION['answers'][$_SESSION['last_row']]=$_POST[$_SESSION['last_row']];
}

$score = 0;
foreach($_SESSION['answers'] as $key => $val){ 
    $sql = "SELECT * FROM question WHERE testID=".$_GET['testID']." AND QuestionID=".$key;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if($row['Answer']===$val) {
                $score += 1;
            }
        }
} 

$sql3 = "INSERT INTO testresult(
    UserID, 
    TestID,
    FinishDate,
    Result) 
VALUES ("
    .$_SESSION['id'].","
    .$_GET['testID'].",now(),"
    .$score.
    

");";
$result3 = mysqli_query($conn, $sql3);




header("Location: test.php")
?>