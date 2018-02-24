<?php
    include ('../php/db_config.php');
    
    // $studentNo = $_POST['studentNo'];
    // $requesterUserType = $_SESSION['userType'];
    // $requesterAccNo = $_SESSION['accNo'];
    // if ($studentNo == "") {
    //     $studentNo = $requesterAccNo;
    // }

    $studentNo = 1;
    $requesterUserType = 'L';
    $requesterAccNo = 1;
 
    $data = array();
    $moduleCodes = array();
    //Student is accessing their own information
    if ($requesterUserType == "S") {
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
        $data['moduleInfo'] = getModuleInfo($studentNo, $db_con);
        //lecturer requesting information
    } else if ($requesterUserType == "L") {
        //check if lecturer has access rights
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
        $data['moduleInfo'] = getModuleInfo($studentNo, $db_con);
        $data['timetable'] = getTimetable($studentNo, $data, $db_con);
        $data['attendance'] = getAttendance($studentNo, $data, $db_con);
        $data['meetingNotes'] = getMeetingNotes($studentNo, $db_con);

        // $data['personalInfo'] = getMarks($studentMws, $db_con);
        //Office Admin requesting information
    } else if ($requesterUserType == "OA") {
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
        $data['moduleInfo'] = getModuleInfo($studentNo, $db_con);

        //System Admin requesting information
    } else if ($requesterUserType == "SA") {
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
    } else {
        
    }
    // print_r($data);
    // echo json_encode($data);
    mysqli_close($db_con);
    exit();
    
    function getPersonalInformation($studentNo, $db_con) {
        $query = "SELECT studentNo, forename, surname, mwsUser, csdUser, 
            email, prefEmail, permAddress, termAddress, phone, termPhone, 
            advisor, degreeCode, yearStudy, admitYear FROM student WHERE
            studentNo = '$studentNo'";

        $result = mysqli_query($db_con, $query); 

        if (mysqli_num_rows($result) > 0) {
            $data['personalInfo'] = mysqli_fetch_assoc($result);               
        } else {
            $data['personalInfo'] = "FALSE";
        }
        return $data['personalInfo'];
        mysqli_free_result($result);
    }
    
    function getModuleInfo($studentNo, $db_con) {
        $data['moduleInfo'] = array();
        $query = "SELECT Module.* FROM Module 
            JOIN Registration ON Module.moduleCode = Registration.moduleCode 
                where Registration.studentNo = '$studentNo' 
                AND Registration.status = 1";

        $result = mysqli_query($db_con, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                array_push($data['moduleInfo'], $row);
                // $data['moduleInfo'] = $row;  
            }
        } else {
            $data['moduleInfo'] = "FALSE";
        }
        return $data['moduleInfo'];
        mysqli_free_result($result);
    }
    
    function getTimetable($studentNo, $data, $db_con) {
        //check current date so timetable only loads for current week
        $data['timetable'] = array();
        $moduleCodes = array_column($data['moduleInfo'], 'moduleCode');

        $i = 0;
        $moduleCodeQuery = "";
        foreach ($moduleCodes as $value) {
            $moduleCodeQuery = $moduleCodeQuery.'moduleCode = \''.$value.'\'';
            $i++;
            if ($i < count($moduleCodes)) {
                $moduleCodeQuery = $moduleCodeQuery.' OR ';
            }
        }
        $query = "SELECT * FROM session WHERE ".$moduleCodeQuery;
        $result = mysqli_query($db_con, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                array_push($data['timetable'], $row);
            } 
        } else {
            $data['timetable'] = "FALSE";
        }
        
        // array_push($data['timetable'], $moduleCodes);
        return $data['timetable'];
        mysqli_free_result($result);
    }

    function getAttendance($studentNo, $data, $db_con) {
        //SQL query needs to be fixed 
        $data['attendance'] = array();
        $sessionIds = array_column($data['timetable'], 'sessionId');
        // echo "<br>------------------------------------------------------------------------------------------------------------------------------<br>";
        // print_r($sessionIds);
        $i = 0;
        $sessionIdQuery = "";
        foreach ($sessionIds as $value) {
            $sessionIdQuery = $sessionIdQuery.'sessionId = '.$value;
            $i++;
            if ($i < count($sessionIds)) {
                $sessionIdQuery = $sessionIdQuery.' OR ';
            }
        }
        $query = "SELECT sessionId, status FROM attendance WHERE studentNo = '$studentNo' AND(".$sessionIdQuery.")";
        $result = mysqli_query($db_con, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                array_push($data['attendance'], $row);
            } 
        } else {
            $data['attendance'] = "FALSE";
        }
        // array_push($data['attendance'], $moduleCodes);
        return $data['attendance'];
        mysqli_free_result($result);
    }

    function getMeetingNotes($studentNo, $db_con) {
        $data['meetingNotes'] = array();

        $query = "SELECT staffNo, content, dateTime FROM meetingnote WHERE studentNo = '$studentNo'";
        $result = mysqli_query($db_con, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                array_push($data['meetingNotes'], $row);
            } 
        } else {
            $data['meetingNotes'] = "FALSE";
        }
        print_r($data['meetingNotes']);
        return $data['meetingNotes'];
        mysqli_free_result($result);
    }

?>