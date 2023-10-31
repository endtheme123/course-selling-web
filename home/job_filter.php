<?php 
$extra_data = "";
if(isset($_POST['search'])) {
    $extra_data = $extra_data . "&search=".$_POST['search'];
}

if(isset($_POST['salary']) && $_POST['salary'] != NULL) {
    $extra_data = $extra_data . "&salary=".$_POST['salary'];
}



if(isset($_POST['domain'])) {
    foreach($_POST['domain'] as $domain) {
        $extra_data = $extra_data . "&domain[]=".$domain;
    }
    
}

header("Location: find_job.php?$extra_data")
?>