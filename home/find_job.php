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
  <meta name="author" content="Nguyen Ha Huy Hoang">
  <!-- responsive setup -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favico/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favico/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favico/favicon-16x16.png">
  <link rel="manifest" href="images/favico/site.webmanifest">
  <!-- style sheet link -->
  
  <link rel="stylesheet" href="../styles/styles.css">
  <link rel="stylesheet" href="find_job.css">
  <title>job</title>
</head>

<body>
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
    <h2></h2>
    <div class="filter">
      <h3>Filter</h3>
      <form action="job_filter.php" method = "POST">
        <label for="search">Name</label>
        <input type="text" name = "search" placeholder = "Search..." id = "search"><br>
        <hr>
        
        

        
            <label class="choice_label">Domain:</label>

            <div class="option_div">

              <ul>
                <li class="Option">
                  <label for="Opt_4"> <input class="checkbox" type="checkbox" id="Opt_4" name="domain[]" value="AI">AI</label>
                </li>

                <li class="Option">
                  <label for="Opt_2"> <input class="checkbox" type="checkbox" id="Opt_2" name="domain[]" value="DevOps">DevOps</label>
                </li>

                <li class="Option">
                  <label for="Opt_3"> <input class="checkbox" type="checkbox" id="Opt_3" name="domain[]" value="Data"> Data
                    </label>
                </li>

                
              </ul>
            </div>
            <br>

            <label for="salary">Minimum Salary: $</label>
        <input type="number" name = "salary"  id = "salary"><br><br>
        
        <br>
        <button type = "submit">apply</button>
      </form>
    </div>
    <div class="jobs"> 
    <?php 
        $sql = "SELECT j.*, c.CompanyName, c.ProfileImage FROM job j
        INNER JOIN company c ON j.CompanyID = c.CompanyID
        WHERE JobTitle LIKE '%%'";
        
        if(isset($_GET['search'])) {
          $sql = $sql . " AND ( j.JobTitle LIKE '%".$_GET['search']."%' OR j.JobDescription LIKE '%".$_GET['search']."%' OR c.CompanyName LIKE '%".$_GET['search']."%')";
        }
        if(isset($_GET['domain'])) {
          foreach($_GET['domain'] as $domain) {
            $sql = $sql . " AND Domain LIKE '%$domain%'";
          }
          
      }
      if(isset($_GET['salary'])) {
        $sql = $sql . " AND Salary >= ".$_GET['salary'];
      }
      // echo $sql;
      // echo isset($_GET['seach']);
      // echo $sql;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

      ?>
      <div class="job_card">
        <img src="<?php echo $row['ProfileImage'] ?>" alt="">
        <div class="job">
        <h3><b><?php echo $row['JobTitle'] ?></b></h3>
        <!-- <hr> -->
        <div class="job_detail">
        <h3><b>Salary: </b>$<?php echo $row['Salary'] ?></h3>
        <h3><b>Domain: </b><?php echo $row['Domain'] ?></h3>
        <!-- <h3><b>Location: </b>Wall Street</h3> -->
        <h3><b>Company: </b><?php echo $row['CompanyName'] ?></h3>
        </div>
        
      </div>
      <div class="button_con">
      <?php
  $sql2 = "SELECT * From cv_submit where UserID =". $_SESSION['id']." AND JobID =".$row['JobID'];
        
        
      
        // echo isset($_GET['seach']);
        // echo $sql;
          $result2 = mysqli_query($conn, $sql2);
          if (mysqli_num_rows($result2)===0){

      ?>
        <a href="job_apply.php?JobID=<?php echo $row['JobID'] ?>" class="button">Apply</a>
        <?php } else { 
          while ($row2 = mysqli_fetch_assoc($result2)) {?>
          <p class = "button inactive"><?php echo $row2['State'] ?></p>

          <?php }} ?>
      </div>
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