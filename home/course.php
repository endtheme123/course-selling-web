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
  <link rel="stylesheet" href="course.css">
  <title>Course</title>
</head>

<body>
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
    <h2></h2>
    <div class="filter">
      <h3>Filter</h3>
      <form action="filter.php" method = "POST">
        <label for="search">Name</label>
        <input type="text" name = "search" placeholder = "Search..." id = "search"><br>
        <hr>
        
        <label for="Opt_1">Include scholarship: <input class="checkbox" type="checkbox" id="Opt_1" name="scholarship" value="1">
              </label> <br><br>

        
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
            <br>

            <label for="clim">Cost limit:</label>
        <input type="number" name = "clim"  id = "clim"><br><br>
        <label for="tlimin">Time:</label>
        <input type="number" name = "tlimin"  id = "tlimin">
        <label for="tlimax">to</label>
        <input type="number" name = "tlimax"  id = "tlimax">
        <br>
        <button type = "submit">apply</button>
      </form>
    </div>
    <div class="courses">
      <?php 
        $sql = "SELECT * FROM course WHERE CourseName LIKE '%%'";
        
        if(isset($_GET['search'])) {
          $sql = $sql . " AND CourseName LIKE '%".$_GET['search']."%'";
        }
        if(isset($_GET['domain'])) {
          $sql = $sql . " AND ( 1 = 0";
          foreach($_GET['domain'] as $domain) {
            $sql = $sql . " OR Tag LIKE '%$domain%'";
          }

          $sql = $sql . " ) ";
          
      }
      if(isset($_GET['clim']) && $_GET['clim'] > 0)  {
       
        $sql = $sql . " AND Cost <= ".(int)$_GET['clim'];
      }
      
      
      if(isset($_GET['tlimin'])) {
        $sql = $sql . " AND Time >=". (int)$_GET['tlimin'];
      }
      
      if(isset($_GET['tlimax']) && $_GET['tlimax'] > 0) {
        $sql = $sql . " AND Time <= ".(int)$_GET['tlimax'];
      }
      if(isset($_GET['scholarship'])) {
        if((int)$_GET['scholarship'] === 1) {
          $sql = $sql . " AND Scholarship > 0";
        }
      }
      // echo isset($_GET['seach']);
      // echo $sql;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

      ?>
        <div class = "course">
          <img src=<?php echo $row['CoverImage'] ?> alt="gg">
          <h3><b><?php echo $row['CourseName'] ?> </b></h3>
          <h4><?php echo $row['Cost'] ?> VND</h4>
          <h4> <b>Length: </b><?php echo $row['Time'] ?> lectures</h4>
          <h4><b>Scholarship: </b> <?php echo $row['Scholarship'] ?>%</h4>
          <?php 
    $sql2 = "SELECT * FROM courseownership WHERE UserID = ".$_SESSION['id']. " AND CourseID = ".$row['CourseID'];
       
    
      
    // echo isset($_GET['seach']);
    // echo $sql;
      $result2 = mysqli_query($conn, $sql2);
      if(mysqli_num_rows($result2)===0) {
        
    ?>
          <a class="button" href="course_submit.php?CourseID=<?php echo $row['CourseID'] ?>">Submit</a>
          <?php } else { ?> 
            
            <p class="button submited">Submitted</p>
            <?php } ?>
        </div>


        <div class = "course">
          <img src=<?php echo $row['CoverImage'] ?> alt="gg">
          <h3><b><?php echo $row['CourseName'] ?> </b></h3>
          <h4><?php echo $row['Cost'] ?> VND</h4>
          <h4> <b>Length: </b><?php echo $row['Time'] ?> lectures</h4>
          <h4><b>Scholarship: </b> <?php echo $row['Scholarship'] ?>%</h4>
          <?php 
    $sql2 = "SELECT * FROM courseownership WHERE UserID = ".$_SESSION['id']. " AND CourseID = ".$row['CourseID'];
       
    
      
    // echo isset($_GET['seach']);
    // echo $sql;
      $result2 = mysqli_query($conn, $sql2);
      if(mysqli_num_rows($result2)===0) {
        
    ?>
          <a class="button" href="course_submit.php?CourseID=<?php echo $row['CourseID'] ?>">Submit</a>
          <?php } else { ?> 
            
            <p class="button submited">Submitted</p>
            <?php } ?>
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