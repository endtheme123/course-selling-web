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
        <label>First Name</label>
        <?php
            if(isset($_GET['fname'])){?>
            <input type="text" name = "fname" placeholder = "First name" value = <?php echo $_GET['fname']; ?>><br>
          
        <?php } else { ?>
            <input type="text" name = "fname" placeholder = "First name"><br>

        <?php } ?>

        <!-- <label>First Name</label>
        <input type="text" name = "fname" placeholder = "First name"><br> -->

        <!-- <label>Family Name</label>
        <input type="text" name = "faname" placeholder = "Family name"><br> -->
        <label>Family Name</label>
        <?php
            if(isset($_GET['faname'])){?>
            <input type="text" name = "faname" placeholder = "First name" value = <?php echo $_GET['faname']; ?>><br>
          
        <?php } else { ?>
            <input type="text" name = "faname" placeholder = "First name"><br>

        <?php } ?>        
        

        <label>Age</label>
        <input type="number" name = "age" placeholder = "Age"><br>

        
        <label>Email</label>
        <input type="text" name = "email" placeholder = "Email"><br>

        <label>Phone Number</label>
        <input type="number" name = "pnum" placeholder = "Phone Number"><br>

        <label >User type</label>

        <select name="utype">
        <option value="Employer">Employer</option>
        <option value="Student">Student</option>
        
        </select>


        <label>Address</label>
        <input type="text" name = "address" placeholder = "Address"><br>

        <!-- <label>User Name</label>
        <input type="text" name = "uname" placeholder = "Username"><br> -->
        <label>Username</label>
        <?php
            if(isset($_GET['uname'])){?>
            <input type="text" name = "uname" placeholder = "First name" value = <?php echo $_GET['uname']; ?>><br>
          
        <?php } else { ?>
            <input type="text" name = "uname" placeholder = "First name"><br>

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