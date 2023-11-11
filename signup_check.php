

<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/loginApi/database.php';
require_once __DIR__ . '/loginApi/sendJson.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    session_start();
    include "db_conn.php";
    $data = json_decode(file_get_contents('php://input'));
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
            

            $hash_password = password_hash($password, PASSWORD_DEFAULT);

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
                  
                    .$uname."','"
                
                    .$email."','"
                
                    .$hash_password.
                
                    

                

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
endif;

sendJson(405, 'Invalid Request Method. HTTP method should be POST');
