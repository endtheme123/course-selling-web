<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/loginApi/database.php';
require_once __DIR__ . '/loginApi/jwtHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') :
    session_start();
    include "db_conn.php";
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
            $sql = "SELECT * FROM user Where username = '$uname' and Password = '$password'";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                if($row['username'] === $uname && $row['Password']===$password){
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['fname'] = $row['FirstName'];
                    $_SESSION['faname'] = $row['FamilyName'];
                    $_SESSION['id'] = $row['UserID'];
                    $_SESSION['age'] = $row['Age'];
                    $_SESSION['email'] = $row['Email'];
                    $_SESSION['pnum'] = $row['PhoneNumber'];
                    $_SESSION['add'] = $row['Address'];
                    $_SESSION['utype'] = $row['UserType'];

                    if ($_SESSION['utype']=="Employer") {
                        $sql2 = "SELECT * FROM employer Where UserID =". $_SESSION['id'];
                        $result2 = mysqli_query($conn, $sql2);
                        
                        if(mysqli_num_rows($result2) === 1){
                            $row2 = mysqli_fetch_assoc($result2);
                            if($row2['UserID'] === $_SESSION['id']){
                                $_SESSION['CompanyID'] = $row2['CompanyID'];
                                
                            }
                        }
                    }
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

sendJson(405, 'Invalid Request Method. HTTP method should be GET');