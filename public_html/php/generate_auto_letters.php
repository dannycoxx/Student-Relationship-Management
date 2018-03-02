<?php
    include ('../php/db_config.php');

   
    
    echo json_encode($data);
    mysqli_close($db_con);
    exit();
?>