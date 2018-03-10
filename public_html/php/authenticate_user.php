<?php
    require_once ('../php/db_config.php');
    $action = $_POST['action'];
    if ($action == 'accessPage') {
        $accessPage = $_POST['accessPage'];
    }
    if(isset($_SESSION['logIn']) && $_SESSION['logIn'] == "true"){
        $data['logIn'] = true;
    } else {
        $data['logIn'] = false;        
    }
    // } else {
    //     $data['logIn'] = false;
    // }
    // $data[''] = $_SESSION;
    // $data['login'] = $_SESSION['logIn'];

    echo json_encode($data);
    
    exit();
?>