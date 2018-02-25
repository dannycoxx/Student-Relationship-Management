<?php
    include ('../php/db_config.php');
    
    $studentNo = $_POST['studentNo'];
    $requesterUserType = $_SESSION['userType'];
    $requesterAccNo = $_SESSION['accNo'];
    if ($studentNo == "") {
        $studentNo = $requesterAccNo;
    }
    // debug only
    // $studentNo = 1;
    // $requesterUserType = 'L';
    // $requesterAccNo = 1;
 
    $data = array();
    $moduleCodes = array();
    $data['requesterUserType'] = $requesterUserType;
    //Student is accessing their own information
    if ($requesterUserType == "S") {
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
        $data['moduleInfo'] = getModules($studentNo, $db_con);
        //lecturer requesting information
    } else if ($requesterUserType == "L") {
        //check if lecturer has access rights
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
        $data['moduleInfo'] = getModules($studentNo, $db_con);
        $data['timetable'] = getTimetable($studentNo, $data, $db_con);
        $data['attendance'] = getAttendance($studentNo, $data, $db_con);
        $data['meetingNotes'] = getMeetingNotes($studentNo, $db_con);
        // $data['personalInfo'] = getMarks($studentMws, $db_con);
        //Office Admin requesting information
    } else if ($requesterUserType == "OA") {
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
        $data['moduleInfo'] = getModules($studentNo, $db_con);

        //System Admin requesting information
    } else if ($requesterUserType == "SA") {
        $data['personalInfo'] = getPersonalInformation($studentNo, $db_con);
    } else {
        
    }
    echo json_encode($data);
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
    
    function getModules($studentNo, $db_con) {
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
        $data['attendance'] = array();
        $sessionIds = array_column($data['timetable'], 'sessionId');
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
        return $data['meetingNotes'];
        mysqli_free_result($result);
    }
    /*
    function getMarks() {
        //get modules student registered on
        //get assessments for modules
        //get marks for assessment
        //populate table for modules & assessments
        //populate marks
        $studentData['marks'] = $result;
        mysqli_free_result($result);
    }
*/

?>