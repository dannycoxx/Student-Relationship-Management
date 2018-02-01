<?php
    require_once ('../php/db_config.php');

    $studentMws = $_POST['studentMws'];
    $userType = $_POST['userType'];
    $requesterMws = $_POST['requesterMws'];

    $studentData = array();

    if ($userType == "S") {
        $query = "SELECT studentNo, forename, surname, mwsUser, csdUser, 
        email, prefEmail, permAddress, termAddress, phone, termPhone, 
        advisor, degreeCode, yearStudy, admitYear FROM student WHERE
        mwsUser = '$studentMws'";

        
        if (mysqli_num_rows($result) > 0) {
            $result = mysqli_query($db_con, $query);    
        } else {
            $data = "FALSE";
        }

    } else {
        //Check what permissions user has for student data
    }





    mysqli_free_result($result);
    mysqli_close($db_con);

    echo json_encode($data);
    exit();
?>