<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/loginApi/database.php';
require_once __DIR__ . '/loginApi/jwtHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    session_start();
    include "db_conn.php";
    $data = json_decode(file_get_contents('php://input'));

    // if (
    //     !isset($data->uname) ||
    //     !isset($data->password) ||
    //     empty(trim($data->uname)) ||
    //     empty(trim($data->password))
    // ):
    //     sendJson(
    //         // http status code
    //         422,
    //         // message
    //         'Please fill all the required fields & None of the fields should be empty.',
    //         // array
    //         ['required_fields' => ['username', 'password']]
    //     );
    // endif;

    if (isset($_POST['uname']) && isset($_POST['password'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $uname = validate($_POST['uname']);
        $password = validate($_POST['password']);
        

        if(empty($uname)) {
            header("location: index.php?error=User Name is required");
            exit();
        } else if (empty($password)) {
            header("location: index.php?error=Password is required");
            exit();
        } else {
            $sql = "SELECT * FROM user Where username = '$uname' AND Password = '$password'";

            
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) === 1){ 
                $row = mysqli_fetch_assoc($result);
                if($row['username'] === $uname && $row['Password']===$password){
                    $_SESSION['username'] = $row['username'];
              
                    $_SESSION['id'] = $row['UserID'];
                  
                    $_SESSION['email'] = $row['Email'];
                  
                    header("location: ./home/home.php");
                   
                    exit(); 
                } else {
                
                    header("location: index.php?error=Incorrect username or password");
                    exit();                
                }
            } else {
               
                header("location: index.php?error=Incorrect username or password");
                exit();
            }
        }
    } else {
        header("location: index.php?error");
        exit();
    }
endif;

sendJson(405, 'Invalid Request Method. HTTP method should be POST');