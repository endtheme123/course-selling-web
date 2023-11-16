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
  <link rel="stylesheet" href="company.css">
  <script src="http://localhost/course-selling-web/home/truffle-contract.js"></script>
  <script src="http://localhost/course-selling-web/home/web3.min.js"></script>
  <!-- <script src="https://thegreenprojects.org/wp-content/themes/Divi-child/public/js/truffle-contract.js"></script>
  <script src="https://thegreenprojects.org/wp-content/themes/Divi-child/public/js/web3.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <title>Homepage</title>
</head>

<body onload ="loadOwnedCourse()">
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
  <?php
  $sql = "SELECT u.*, s.* FROM user AS u
  JOIN student AS s ON u.UserID = s.UserID
  WHERE u.UserID = ". $_SESSION['id'];
        
        
      
        // echo isset($_GET['seach']);
         //echo $sql;
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
     <h2><?php echo $row['username'] ?></h2> 
     <h2 class="subname"><?php echo $row['Email'] ?> </h2> 
  </div>
  </section>

  <section class="company_content">
    <h2>Introduction</h2>
    <div >
      <p><b>Username: </b><?php echo $row['username'] ?></p>
      <p><b>Email: </b> <?php echo $row['Email']?>   </p>
    </div>


  </section>

  
  <section class="company_content">
    <h2>Course</h2>
    <div id="courses" class= "blogs">
    <?php 
    $sql3 = "select cos.UserID, DATE(cos.StartDate) as Sdate  , cos.Finish, DATE(cos.FinishDate) as Fdate ,c.CourseName
    from courseownership cos
    INNER JOIN course c on cos.CourseID = c.CourseID
    
    WHERE cos.UserID = ".$_SESSION['id'];
        
    
      
    // echo isset($_GET['seach']);
    // echo $sql3;
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


  <script>
            let a = []
            function compare( a, b ) {
                        if ( a.ID < b.ID ){
                            return -1;
                        }
                        if ( a.ID > b.ID ){
                            return 1;
                        }
                        return 0;
                        }


            function g (a) {
                console.log(a);
                console.log("gg");
                $.ajax({
                type: 'POST',
                url: 'process.php',
                data: { data: a,
                action: "load_owned_data"},
                success: function(response) {
                    // let b = a.map(function(object){
                    //     `<tr><th></th><td>`++`</td></tr>`
                    // });

                    // content = ``;
                    // for (let i = 0; i < b.length; i++) {
                    //     content += b[i];
                    // }
                    $("#courses").html(response);
                }
              });
            } 

           

           
            async function loadOwnedCourse() {
                
                const web3 = new Web3("http://54.162.167.171:8545");
                // web3.eth.personal.newAccount("0918273645");
                const accounts = await web3.eth.getAccounts();
                const balance =await web3.eth.getBalance(accounts[0]);
                
                console.log(accounts);
                var web3Provider = new Web3.providers.HttpProvider("http://54.162.167.171:8545");
                console.log(web3Provider);
                console.log(await web3.eth.getBlockNumber());
 
                // await $.getJSON("http://localhost/course-selling-web/home/Ownership.json", function(data){
                //     console.log(data);
                //     var FriendArtifact = data;
                //     var FriendContract = TruffleContract(FriendArtifact);
                //     console.log(FriendContract);
                //     FriendContract.setProvider(web3Provider);
                //     var friendinstance;
 
                //     FriendContract.deployed().then(function(instance){
                //         friendinstance = instance;
                //         // var NFT = "2:59 3-11-2023, Davinci";batch_mint(uint batch_size, uint _courseID)
                //         friendinstance.batch_mint(2, 4, {from: '0x133B62D062e0D9EBa964DE0d3eb34e4c4c7809fb'});
 
                //     });
                // })

                $.getJSON("http://localhost/course-selling-web/home/Ownership.json", async function(data){
                    console.log(data);
                    var FriendArtifact = data;
                    var FriendContract = TruffleContract(FriendArtifact);
                    console.log(FriendContract);
                    FriendContract.setProvider(web3Provider);
                    var friendinstance;

                    
 
                    await FriendContract.deployed().then(async function(instance){
                        console.log('lmao')
                        friendinstance = instance;
                        return friendinstance.getOwnershipByUser(<?php echo $_SESSION['id'] ?>).then(async function(result1){
                            owned = result1;
                            console.log(owned);
                            temp = 0;
                            content = ``;

                            friendinstance.getTotalOwnedCourse(<?php echo $_SESSION['id'] ?>).then(async function(result2){
                                totalSupply = result2;
                                for(var i=0; i<totalSupply; i++) {
                                await friendinstance.Ownerships(owned[i]).then(function(result3){
                                    // temp += 1;
                                    // content += `<tr><th>`+1+`</th><td>`+result2+`</td></tr>`;
                                    // 
                                    // if(result2.Batch.words[0] != 0) {
                                        console.log(result3.Batch.words[0]);
                                        a.push({
                                            'batch': result3.Batch.words[0],
                                            'BatchID': result3.BatchID.words[0],
                                            'CID': result3.CID.words[0],
                                            'ID': result3.ID.words[0],
                                            'UID': result3.UID.words[0],
                                            'State': result3.state.words[0]
                                        });

                                        a.sort(compare);

                                    // }
                                    
                                })
                            }
                            g(a);
                            })
                            
                        })
                    });
                });

                
            console.log(a);
            console.log("ded");
            }
        
        </script>
</body>

</html>

<?php } else {
    header("location: ../index.php");
    exit();
} ?>