<?php
    if(!isset($_SESSION)) {session_start();}
    include "connect.php"; 
    
    //REGISTER / ADD ACCOUNT
    if(isset($_POST['register'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        //INPUT VALIDATION
        $name_pattern = "/^[a-zA-Z -]{1,50}$/";
        if(preg_match($name_pattern, $firstname) == 1){
            $firstname_valid = 1;
        } else{ 
            echo "<script language='javascript'>window.alert('Invalid First Name!'); window.location='../index.php';</script>"; 
        }
        if(preg_match($name_pattern, $lastname) == 1){
            $lastname_valid = 1;
        } else{ 
            echo "<script language='javascript'>window.alert('Invalid Last Name!'); window.location='../index.php';</script>"; 
        }
        if(preg_match($name_pattern, $username) == 1){
            $username_valid = 1;
        } else{ 
            echo "<script language='javascript'>window.alert('Invalid Username!'); window.location='../index.php';</script>"; 
        }
        if(strlen($password) > 7 && strlen($password) < 51){
            $password_valid = 1;
            $hash_password = md5($password);
        } else{ 
            echo "<script language='javascript'>window.alert('Invalid Password!'); window.location='../index.php';</script>"; 
        }

        //INSERT IF VALID
        if($firstname_valid == 1 && $lastname_valid == 1 && $username_valid == 1 && $password_valid == 1){
            $register_sql = "INSERT INTO sellers (seller_firstName, seller_lastName, seller_userName, seller_password)
                            VALUES('$firstname', '$lastname', '$username', '$hash_password')";
            $register_query = $conn->query($register_sql) or die ($conn->error);
            echo "<script>alert('registration success!');location ='../index.php';</script>";
        } else {
            echo "<script>alert('Invalid input!');location ='../index.php';</script>";
        }
    }

    //LOG IN
    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $username_sql = "SELECT * FROM sellers WHERE seller_userName = '$username'";
        $username_query = $conn->query($username_sql) or die ($conn->error);
        $username_count = $username_query->num_rows;

        if($username_count > 0){
            $_SESSION['userName'] = $username;
            // may existing username (positive)
            // check if valid username is not ubos na yung attempt
            $attempt_sql = "SELECT * FROM sellers WHERE status != 0 AND seller_userName = '$username'";
            $attempt_query = $conn->query($attempt_sql) or die ($conn->error);
            $attempt_count = $attempt_query->num_rows;
            if($attempt_count > 0){
                // check password | ALL
                $check_sql = "SELECT * FROM sellers WHERE seller_password = '$password' AND status != 0 AND seller_userName = '$username'";
                $check_query = $conn->query($check_sql) or die ($conn->error);
                $check_count = $check_query->num_rows;
                
                if($check_count > 0){
                    $reset_statusSQL = "UPDATE sellers SET status = '5', lock_date = '' WHERE seller_userName = '$_SESSION[userName]'";
                    $reset_statusQuery = $conn->query($reset_statusSQL) or die ($conn->error);
                    $sellers = $username_query->fetch_assoc();
                    $_SESSION['firstName'] = $sellers['seller_firstName'];
                    $_SESSION['lastName'] = $sellers['seller_lastName'];
                    header('Location:../index.php');
                } else{
                    // get status
                    $status_sql = "SELECT * FROM sellers WHERE seller_userName = '$_SESSION[userName]'";
                    $status_query = $conn->query($status_sql) or die ($conn->error);
                    $status_row = $status_query->fetch_assoc();
                    $current_status = $status_row['status'];
                    $new_status = $current_status-1;
                    // UPDATE STATUS
                    $update_statusSQL = "UPDATE sellers SET status = '$new_status' WHERE seller_userName = '$_SESSION[userName]'";
                    $update_statusQuery = $conn->query($update_statusSQL) or die ($conn->error);
                    if($update_statusQuery){
                        if($new_status == 0){
                            date_default_timezone_set('Asia/Manila');
                            $timer = strtotime("now +1 hour");
                            $time_stamp = date('M d, Y h:i:s a', $timer);
                            $update_lockSQL = "UPDATE sellers SET lock_date = '$time_stamp' WHERE seller_userName = '$_SESSION[userName]'";
                            $update_lockQuery = $conn->query($update_lockSQL) or die ($conn->error);
                            echo "<script>alert('Your account is locked. Please try again later.');location ='../index.php';</script>";
                        } elseif($new_status == 1){
                            echo "
                                <script>
                                    alert('Careful! This is your last attempt. Account will be locked for an hour.');
                                    location ='../index.php';
                                </script>
                            ";
                        } else{
                            echo "<script>alert('Wrong password. Remaing attempt: ".$new_status."');location ='../index.php';</script>";
                        }
                    }
                }
            } else {
                echo "<script>alert('Your account is locked. Please try again later.');location ='../index.php';</script>";
            }
        } else{
            echo "<script>alert('Wrong username.');location ='../index.php';</script>";
        }
    }

    //LOG OUT
    if(isset($_POST['logout'])){
        session_destroy();
        header('Location:../index.php');
    }
?>