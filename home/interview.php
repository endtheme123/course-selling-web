<?php
session_start();
include "../db_conn.php";

if(isset($_SESSION['id']) && isset($_SESSION['username'])){


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- requirement head template -->
  <meta name="description" content="A simple index page">
  <meta name="keywords" content="HTML, simple, webpage">
  <meta name="author" content="Nguyen Duc Thinh">
  <!-- responsive setup -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favico/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favico/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favico/favicon-16x16.png">
  <link rel="manifest" href="images/favico/site.webmanifest">
  <!-- style sheet link -->
  
  <link rel="stylesheet" href="../styles/styles.css">
  <link rel="stylesheet" href="interview.css">
  <title>Test</title>
</head>

<body>
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
    <h2>To be interviewed List</h2>
   <hr>
    <div class="tests">
      <?php 
        $sql = "Select cv.*, jc.CompanyID, us.FirstName, us.FamilyName, us.ProfileImage, us.HighestEduLevel, us.Skills, jc.JobTitle From cv_submit cv
        INNER JOIN (
            SELECT j.* from job j WHERE companyID = ".$_SESSION['CompanyID']."
            
        ) jc
        
        ON cv.JobID = jc.JobID
        
        INNER JOIN (
        SELECT u.*, s.HighestEduLevel, s.ProfileImage, s.Skills FROM user u INNER JOIN student s ON u.UserID = s.UserID
        ) us ON cv.UserID = us.UserID Where cv.State = 'Interview' ";
        
        
      
      // echo isset($_GET['seach']);
      // echo $sql;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

      ?>
        

        <div class = "test">
          <img src=<?php echo $row['ProfileImage'] ?> alt="gg">
          <div class= "test_content">
          <h4 class="name"><b><?php echo $row['FirstName']." ".$row['FamilyName'] ?> </b></h4>
          
          <h4><b>Highest Education Level: </b><?php echo $row['HighestEduLevel'] ?></h4>
        <h4><b>Skill: </b><?php echo $row['Skills'] ?></h4>
        <!-- <h4><b>Location: </b>Wall Street</h4> -->
        <h4><b>Apply for position: </b><?php echo $row['JobTitle'] ?></h4>
        <?php 
        $sql2 = "Select * from interview where UserID = ".$row['UserID']." And JobID = ".$row['JobID'];
        
        
      
      // echo isset($_GET['seach']);
      // echo $sql;
        $result2 = mysqli_query($conn, $sql2);
        while ($row2 = mysqli_fetch_assoc($result2)) {

      ?>
          </div>
          <p class = "button"><?php echo $row2['InterviewDate'] ?></p>
        </div>
        <?php } ?>

        <?php } ?>
    </div>
  </main>

  <!-- footer with small font + centered -->
  <?php include '../includes/footer.inc'; ?>
</body>

</html>

<?php } else {
    header("location: ../index.php");
    exit();
} ?>