

<?php
session_start();
include "db_conn.php";

if($_SESSION['utype']==="Student"){

if (isset($_POST['hedu']) && isset($_POST['skill']) && isset($_POST['position'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $hedu = validate($_POST['hedu']);
    $skill = validate($_POST['skill']);
    $position = validate($_POST['position']);
    

    $user_data = "uname=" . $_SESSION['uname'] ."&password=".$_SESSION['password'];
    

    if(empty($hedu)) {
        header("location: utype_signup.php?error=Highest education level is required");
        exit();
    } else if (empty($skill)) {
        header("location: utype_signup.php?error=Your main skill is required");
        exit();
    } else if (empty($position)) {
        header("location: utype_signup.php?error=Your desire position is required");
        exit();
    
    }   else {
       
        $_SESSION['hedu'] = $hedu;
        $_SESSION['skill'] = $skill;
        $_SESSION['position'] = $position;
        
        $pass = md5($_SESSION['password']);

        $sql = "SELECT * FROM user WHERE username = '".$_SESSION['uname']."'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0) {
            header("location: signup.php?error=The username is taken, please try another&$user_data");
            exit();  
        } else {
            $sql2 = "INSERT INTO user(
                FirstName, 
                FamilyName, 
                username, 
                Age, 
                Email, 
                PhoneNumber, 
                Address, 
                Password, 
                userType) 
            VALUES ('"
                .$_SESSION['fname']."','"
                .$_SESSION['faname']."','"
                .$_SESSION['uname']."',"
                .$_SESSION['age'].",'"
                .$_SESSION['email']."','"
                .$_SESSION['pnum']."','"
                .$_SESSION['address']."','"
                .$_SESSION['password']."','"
                .$_SESSION['utype'].
                

              

            "');";
            
            $result2 = mysqli_query($conn, $sql2);
            $id = mysqli_insert_id($conn);
            $sql3 = "INSERT INTO student(
                userID, 
                HighestEduLevel,
                Skills,
                WantedPosition) 
            VALUES ('"
                .$id."','"
                ."a"."','"
                ."a"."','"
                ."a".
                

            "');";
            $result3 = mysqli_query($conn, $sql3);
            if($result2 && $result3) {
                header("location: index.php?success=Your account has been created");
                exit();  
            } else {
                header("location: signup.php?error=unknowm error occured");
                exit();  
            }

        }

        header("location: index.php?$user_data");
        exit();
    }
} else {
    header("location: utype_signup.php?error");
    exit();
}
}
else {
    if ( isset($_POST['comid']) && isset($_POST['role']) && isset($_POST['sdate'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $comid = validate($_POST['comid']);
        $role = validate($_POST['role']);

        $sdate = date('Y-m-d', strtotime($_POST["sdate"]));
        
        
        $user_data = "uname=" . $_SESSION['uname'] ."&password=".$_SESSION['password'];
 
    
        if(empty($comid)) {
            header("location: utype_signup.php?error=Company ID is required&");
            exit();
        } else if (empty($role)) {
            header("location: utype_signup.php?error=Role is required");
            exit();
        } else if (empty($sdate)) {
            header("location: utype_signup.php?error=Start date is required");
            exit();
        }   else {
            // $sql = "SELECT * FROM user Where username = '$uname' and Password = '$password'";
            // $result = mysqli_query($conn, $sql);
            
            // if(mysqli_num_rows($result) === 1){
            //     $row = mysqli_fetch_assoc($result);
            //     if($row['username'] === $uname && $row['Password']===$password){
            //         $_SESSION['username'] = $row['username'];
            //         $_SESSION['fname'] = $row['FirstName'];
            //         $_SESSION['faname'] = $row['FamilyName'];
            //         $_SESSION['id'] = $row['userID'];
            //         $_SESSION['age'] = $row['Age'];
            //         $_SESSION['email'] = $row['Email'];
            //         $_SESSION['pnum'] = $row['PhoneNumber'];
            //         $_SESSION['add'] = $row['Address'];
            //         $_SESSION['utype'] = $row['userType'];
    
                    
            //         header("location: home.php");
            //         exit(); 
            //     } else {
            //         header("location: utype_signup.php?error=Incorrect username or password");
            //         exit();                
            //     }
            // } else {
            //     header("location: utype_signup.php?error=Incorrect username or password");
            //     exit();
            // }
            $_SESSION['comid'] = $comid;
            $_SESSION['role'] = $role;
            $_SESSION['sdate'] = $sdate;
            $pass = md5($_SESSION['password']);

        $sql = "SELECT * FROM user WHERE username = '".$_SESSION['uname']."'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0) {
            header("location: signup.php?error=The username is taken, please try another&$user_data");
            exit();  
        } else {
            $sql2 = "INSERT INTO user(
                FirstName, 
                FamilyName, 
                username, 
                Age, 
                Email, 
                PhoneNumber, 
                Address, 
                Password, 
                userType) 
            VALUES ('"
                .$_SESSION['fname']."','"
                .$_SESSION['faname']."','"
                .$_SESSION['uname']."',"
                .$_SESSION['age'].",'"
                .$_SESSION['email']."','"
                .$_SESSION['pnum']."','"
                .$_SESSION['address']."','"
                .$_SESSION['password']."','"
                .$_SESSION['utype'].
                

              

            "');";
            
            echo $sql2;
            $result2 = mysqli_query($conn, $sql2);
            $id = mysqli_insert_id($conn);
            echo $sdate;
            $sql3 = "INSERT INTO employer(
                userID, 
                CompanyID,
                Role,
                StartDate) 
            VALUES ("
                .$id.","
                .$comid.",'"
                .$role."','"
                .$sdate.
                

            "');";
            $result3 = mysqli_query($conn, $sql3);
            if($result2 && $result3) {
                header("location: index.php?success=Your account has been created");
                exit();  
            } else {
                header("location: signup.php?error=unknowm error occured");
                exit();  
            }

        }

            header("location: index.php?$user_data");
            exit();
        }
    } else {
        header("location: utype_signup.php?error");
        exit();
    }
}