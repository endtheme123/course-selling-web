<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/loginApi/database.php';
require_once __DIR__ . '/loginApi/sendJson.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") :
    session_start();
    $data = json_decode(file_get_contents('php://input'));
    include "db_conn.php";

    if (isset($_POST['uname']) && isset($_POST['password'])) {

        $uname = $_POST["uname"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        
        // $passwordRule = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{8,20}$/";

        // if (!preg_match($passwordRule,$password)) {
        // 	$passwordError = "Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit";
        // }

        if(empty($uname)) {
            header("location: forgotpassword.php?error=User Name is required");
            exit();
        } else if (empty($password)) {
            header("location: forgotpassword.php?error=Password is required");
            exit();
        
        } else if (empty($email)) {
            header("location: forgotpassword.php?error=Email is required&$user_data");
            exit();
        } else {
            $sql_get = "SELECT * FROM user Where username = '$uname' AND Email = '$email'";
            $get_user = mysqli_query($conn, $sql_get);
            if(mysqli_num_rows($get_user) === 1){ 
                $row = mysqli_fetch_assoc($get_user);
                if($row['username'] === $uname && $row['Email']===$email){
                    $sql_update = "UPDATE user SET Password = '$password' WHERE Email = '$email' AND username = '".$uname."' ;";
                    $result = mysqli_query($conn, $sql_update);
                    if ($result) {
                        header("location: index.php?success=You have successfully change password");
                        exit();
                    } else {
                        header("location: forgotpassword.php?error");
                        exit();
                    }
                } else {
                    header("location: forgotpassword.php?error=Incorrect username or email");
                    exit();   
                }
            } else {
                header("location: forgotpassword.php?error=Incorrect username or email");
                exit();   
            }    
        }
    } else {
        header("location: forgotpassword.php?error");
        exit();
    }
endif;

sendJson(405, 'Invalid Request Method. HTTP method should be POST');
?>
