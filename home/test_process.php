<?php
session_start();
include "../db_conn.php";
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
if (isset($_POST[((int)$_GET['questionID']-1)])) {
    $_SESSION['answers'][((int)$_GET['questionID']-1)]=$_POST[((int)$_GET['questionID']-1)];
}

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
  
  <!-- <link rel="stylesheet" href="../styles/styles.css"> -->
  <link rel="stylesheet" href="test_process.css">
  <title>Homepage</title>
</head>

<body>

<?php
        $sql3 = "SELECT * FROM test WHERE TestID=".$_GET['testID'];
        $result = mysqli_query($conn, $sql3);
        
        while ($row = mysqli_fetch_assoc($result)) {
        $time = $row['Time'];
        ?>
        
        <script>
// Set the date we're counting down to
var date = new Date();
var dateMillis = date.getTime();

//JavaScript doesn't have a "time period" object, so I'm assuming you get it as a string
var timePeriod = "<?php echo floor((int)$time) ?>:<?php echo ((int)$time - floor((int)$time))*60 ?>:00"; //I assume this is 15 minutes, so the format is HH:MM:SS

var parts = timePeriod.split(/:/);
var timePeriodMillis = (parseInt(parts[0], 10) * 60 * 60 * 1000) +
                       (parseInt(parts[1], 10) * 60 * 1000) + 
                       (parseInt(parts[2], 10) * 1000);

var newDate = new Date();
newDate.setTime(  dateMillis + timePeriodMillis  );






// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = newDate - now;

  // Time calculations for days, hours, minutes and seconds
  
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("timer").innerHTML =  hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("force_submit").submit();
  }
}, 1000);
</script>
        

        <?php } ?>

  <!-- main content -->
  <main>
  <img src="../media/image/logo.png" alt="Logo" class="logo_image">
    <h1>Test Name</h1>
    <p id = "timer"></p>
    <div class="test_content">
    <div class="question_list">
        <?php
        $sql1 = "SELECT * FROM question WHERE testID=".$_GET['testID'];
        $result = mysqli_query($conn, $sql1);
        if((int)$_GET['questionID']===1) {
            $numResults = mysqli_num_rows($result);
            $_SESSION['last_row'] = $numResults;
        }
        while ($row = mysqli_fetch_assoc($result)) {
        
        ?>
        
            <a href="test_process.php?testID=<?php echo $_GET['testID'] ?>&questionID=<?php echo $row['QuestionID'] ?>">question_<?php echo $row['QuestionID'] ?></a>
        

        <?php } ?>
        </div>
        <div class="question">

            <h3><b>Question:</b></h3>
            <?php
        $sql2 = "SELECT * FROM question WHERE testID=".$_GET['testID']." AND QuestionID=".$_GET['questionID'];
        $result = mysqli_query($conn, $sql2);
        while ($row = mysqli_fetch_assoc($result)) {
        
        ?>  
            <p><?php echo $row['Content'] ?></p>
            <form  action=<?php echo $row['QuestionID'] == $_SESSION['last_row'] ? "test_result.php?testID=".$_GET['testID'] : "test_process.php?testID=".$_GET['testID']."&questionID=".((int)$_GET['questionID']+1 )?> method="POST">
                <input type="text" name="<?php echo $row['QuestionID'] ?>">
                <button type="submit"><?php echo $row['QuestionID'] == $_SESSION['last_row'] ? "Submit" : "Next" ?></button>
            </form>

            <?php } ?>
        </div>

    </div>

    

    <form id="force_submit" action="test_result.php?test_ID=<?php $_GET['testID'] ?>" method="POST" hidden>
        <?php 
        foreach($_SESSION['answers'] as $key => $val){ ?>
            <input type="text" name=<?php echo $key ?> value=<?php echo $val ?>>
        
        
        <?php } ?>
        
        
    </form>
  </main>

 
</body>

</html>

<?php } else {
    header("location: ../index.php");
    exit();
} ?>