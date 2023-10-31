<?php 
session_start();
$_SESSION['answers'] = array();
header("Location: test_process.php?testID=".$_GET['testID']."&questionID=".$_GET['questionID'])
?>