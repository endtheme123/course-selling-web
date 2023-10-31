<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="login.php" method = "post">
        <div id = "logo">
            <img src="./media/image/logo.png" alt="logo">
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
            if(isset($_GET['password'])){?>
            <input type="password" name = "password" placeholder = "Password" value = <?php echo $_GET['password']; ?>><br>
          
        <?php } else { ?>
            <input type="password" name = "password" placeholder = "Password"><br>

        <?php } ?> 
        

        <button type = "submit">Login</button>
        <a href="signup.php" class="ca">Create an account</a>
    </form>
</body>
</html>