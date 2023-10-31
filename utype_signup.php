<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="utype_signup.css">
</head>
<body>
    <form action="usignup_check.php" method = "post">
        <div id = "logo">
            <img src="./media/image/logo.png" alt="logo">
        </div>
        
        <?php
        session_start();
            if($_SESSION['utype']==="Student"){?>
          
        

        <h2>Extra Student Info</h2>

              
        <label >Highest Education Level</label>

        <select name="hedu">
        <option value="Master">Master</option>
        <option value="PhD">PhD</option>
        <option value="HighSchool">High School</option>
        <option value="Graduated">Graduated</option>
        
        </select>

        <label>Skill/Major</label>
        <select name="skill">
        <option value="Hospitality">Hospitality</option>
        <option value="PersonalServices">Personal Services</option>
        
        
        </select>

        </select>

        <label>Wanted Position</label>
        <select name="position">
        <option value="barista">Barista</option>
        <option value="makeup">Make up</option>
        <option value="manicurist">Manicurist</option>massage therapist
        <option value="massage_therapist">Massage Therapist</option>
        
        </select>
        <?php } else { ?>

            <h2>Extra Employer Info</h2>
            <?php
                if(isset($_GET['error'])){?>
             <p class = "error"><?php echo $_GET['error']; ?></p>  
            <?php } ?>
              
            <label >Company ID</label>

            <input type="text" name = "comid" placeholder = "Company ID"><br>


            

            <label>Role</label>
            <input type="text" name = "role" placeholder = "Role"><br>
            <label>Start Date</label>
            <input type="date" name = "sdate" placeholder = "Start Date"><br>


            

        <?php } ?>
        <button type = "submit">Submit</button>
        <button ><a href="signup.php">Back</a></button>
        <a href="index.php" class="ca">Already have an account</a>
    </form>
</body>
</html>