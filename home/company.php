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
  $sql = "SELECT * FROM company WHERE CompanyID = ". $_SESSION['CompanyID'];
  echo $sql;
        
        
      
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
     <h2><?php echo $row['CompanyName'] ?></h2> 
     <h2 class="subname"><?php echo $row['Industry'] ?> </h2> 
  </div>
  </section>

  <section class="company_content">
    <h2>Company introduction</h2>
    <div >
      <p>
      <?php echo $row['Description'] ?>  
      </p>
    </div>


  </section>

  <section class="company_content" >
    <h2>Recent Blog</h2>
    <div class= "blogs">
    <?php 
    $sql2 = "SELECT *, DATE(UploadDate) as Udate FROM companyblog WHERE CompanyID = ". $_SESSION['CompanyID'];
        
    
      
    // echo isset($_GET['seach']);
    // echo $sql;
      $result2 = mysqli_query($conn, $sql2);
      while ($row2 = mysqli_fetch_assoc($result2)) {
    ?>

    <a href="companyblog.php?BlogID=<?php echo $row2['BlogID'] ?>&CompanyID=<?php echo $_SESSION['CompanyID'] ?>">
    
      <h4><?php echo $row2['Title'] ?> (<?php echo $row2['Udate'] ?>) </h4>
      <hr>
      <p><?php echo strlen($row2['Content']) > 200 ? substr($row2['Content'],0,200)."..." : $row2['Content'] ?></p>
    
    </a>
    
        <?php } ?>
        </div>
  </section>

  <section class="company_content">
    <h2>Available Jobs</h2>
    <div class= "blogs">
    <?php 
    $sql3 = "SELECT * FROM job WHERE CompanyID = ". $_SESSION['CompanyID'];
        
    
      
    // echo isset($_GET['seach']);
    // echo $sql;
      $result3 = mysqli_query($conn, $sql3);
      while ($row3 = mysqli_fetch_assoc($result3)) {
    ?>

    <a href="">
    
      <h4><?php echo $row3['JobTitle'] ?></h4>
      <hr>
      <h4><b>Domain:</b> <?php echo $row3['Domain'] ?></h4>
      <h4><b>Salary:</b> <?php echo $row3['Salary'] ?></h4>
      <p><?php echo strlen($row3['JobDescription']) > 200 ? substr($row3['JobDescription'],0,200)."..." : $row3['JobDescription'] ?></p>
    
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