<?php
    require_once ('../php/db_config.php');
    $studentMws = $_POST['studentMWS'];
    $requesterUserType = $_SESSION['userType'];
    $requesterMws = $_SESSION['mwsUser'];
    if ($studentMws == "") {
        $studentMws = $requesterMws;
    }
    
    
    $data = array();
    //Student is accessing their own information
    if ($requesterUserType == "S") {
        $data['personalInfo'] = getPersonalInformation($studentMws, $db_con);
        $studentNo = $data['personalInfo']['studentNo'];
        $data['moduleInfo'] = getModuleInfo($studentNo, $db_con);
        $data['timetable'] = getTimetable($studentNo, $db_con);
        // $data['personalInfo'] = getMarks($studentMws, $db_con);
        // $data['personalInfo'] = getAttendance($studentMws, $db_con);

        //lecturer requesting information
    } else if ($requesterUserType == "L") {
        
        //Office Admin requesting information
    } else if ($requesterUserType == "OA") {
        
        //System Admin requesting information
    } else if ($requesterUserType == "SA") {
        
    } else {
        
    }

    echo json_encode($data);
    mysqli_close($db_con);
    exit();
    
    function getPersonalInformation($studentMws, $db_con) {
        $query = "SELECT studentNo, forename, surname, mwsUser, csdUser, 
            email, prefEmail, permAddress, termAddress, phone, termPhone, 
            advisor, degreeCode, yearStudy, admitYear FROM student WHERE
            mwsUser = '$studentMws'";

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
        $query = $query = "SELECT Module.* from Module 
            JOIN Registration ON Module.moduleCode = Registration.moduleCode 
                where Registration.studentNo = '$studentNo' 
                AND Registration.status = 1";

        $result = mysqli_query($db_con, $query); 

        if (mysqli_num_rows($result) > 0) {
            $data['moduleInfo'] = mysqli_fetch_assoc($result);               
        } else {
            $data['moduleInfo'] = "FALSE";
        }
        return $data['moduleInfo'];
        mysqli_free_result($result);
    }
    
    function getTimetable($studentNo, $db_con) {
        //get modules student registered on
        //get sessions for module
        //create table with session data
        //Table contains all lots of session dada
        foreach ($data['moduleInfo']['moduleCode'] as $key => $value) {
            $moduleCodeQuery = $moduleCodeQuery.'moduleCode = '.$value.'\'OR';
        }
        $query = "SELECT * FROM student WHERE ".$moduleCodes;

        if (mysqli_num_rows($result) > 0) {
            $result = mysqli_query($db_con, $query); 
            $data['timetable'] = $result;   
        } else {
            $data['timetable'] = "FALSE";
        }
        mysqli_free_result($result);
    }
    function getAttendance($studentNo, $db_con) {
        $query = "SELECT * FROM student WHERE
            mwsUser = '$studentMws'";

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