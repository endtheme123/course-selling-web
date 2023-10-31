<?php 
$extra_data = "";
if(isset($_POST['search'])) {
    $extra_data = $extra_data . "&search=".$_POST['search'];
}



if(isset($_POST['domain'])) {
    foreach($_POST['domain'] as $domain) {
        $extra_data = $extra_data . "&domain[]=".$domain;
    }
    
}


if(isset($_POST['HighestEduLevel'])) {
    foreach($_POST['HighestEduLevel'] as $edu) {
        $extra_data = $extra_data . "&HighestEduLevel[]=".$edu;
    }
    
}
header("Location: CVCheck.php?$extra_data")
?>