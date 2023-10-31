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
  <link rel="stylesheet" href="test.css">
  <title>Test</title>
</head>

<body>
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
    <h2>Test And Qualification</h2>
   <hr>
    <div class="tests">
      <?php 
        $sql = "SELECT * FROM test WHERE TestName LIKE '%%'";
        
        
      
      // echo isset($_GET['seach']);
      // echo $sql;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

      ?>
        

        <div class = "test">
          <img src=<?php echo $row['CoverImage'] ?> alt="gg">
          <div class= "test_content">
          <h3><b><?php echo $row['TestName'] ?> </b></h3>
          <h4> <b>Length: </b><?php echo $row['Time'] ?> hours</h4>
          <?php 
          $sql2 = "
          select t.UserID, t.FinishDate, t.Result
          from testresult t
          inner join (
              select UserID,TestID, max(FinishDate) as MaxDate
              from testresult
              group by UserID, TestID
          ) tm on t.UserID = tm.UserID and t.FinishDate = tm.MaxDate
          WHERE t.UserID = ".$_SESSION['id']." AND t.TestID = ".$row['TestID'].";";

          $result2 = mysqli_query($conn, $sql2);
          if(!$result2) { ?>
            <h4> <b>Score: </b>N/A</h4>
          <?php } else {
            while ($row2 = mysqli_fetch_assoc($result2)) {
          
          
          ?>
          <h4> <b>Score: </b><?php echo $row2['Result'] ?></h4>
          <?php } } ?>
          <h4 class = "ellipsis"><b>Overview: </b> <?php echo strlen($row['Overview']) > 200 ? substr($row['Overview'],0,200)."..." : $row['Overview']?></h4>
          
          </div>
          <a class="button" href="test_prepare.php?testID=<?php echo $row['TestID'] ?>&questionID=1">Take Test</a>
        </div>
        

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