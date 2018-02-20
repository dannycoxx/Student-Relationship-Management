<?php
    require_once ('../php/db_config.php');

    $username = $_POST['username'];
    $passPre = $_POST['password'];

    $dbSearch = FALSE;
    $data = array();

    // $query = "SELECT staffNo, mwsPassword from staff where mwsUser = ?";
    
    $query = "SELECT staffNo, mwsPassword, mwsUser, userType from staff where mwsUser = ?";

    $stmt = mysqli_stmt_init($db_con);

    for ($i=0; $i <=1; $i++) {
        if(!mysqli_stmt_prepare($stmt, $query)) {
            $data = "Failed to prepare statement";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
    
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            
            if (!empty($row)) {
                $i++;
            }
            $query = "SELECT studentNo, mwsPassword, mwsUser from student where mwsUser = ?";
        }
    }
    //Correct username
    if (!empty($row)) {
        $passHash = password_hash($row['mwsPassword'], PASSWORD_DEFAULT);
        //Correct username, correct password
        if (password_verify($passPre, $passHash)) {
            $data['login'] = 'true';
            $_SESSION['mwsUser'] = $row['mwsUser'];  
            $data['result'] = $row;
            if (!empty($row['staffNo'])) {
                $_SESSION['mwsUser'] = $row['mwsUser'];
            } else {
                $_SESSION['mwsUser'] = $row['mwsUser'];
            }
            if (!empty($row['userType'])) {
                $_SESSION['userType'] = $row['userType'];
            } else {
                $_SESSION['userType'] = 'S';
            }
            
            //correct username, incorrect password
        } else {
                $data['login'] = 'false';
                $data['message'] = "Password incorrect";
                $data['failType'] = "password";
                $data['result'] = $row;
            }
            //Username doesn't exist in staff table
        } else {
            $data['login'] = 'false';
            $data['message'] = "Username not found";
            $data['failType'] = "username";
            $data['result'] = $result;
            $data['stmt'] = $stmt;
        }
        // session_start($row['userType']);
        mysqli_stmt_close($stmt);
    
    
    
    
    mysqli_close($db_con);

    echo json_encode($data);
    
    exit();
?>