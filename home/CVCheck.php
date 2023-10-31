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
      <form action="cv_filter.php" method = "POST">
        <label for="search">Name</label>
        <input type="text" name = "search" placeholder = "Search..." id = "search"><br>
        <hr>
        
        

        
            <label class="choice_label">Domain:</label>

            <div class="option_div">

              <ul>
                <li class="Option">
                  <label for="Opt_4"> <input class="checkbox" type="checkbox" id="Opt_4" name="domain[]" value="Hospitality">Hospitality</label>
                </li>

                <li class="Option">
                  <label for="Opt_2"> <input class="checkbox" type="checkbox" id="Opt_2" name="domain[]" value="Beauty">Beauty</label>
                </li>

                <li class="Option">
                  <label for="Opt_3"> <input class="checkbox" type="checkbox" id="Opt_3" name="domain[]" value="Food"> Food
                    </label>
                </li>

                
              </ul>
            </div>
            <label class="choice_label">Highest Education Level:</label>
            <div class="option_div">

              <ul>
                <li class="Option">
                  <label for="Opt_4"> <input class="checkbox" type="checkbox" id="Opt_4" name="domain[]" value="Hospitality">PhD</label>
                </li>

                <li class="Option">
                  <label for="Opt_2"> <input class="checkbox" type="checkbox" id="Opt_2" name="domain[]" value="Beauty">Master</label>
                </li>

                <li class="Option">
                  <label for="Opt_3"> <input class="checkbox" type="checkbox" id="Opt_3" name="domain[]" value="Food"> Graduated
                    </label>
                </li>

                <li class="Option">
                  <label for="Opt_3"> <input class="checkbox" type="checkbox" id="Opt_3" name="domain[]" value="Food"> Undergraduated
                    </label>
                </li>

                
              </ul>
            </div>
            <br>

            <br><br>
        
        <br>
        <button type = "submit">apply</button>
      </form>
    </div>
    <div class="jobs"> 
    <?php 
        $sql = "Select cv.*, jc.CompanyID, us.FirstName, us.FamilyName, us.ProfileImage, us.HighestEduLevel, us.Skills, jc.JobTitle From cv_submit cv
        INNER JOIN (
            SELECT j.* from job j WHERE companyID = ".$_SESSION['CompanyID']."
            
        ) jc
        
        ON cv.JobID = jc.JobID
        
        INNER JOIN (
        SELECT u.*, s.HighestEduLevel, s.ProfileImage, s.Skills FROM user u INNER JOIN student s ON u.UserID = s.UserID
        ) us ON cv.UserID = us.UserID Where cv.State = 'Awaiting' ";
        
        if(isset($_GET['search'])) {
          $sql = $sql . " AND ( jc.JobTitle LIKE '%".$_GET['search']."%' OR us.Skills LIKE '%".$_GET['search']."%')";
        }
        if(isset($_GET['domain'])) {
          $sql = $sql . " AND ( 1 = 0";
          foreach($_GET['domain'] as $domain) {
            $sql = $sql . " OR us.Skills LIKE '%$domain%'";
          }
          $sql = $sql . " )";
      }

      if(isset($_GET['HighestEduLevel'])) {
        $sql = $sql . " AND ( 1 = 0";
        foreach($_GET['HighestEduLevel'] as $edu) {
          $sql = $sql . " OR HighestEduLevel LIKE '%$edu%'";
        }
        $sql = $sql . " )";
    }

    // echo $sql;
      
      // echo $sql;
      // echo isset($_GET['seach']);
      // echo $sql;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

      ?>
      <div class="job_card">
        <img src="<?php echo $row['ProfileImage'] ?>" alt="">
        <div class="job">
        <h3><b><?php echo $row['FirstName']." ".$row['FamilyName'] ?></b></h3>
        <!-- <hr> -->
        <div class="job_detail">
        <h3><b>Highest Education Level: </b><?php echo $row['HighestEduLevel'] ?></h3>
        <h3><b>Skill: </b><?php echo $row['Skills'] ?></h3>
        <!-- <h3><b>Location: </b>Wall Street</h3> -->
        <h3><b>Apply for position: </b><?php echo $row['JobTitle'] ?></h3>
        </div>
        
      </div>
      <div class="button_con">
      
        <a href="cvapprove.php?JobID=<?php echo $row['JobID'] ?>&UserID=<?php echo $row['UserID'] ?>" class="button">Approve</a>
        <a href="cvdisapprove.php?JobID=<?php echo $row['JobID'] ?>&UserID=<?php echo $row['UserID'] ?>" class="button">Disapprove</a>
        
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