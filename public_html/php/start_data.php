<?php
    session_start();
    require_once ('../php/db_config.php');

    $accNo = $_SESSION['accNo'];
    $userType = $_SESSION['userType'];

    if ($userType == 'S') {
        $query = "SELECT studentNo, mwsUser from student where studentNo = $accNo";
    } else if ($userType == 'OA' || $userType == 'SA' || $userType == 'L') {
        $query = "SELECT staffNo, mwsUser from staff where staffNo = $accNo";
    } else {
        //remove when get acc info works
        exit();
    }

    $result = mysqli_query($db_con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $data['valid'] = 'true';
        $data['mwsUser'] = $row['mwsUser'];
    } else {
        //couldn't find accNo in DB
        $data['valid'] = 'false';
    }
       
    // Free and close query+connection
    mysqli_free_result($result);
    mysqli_close($db_con);

    echo json_encode($data);
    exit();


?>