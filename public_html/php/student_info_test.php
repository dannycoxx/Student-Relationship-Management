<?php
    include ('../php/db_config.php');

        $query = "SELECT * FROM student WHERE
                mwsUser = 'sgosmith'";
        $result = mysqli_query($db_con, $query);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $data[] = $result;   
        } else {
            $data[] = "FALSE";
        }







            echo "Result:<br/>";  
            print_r($result);
            echo "<br/><br/>Data:<br/>";  
            print_r($data);
            echo "<br/><br/>Data:<br/>";  
            print_r($row);
            
    
    ////////////////////MOVE//////////////////////
    echo "<br/><br/>JSON:<br/>";
    echo json_encode($data);
    ////////////////////MOVE//////////////////////

?>