<?php
    include ('../php/db_config.php');

    $studentMws = $_POST['studentMWS'];
    $requesterUserType = $_SESSION['userType'];
    $requesterMws = $_SESSION['mwsUser'];
    if ($studentMws == "") {
        $studentMws = $requesterMws;
    }

    $data = array();
    //Student is accessing their own information
    if ($requesterUserType == "S") {
        getPersonalInformation($studentMws, $db_con);
        // getTimetable();
        // getMarks();
        // getAttendance();
    //lecturer requesting information
    } else if ($requesterUserType == "L") {
    
    //Office Admin requesting information
    } else if ($requesterUserType == "OA") {

    //System Admin requesting information
    } else if ($requesterUserType == "SA") {

    } else {

    }

    mysqli_close($db_con);

    echo json_encode($data);
    exit();


    function getPersonalInformation($studentMws, $db_con) {
        $query = "SELECT studentNo, forename, surname, mwsUser, csdUser, 
            email, prefEmail, permAddress, termAddress, phone, termPhone, 
            advisor, degreeCode, yearStudy, admitYear FROM student WHERE
            mwsUser = '$studentMws'";

            $result = mysqli_query($db_con, $query); 

        if (mysqli_num_rows($result) > 0) {
            $data['personalInfo'] = $result;   
            // $data['personalInfo'] = "result";   

        } else {
            $data['personalInfo'] = "FALSE";
        }

        mysqli_free_result($result);
    }



    /*
    function getTimetable() {
        //get modules student registered on
        //get sessions for module
        //create table with session data
        //Table contains all lots of session dada

        $query = "SELECT studentNo, forename, surname, mwsUser, csdUser, 
            email, prefEmail, permAddress, termAddress, phone, termPhone, 
            advisor, degreeCode, yearStudy, admitYear FROM student WHERE
            mwsUser = '$studentMws'";

        if (mysqli_num_rows($result) > 0) {
            $result = mysqli_query($db_con, $query); 
            $data['timetable'] = $result;   
        } else {
            $data['timetable'] = "FALSE";
        }
        mysqli_free_result($result);
    }
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