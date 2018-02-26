<?php
    include ('../php/db_config.php');

    $requestType = $_POST['requestType'];
    if ($requestType != 'retrieve') {
        $requestId = $_POST['requestId'];
        $updatedStatus = $_POST['updatedStatus'];
    }

    $requesterUserType = $_SESSION['userType'];
    $requesterAccNo = $_SESSION['accNo'];

    // debug only
    // $studentNo = 1;
    // $requesterUserType = 'L';
    // $requesterAccNo = 1;
 
    $data = array();
    if ($requestType == 'retrieve') {
        $query = "SELECT * FROM request where status = 0";
        $result = mysqli_query($db_con, $query);
    
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                if ($row['description'] == "") {
                    $row['description'] = 'No description provided';
                }
                array_push($data, $row);
            } 
        } else {
            $data = "FALSE";
        }
    } else if ($requestType == 'update') {
        $query = "UPDATE request SET status = '$updatedStatus' WHERE requestId = '$requestId'";
        if ($updatedStatus == 1) {
            $data['message'] = "Request approved";
        } else if ($updatedStatus == -1) {
            $data['message'] = "Request rejected";
        }
    }
    
    echo json_encode($data);
    mysqli_close($db_con);
    exit();
?>