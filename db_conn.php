<?php
$sname = "feenix-mariadb.swin.edu.au";
$uname = "s103843321";
$password = "091202";
$db_name = "s103843321_db";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "connection failed!";
}

