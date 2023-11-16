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
  <!-- <link rel="apple-touch-icon" sizes="180x180" href="images/favico/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favico/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favico/favicon-16x16.png">
  <link rel="manifest" href="images/favico/site.webmanifest"> -->
  <!-- style sheet link -->
  
  <link rel="stylesheet" href="../styles/styles.css">
  <link rel="stylesheet" href="course.css">
  <script src="http://localhost/course-selling-web/home/truffle-contract.js"></script>
  <script src="http://localhost/course-selling-web/home/web3.min.js"></script>
  <!-- <script src="https://thegreenprojects.org/wp-content/themes/Divi-child/public/js/truffle-contract.js"></script>
  <script src="https://thegreenprojects.org/wp-content/themes/Divi-child/public/js/web3.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
  <title>Course</title>
  
</head>

<body onload ="loadWeb3()">
  <?php include '../includes/header.inc'; ?>
  <!-- main content -->
  <main>
    <!-- <div id="content"></div> -->
    <h2></h2>
    <div class="filter">
      <h3>Filter</h3>
      <form id="sf">
        <label for="search">Name</label>
        <input type="text" name = "search" placeholder = "Search..." id = "search"><br>
        <hr>
        
        <label for="scholar">Include scholarship: <input id = "scholar" type="checkbox"  name="scholarship" value="1">
            </label> <br><br>

        
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
      
    </div>
  </main>

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
                action: "load_data"},
                success: function(response) {
                    // let b = a.map(function(object){
                    //     `<tr><th></th><td>`++`</td></tr>`
                    // });

                    // content = ``;
                    // for (let i = 0; i < b.length; i++) {
                    //     content += b[i];
                    // }
                    $(".courses").html(response);
                }
              });
            } 

            $('#sf').submit(function(e){

              

              
              console.log($("#search").val());
                
                console.log($("#scholar").val());
                console.log($("#clim").val());
                console.log($("#tlimin").val());
               console.log($("#tlimax").val());
              e.preventDefault();
              let domain = $('.checkbox:checked').map(function(_, el) {
                  return $(el).val();
              }).get();
              // domain = domain == null ? [] : domain;
              console.log(domain);
              $.ajax({
                type: 'POST',
                url: 'process.php',
                data: { data: a,
                action: "search_data",
                search: $("#search").val(),
                domain: domain,
                scholarship: $("#scholar:checked").val(),
                clim: $("#clim").val(),
                tlimin: $("#tlimin").val(),
                tlimax: $("#tlimax").val()},
                success: function(response) {
                    // let b = a.map(function(object){
                    //     `<tr><th></th><td>`++`</td></tr>`
                    // });

                    // content = ``;
                    // for (let i = 0; i < b.length; i++) {
                    //     content += b[i];
                    // }
                    $(".courses").html(response);
                }
              });
            });


            async function courseBuy(oid){
              // let oid = this.id;
              console.log(a);
              console.log(oid);
              const web3 = new Web3("http://54.162.167.171:8545");
                // web3.eth.personal.newAccount("0918273645");
                const accounts = await web3.eth.getAccounts();
                const balance =await web3.eth.getBalance("0xc432b76b2f928F1bD8990fFcBe9de847263b88B9");
                console.log(balance);
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
                //sd })

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
                        return friendinstance.usermap(<?php echo $_SESSION['id'] ?>).then(async function(result1){
                          friendinstance.update(<?php echo $_SESSION['id'] ?>, a[oid].BatchID,a[oid].batch,a[oid].CID, {from: result1}).then(async function(result2){
                            
                          })
                        })
                    });
                });

              
              $.ajax({
                type: 'POST',
                url: 'course_submit.php',
                data: { CourseID: a[oid].CID},
                
              });
              };

           
            async function loadWeb3() {
                
                const web3 = new Web3("http://54.162.167.171:8545");
                // web3.eth.personal.newAccount("0918273645");
                const accounts = await web3.eth.getAccounts();
                const balance =await web3.eth.getBalance("0xc432b76b2f928F1bD8990fFcBe9de847263b88B9");
                console.log("the balance is: " + balance);
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
                //         friendinstance.batch_mint(2, 1, {from: '0x133B62D062e0D9EBa964DE0d3eb34e4c4c7809fb'});
 
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
                        return friendinstance.totalSupply().then(async function(result1){
                            totalSupply = result1;
                            console.log(totalSupply);
                            temp = 0;
                            content = ``;
                            for(var i=0; i<totalSupply; i++) {
                                await friendinstance.Ownerships(i).then(function(result2){
                                    // temp += 1;
                                    // content += `<tr><th>`+1+`</th><td>`+result2+`</td></tr>`;
                                    // 
                                    // if(result2.Batch.words[0] != 0) {
                                        console.log(result2.Batch.words[0]);
                                        a.push({
                                            'batch': result2.Batch.words[0],
                                            'BatchID': result2.BatchID.words[0],
                                            'CID': result2.CID.words[0],
                                            'ID': result2.ID.words[0],
                                            'UID': result2.UID.words[0],
                                            'State': result2.state.words[0]
                                        });

                                        a.sort(compare);

                                    // }
                                    
                                })
                            }
                            g(a);
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