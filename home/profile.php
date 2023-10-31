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
  <link rel="stylesheet" href="company.css">
  <title>Homepage</title>
</head>

<body>
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
  <?php
  $sql = "SELECT u.*, s.* FROM user AS u
  JOIN student AS s ON u.UserID = s.UserID
  WHERE u.UserID = ". $_SESSION['id'];
        
        
      
        // echo isset($_GET['seach']);
        // echo $sql;
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {

      ?>
  <section class="cover">
  <div class="container">
    <div class = "background_img">
    <img src=<?php echo $row['CoverImage'] ?> alt="">
    
    </div>
      <div class = "profile_img">
      <img src=<?php echo $row['ProfileImage'] ?>  alt="" />
    
      </div>
     <h2><?php echo $row['FamilyName']." ".$row['FirstName'] ?></h2> 
     <h2 class="subname"><?php echo $row['Email'] ?> </h2> 
  </div>
  </section>

  <section class="company_content">
    <h2>Introduction</h2>
    <div >
      <p><b>Name:</b><?php echo $row['FamilyName']." ".$row['FirstName'] ?></p>
      <p><b>Email:</b> <?php echo $row['Email']?>   </p>
      <p><b>Highest Education Level:</b><?php echo $row['HighestEduLevel'] ?></p>
      <p><b>Wanted Postion:</b><?php echo $row['WantedPosition'] ?></p>
    </div>


  </section>

  <section class="company_content" >
    <h2>Exam</h2>
    <div class= "blogs">
    <?php 
    $sql2 = "select t.UserID, t.FinishDate, t.Result, test.TestName, test.Overview
    from testresult t
    INNER JOIN test on t.TestID = test.TestID
    inner join (
        select UserID,TestID, max(FinishDate) as MaxDate
        from testresult
        group by UserID, TestID
    ) tm on t.UserID = tm.UserID and t.FinishDate = tm.MaxDate
    WHERE t.UserID = ".$_SESSION['id'];
        
    
      
    // echo isset($_GET['seach']);
    // echo $sql;
      $result2 = mysqli_query($conn, $sql2);
      while ($row2 = mysqli_fetch_assoc($result2)) {
    ?>

    <a href="">
    
      <h4><?php echo $row2['TestName'] ?> </h4>
      <hr>
      <p><b>Score: </b> <?php echo $row2['Result'] ?></p>
      <p><b>Overview: </b><?php echo strlen($row2['Overview']) > 75 ? substr($row2['Overview'],0,75)."..." : $row2['Overview'] ?></p>
    
    </a>
    
        <?php } ?>
        </div>
  </section>

  <section class="company_content">
    <h2>Course</h2>
    <div class= "blogs">
    <?php 
    $sql3 = "select cos.UserID, DATE(cos.StartDate) as Sdate  , cos.Finish, DATE(cos.FinishDate) as Fdate ,c.CourseName
    from courseownership cos
    INNER JOIN course c on cos.CourseID = c.CourseID
    
    WHERE cos.UserID = ".$_SESSION['id'];
        
    
      
    // echo isset($_GET['seach']);
    // echo $sql;
      $result3 = mysqli_query($conn, $sql3);


      while ($row3 = mysqli_fetch_assoc($result3)) {
    ?>

    <a href="">
    
      <h4><?php echo $row3['CourseName'] ?> </h4>
      <hr>
      <p><b>Starting Date: </b><?php echo $row3['Sdate'] ?></p>
      <p><b>Finishing Date: </b><?php echo $row3['Fdate']==Null ? 'Not Yet' : $row3['Fdate'] ?></p>
      <p><b>Status: </b> <?php echo $row3['Finish'] === 1 ? 'Finished' : 'Studying' ?></p>
      
    
    </a>
    
        <?php } ?>
        </div>


  </section>

  </main>
  <?php } ?>

  <!-- footer with small font + centered -->
  <?php include '../includes/footer.inc'; ?>
</body>

</html>

<?php } else {
    header("location: ../index.php");
    exit();
} ?>