

<?php
session_start();
include "db_conn.php";
if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['repassword']) &&  isset($_POST['email'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);
    $repassword = validate($_POST['repassword']);
    $email = validate($_POST['email']);
 
    // $user_data = "uname=" . $uname;
    $user_data = "uname=" . $uname ."&password=".$password;

    if(empty($uname)) {
        header("location: signup.php?error=User Name is required&$user_data");
        exit();
    } else if (empty($password)) {
        header("location: signup.php?error=Password is required&$user_data");
        exit();
    } else if (empty($repassword) || $repassword != $password) {
        header("location: signup.php?error=Retyped password must be similar with password&$user_data");
        exit();
    } else if (empty($email)) {
        header("location: signup.php?error=Email is required&$user_data");
        exit();
    }  else {
        // $sql = "SELECT * FROM user Where username = '$uname' and Password = '$password'";
        // $result = mysqli_query($conn, $sql);
        
        // if(mysqli_num_rows($result) === 1){
        //     $row = mysqli_fetch_assoc($result);
        //     if($row['username'] === $uname && $row['Password']===$password){
        //         $_SESSION['username'] = $row['username'];
        //         $_SESSION['fname'] = $row['FirstName'];
        //         $_SESSION['faname'] = $row['FamilyName'];
        //         $_SESSION['id'] = $row['UserID'];
        //         $_SESSION['age'] = $row['Age'];
        //         $_SESSION['email'] = $row['Email'];
        //         $_SESSION['pnum'] = $row['PhoneNumber'];
        //         $_SESSION['add'] = $row['Address'];
        //         $_SESSION['utype'] = $row['UserType'];

                
        //         header("location: home.php");
        //         exit(); 
        //     } else {
        //         header("location: signup.php?error=Incorrect username or password");
        //         exit();                
        //     }
        // } else {
        //     header("location: signup.php?error=Incorrect username or password");
        //     exit();
        // }
        // $_SESSION['email'] = $email;
        // $_SESSION['uname'] = $uname;
        // $_SESSION['password'] = $password;
        // $_SESSION['repassword'] = $repassword;

        $pass = md5($password);

        $sql = "SELECT * FROM user WHERE username = '".$uname."'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0) {
            header("location: signup.php?error=The username is taken, please try another&$user_data");
            exit();  
        } else {
            $sql2 = "INSERT INTO user(
                username, 
                Email, 
                Password) 
            VALUES ('"
                // .$id."','"
                .$uname."','"
             
                .$email."','"
               
                .$password.
               
                

              

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
     

           
            if($result2) {
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
    header("location: signup.php?error");
    exit();
}