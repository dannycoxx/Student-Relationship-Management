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
        // $data['personalInfo'] = getMarks($studentMws, $db_con);
        // $data['personalInfo'] = getAttendance($studentMws, $db_con);
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
        $data['timetable'] = array();
        $moduleCodes = array_column($data['moduleInfo'], 'moduleCode');

        //get modules student registered on \/
        //get sessions for module \
        //create table with session data
        //Table contains all lots of session dada

        $i = 0;
        $moduleCodeQuery = "";
        foreach ($moduleCodes as $value) {
            $moduleCodeQuery = $moduleCodeQuery.'\''.$value.'\'';
            $i++;
            if ($i < count($moduleCodes)) {
                $moduleCodeQuery = $moduleCodeQuery.' OR ';
            }
        }
        $query = "SELECT * FROM session WHERE moduleCode = ".$moduleCodeQuery;
        $result = mysqli_query($db_con, $query);
        
        // $query = "SELECT * FROM session";

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                array_push($data['timetable'], $row);
            } 
        } else {
            $data['timetable'] = "FALSE";
        }
        
        array_push($data['timetable'], $moduleCodes);
        return $data['timetable'];
        mysqli_free_result($result);
    }
    /*
    function getAttendance($studentNo, $db_con) {
        $query = "SELECT * FROM student WHERE
            studentNo = '$studentNo'";

        if (mysqli_num_rows($result) > 0) {
            $result = mysqli_query($db_con, $query); 
            $data['timetable'] = $result;   
        } else {
            $data['timetable'] = "FALSE";
        }
        mysqli_free_result($result);
    }
/*
    function getMeetingNotes() {
        $studentData['meetingNotes'] = $result;
        mysqli_free_result($result);
    }
    function getMarks() {
        //get modules student registered on
        //get assessments for modules
        //get marks for assessment
        //populate table for modules & assessments
        //populate marks
        $studentData['marks'] = $result;
        mysqli_free_result($result);
    }
    function getAttendance() {
        //get modules student registered on
        //get sessions for module
        //create table with session data
        //get attendance for sessions
        $studentData['attendance'] = $result;
        mysqli_free_result($result);
    }
    function getModules() {
        //use modules from other methods?
        $studentData['modules'] = $result;
        mysqli_free_result($result);
    }
*/

?>