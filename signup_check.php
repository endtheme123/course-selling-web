


<?php
/**
 * This file creates a new user account in the database.
 * 
 * It first checks if all required fields are filled in. If not, it throws an error.
 * 
 * It then checks if the username is already in use. If it is, it throws an error.
 * 
 * If everything is ok, it inserts the new user account into the database, and creates a new student record for the user. ( for both form action and Postman request )
 * 
 * It then sends a JSON response with the status of the operation.
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
session_start();

require_once __DIR__ . '/sendJson.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    session_start();
    include "db_conn.php";
    // Get data as JSON from api request platform
    $inputApi= json_decode(file_get_contents('php://input'));
    //  check if all required fields are filled in
    if (
        !isset($inputApi->uname) ||
        !isset($inputApi->email) ||
        !isset($inputApi->password) ||
        !isset($inputApi->repassword) ||
        empty(trim($inputApi->uname)) ||
        empty(trim($inputApi->email)) ||
        empty(trim($inputApi->password)) ||
        empty(trim($inputApi->repassword))
    ):
        if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['repassword']) &&  isset($_POST['email'])) : //For form request and processing
            // processing and sanitize data from form
            function validate($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            // data that get from form fields
            $uname = validate($_POST['uname']);
            $password = validate($_POST['password']);
            $_SESSION['password'] = $password;
            $repassword = validate($_POST['repassword']);
            $email = validate($_POST['email']);
        
            $user_data = "uname=" . $uname ."&password=".$password;

            // validating data
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
                // Find user from db, if user exist return message error, if not create new user
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
                        .$password.
                    "');"; // add data as new user to database

                    $result2 = mysqli_query($conn, $sql2);

                    $last_id = mysqli_insert_id($conn);
                    $_SESSION["uid"] = $last_id;

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
                        header("location: signup.php?error=unknown error occured");
                        exit();  
                    }
                }
                
                header("location: index.php?$user_data");
                exit();
            }
        endif;
        // if a field is missing, send JSON error ( for testing through Postman platform )
        sendJson(
            422,
            'Please fill all the required fields & None of the fields should be empty.',
            ['required_fields' => ['name', 'email', 'password', 'retype password']]
        );
    endif;

      // If all required fields are filled in, start processing the registration request for responding through URL API test in Postman
      // sanitize data
    $uname = mysqli_real_escape_string($conn, htmlspecialchars(trim($inputApi->uname)));
    $email = mysqli_real_escape_string($conn, trim($inputApi->email));
    $password = trim($inputApi->password);
    $repassword = trim($inputApi->repassword);

    // check if user exist
    $sql4 = "SELECT * FROM user WHERE username = '".$uname."'";
    $query = mysqli_query($conn, $sql4);
    $row_num = mysqli_num_rows($query);

    if ($row_num > 0)
        sendJson(422, 'This account already in use!');


    // add data as new user to database
    $sql5 = "INSERT INTO user(
        username, 
        Email, 
        Password) 
    VALUES ('"
        .$uname."','"
        .$email."','"     
        .$password.
    "');"; 

    $query = mysqli_query($conn, $sql5);
    $id = mysqli_insert_id($conn);
    $sql6 = "INSERT INTO student(
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
    $result3 = mysqli_query($conn, $sql6);
    
    if ($query)
        sendJson(201, 'You have successfully registered.');
    sendJson(500, 'Something going wrong.');


endif;

sendJson(405, 'Invalid Request Method. HTTP method should be POST');
?>
