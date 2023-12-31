<?php
/**
 * This file use for forgot password function.
 * 
 * It first checks if all required fields are filled in. If not, it throws an error.
 * 
 * It then checks if the email & username is match with database
 * 
 * If everything is ok, it update user password and direct to the login page again/ return a json message to announce user successfully change the password in postman.
 * 
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: PUT, POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


require_once __DIR__ . '/sendJson.php';


if ($_SERVER["REQUEST_METHOD"] == "PUT" || $_SERVER["REQUEST_METHOD"] == "POST" ) :
    session_start();
    include "db_conn.php";
    // Get data from postman ( for postman )
    $inputApi = json_decode(file_get_contents('php://input'));
    // validate data
    if (
        !isset($inputApi->uname) ||
        !isset($inputApi->email) ||
        !isset($inputApi->password) ||   
        empty(trim($inputApi->uname)) ||
        empty(trim($inputApi->email)) ||
        empty(trim($inputApi->password))    
    ):
        // For form action
        if (isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['password'])): 

            // Get data from form field
            $uname = $_POST["uname"];
            $password = $_POST["password"];
            $email = $_POST["email"];

            // validate data
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
                // validate user and email from database
                // if 2 fields match, update the password that filled in the form input
                // after update, direct user to login page
                $sql_get = "SELECT * FROM user Where username = '$uname' AND Email = '$email'";
                $get_user = mysqli_query($conn, $sql_get);
                if(mysqli_num_rows($get_user) === 1){ 
                    $row = mysqli_fetch_assoc($get_user);
                    if($row['username'] === $uname && $row['Email']===$email){
                        // update password
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
        endif;
        sendJson(
            422,
            'Please fill all the required fields & None of the fields should be empty.',
            ['required_fields' => ['username', 'email', 'password']]
        );
    endif;

    $uname = mysqli_real_escape_string($conn, htmlspecialchars(trim($inputApi->uname)));
    $email = mysqli_real_escape_string($conn, trim($inputApi->email));
    $password = trim($inputApi->password);

    $sql_get = "SELECT * FROM user Where username = '$uname' AND Email = '$email'";
    $get_user = mysqli_query($conn, $sql_get);
    if(mysqli_num_rows($get_user) === 1){ 
        $row = mysqli_fetch_assoc($get_user);
        if($row['username'] === $uname && $row['Email']===$email){
            $sql_update = "UPDATE user SET Password = '$password' WHERE Email = '$email' AND username = '".$uname."' ;";
            $result = mysqli_query($conn, $sql_update);
            if ($result) {
                sendJson(200, 'You have successfully changed your password.');
            } else {
                endJson(500, 'Cannot change password');
            }
        } else {
            sendJson(404, 'Incorrect username or password');
        }
    } else {
        sendJson(404, 'Incorrect username or password');
    }    
endif;

sendJson(405, 'Invalid Request Method. HTTP method should be POST');
?>
