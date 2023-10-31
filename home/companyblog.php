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
  $sql = "SELECT * FROM company WHERE CompanyID = ". $_GET['CompanyID'];
        
        
      
        // echo isset($_GET['seach']);
        // echo $sql;
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $sql2 = "SELECT *, DATE(UploadDate) as Udate FROM companyblog WHERE CompanyID = ". $_GET['CompanyID'] ." AND BlogID = ".$_GET['BlogID'];
            $result2 = mysqli_query($conn, $sql2);
          while ($row2 = mysqli_fetch_assoc($result2)) {
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
        <br>
        <br>
        <div class="blog_info">

        <h2><?php echo $row2['Title'] ?>  </h2>
        <h4><?php echo $row2['Udate'] ?>  </h4>
        </div>
        
  </div>
  </section>

  <section class="company_content">
    
    <div >
      <p>
      <?php echo $row2['Content'] ?>  
      </p>
    </div>


  </section>

 

  </main>
  <?php }} ?>

  <!-- footer with small font + centered -->
  <?php include '../includes/footer.inc'; ?>
</body>

</html>

<?php } else {
    header("location: ../index.php");
    exit();
} ?>