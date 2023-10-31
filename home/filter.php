<?php 
$extra_data = "";
if(isset($_POST['search'])) {
    $extra_data = $extra_data . "&search=".$_POST['search'];
}

if(isset($_POST['scholarship'])) {
    $extra_data = $extra_data . "&scholarship=".$_POST['scholarship'];
}



if(isset($_POST['domain'])) {
    foreach($_POST['domain'] as $domain) {
        $extra_data = $extra_data . "&domain[]=".$domain;
    }
    
}
if(isset($_POST['clim'])) {
    $extra_data = $extra_data . "&clim=".$_POST['clim'];
}


if(isset($_POST['tlimin'])) {
    $extra_data = $extra_data . "&tlimin=".$_POST['tlimin'];
}

if(isset($_POST['tlimax'])) {
    $extra_data = $extra_data . "&tlimax=".$_POST['tlimax'];
}
header("Location: course.php?$extra_data")
?>