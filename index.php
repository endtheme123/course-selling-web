<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="http://localhost/course-selling-web/home/truffle-contract.js"></script>
  <script src="http://localhost/course-selling-web/home/web3.min.js"></script>
  <!-- <script src="https://thegreenprojects.org/wp-content/themes/Divi-child/public/js/truffle-contract.js"></script>
  <script src="https://thegreenprojects.org/wp-content/themes/Divi-child/public/js/web3.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<?php  session_start(); ?>
<body onload='<?php echo (!empty($_SESSION["password"]) && !empty($_SESSION["uid"])) ? "addUser()" : "" ?>'>
    <form action="login.php" method = "post">
        <div id = "logo">
            <img src="./media/image/logo3.png" alt="logo">
        </div>
        <h2>Login</h2>

        <?php
            if(isset($_GET['error'])){?>
          <p class = "error"><?php echo $_GET['error']; ?></p>  
        <?php } ?>

        <?php
            if(isset($_GET['success'])){?>
          <p class = "success"><?php echo $_GET['success']; ?></p>  
        <?php } ?>
        <label>User Name</label>
        <?php
            if(isset($_GET['uname'])){?>
            <input type="text" name = "uname" placeholder = "Username" value = <?php echo $_GET['uname']; ?>><br>
          
        <?php } else { ?>
            <input type="text" name = "uname" placeholder = "Username"><br>

        <?php } ?> 
        

        <label>Password</label>
        <?php
            if(isset($_GET['password'])){ ?>
            <input type="password" name = "password" placeholder = "Password" value = <?php echo $_GET['password']; ?>><br>
          
        <?php } else { ?>
            <input type="password" name = "password" placeholder = "Password"><br>

        <?php } ?> 
        

        <button type = "submit">Login</button>
        <a href="signup.php" class="ca">Create an account</a>
        <a href="forgotpassword.php" class="ca">Forgot password</a>
    </form>


    <script>
            
           
            async function addUser() {
                
                const web3 = new Web3("http://54.162.167.171:8545");
                web3.eth.personal.newAccount("<?php echo $_SESSION["password"] ?>");
                const accounts = await web3.eth.getAccounts();
                const balance =await web3.eth.getBalance(accounts[0]);
                
                console.log(accounts);
                var web3Provider = new Web3.providers.HttpProvider("http://54.162.167.171:8545");
                console.log(web3Provider);
                console.log(await web3.eth.getBlockNumber());
 
                

                $.getJSON("http://localhost/course-selling-web/home/Ownership.json", async function(data){
                    console.log(data);
                    var FriendArtifact = data;
                    var FriendContract = TruffleContract(FriendArtifact);
                    console.log(FriendContract);
                    FriendContract.setProvider(web3Provider);
                    var friendinstance;
 
                    await FriendContract.deployed().then(async function(instance){
                        console.log('lmao');
                        friendinstance = instance;
                        friendinstance.createUser(<?php echo $_SESSION["uid"] ?>, accounts[accounts.length -1 ],{from: '0x133B62D062e0D9EBa964DE0d3eb34e4c4c7809fb'}).then(async function(){
                            console.log(accounts[accounts.length -1 ]);
                        })
                    });
                });
                console.log("ok");
                
            }
        
        </script>

    
</body>
</html>