<?php
    require_once ('../php/db_config.php');
    // $action = $_POST['action'];
    // if ($action == 'accessPage') {
    //     $accessPage = $_POST['accessPage'];
    // }
    // if((isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != '')){
    //     $data['logIn'] = true;
    //     if ($action == 'accessPage') {

    //     }
    // } else {
    //     $data['logIn'] = false;
    // }
    $data[''] = $_SESSION;
    // $data['login'] = $_SESSION['logIn'];

    echo json_encode($_SESSION);
    
    exit();
?>