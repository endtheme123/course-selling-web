<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['username'])){


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
    <h1>Hello, <?php echo $_SESSION['fname']. ' ' . $_SESSION['faname']; ?></h1> <br>
   <a href="logout.php">Logout</a>
</body>
</html>

<?php } else {
    header("location: index.php");
    exit();
} ?>