<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
</head>
<body>
    <form action="signup_check.php" method = "post">
        <div id = "logo">
            <img src="./media/image/logo.png" alt="logo">
        </div>
        <h2>Sign Up</h2>

        <?php
            if(isset($_GET['error'])){?>
          <p class = "error"><?php echo $_GET['error']; ?></p>  
        <?php } ?>
              
        <label>Email</label>
        <input type="text" name = "email" placeholder = "Email"><br>

        <label>Username</label>
        <?php
            if(isset($_GET['uname'])){?>
            <input type="text" name = "uname" placeholder = "Username" value = <?php echo $_GET['uname']; ?>><br>
          
        <?php } else { ?>
            <input type="text" name = "uname" placeholder = "Username"><br>

        <?php } ?>        

        <label>Password</label>
        <input type="password" name = "password" placeholder = "Password"><br>
        
        <label>Retype Password</label>
        <input type="password" name = "repassword" placeholder = "Retype Password"><br>

        <button type = "submit">Next</button>
        <a href="index.php" class="ca">Already have an account</a>
    </form>
</body>
</html>