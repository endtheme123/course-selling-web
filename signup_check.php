

<?php
session_start();
include "db_conn.php";
if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['fname']) && isset($_POST['repassword']) && isset($_POST['faname']) && isset($_POST['age']) && isset($_POST['email']) && isset($_POST['pnum']) && isset($_POST['address']) && isset($_POST['utype'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);
    $fname = validate($_POST['fname']);
    $repassword = validate($_POST['repassword']);
    $faname = validate($_POST['faname']);
    $age = validate($_POST['age']);
    $email = validate($_POST['email']);
    $pnum = validate($_POST['pnum']);
    $address = validate($_POST['address']);
    $utype = validate($_POST['utype']);

    $user_data = "uname=" . $uname ."&fname=".$fname."&faname=".$faname;
    

    if(empty($uname)) {
        header("location: signup.php?error=User Name is required&$user_data");
        exit();
    } else if (empty($password)) {
        header("location: signup.php?error=Password is required&$user_data");
        exit();
    } else if (empty($fname)) {
        header("location: signup.php?error=First name is required&$user_data");
        exit();
    }else if (empty($repassword) || $repassword != $password) {
        header("location: signup.php?error=Retyped password must be similar with password&$user_data");
        exit();
    } else if (empty($faname)) {
        header("location: signup.php?error=Family name is required&$user_data");
        exit();
    } else if (empty($age)) {
        header("location: signup.php?error=Age is required&$user_data");
        exit();
    } else if (empty($email)) {
        header("location: signup.php?error=Email is required&$user_data");
        exit();
    }else if (empty($pnum)) {
        header("location: signup.php?error=Phone number is required&$user_data");
        exit();
    }else if (empty($address)) {
        header("location: signup.php?error=Address is required&$user_data");
        exit();
    } else if (empty($utype)) {
        header("location: signup.php?error=User type is required&$user_data");
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
        $_SESSION['fname'] = $fname;
        $_SESSION['faname'] = $faname;
        $_SESSION['age'] = $age;
        $_SESSION['email'] = $email;
        $_SESSION['pnum'] = $pnum;
        $_SESSION['address'] = $address;
        $_SESSION['utype'] = $utype;
        $_SESSION['uname'] = $uname;
        $_SESSION['password'] = $password;
        $_SESSION['repassword'] = $repassword;


        
        header("location: utype_signup.php");
        exit();
    }
} else {
    header("location: signup.php?error");
    exit();
}