<?php
    //ADD PREPARED STATEMENTS
    //NORMALISE RECIPIENTS IF NOT SEPARATED BY COMMA, REMOVE SPACES
    //MAKE SURE DATA IS ESCAPED
    use PHPMailer\PHPMailer\PHPMailer;
    require_once ('../php/db_config.php');
    require_once ('../php/PHPMailer/src/Exception.php');
    require_once ('../php/PHPMailer/src/PHPMailer.php');
    require_once ('../php/PHPMailer/src/SMTP.php');
    //UNCOMMENT    
    $recipients = $_POST['recipients'];
    if(isset($_POST['subject'])) { 
        $subject = $_POST['subject'];
    } else {
        $subject = "";
    }
    if(isset($_POST['body'])) { 
        $body = $_POST['body'];   
    } else {
        $body = "";
    }
 
    $data = Array();
    $senderDetails = getSenderDetails($db_con);
    $senderName = $senderDetails['name'];
    $senderEmail = $senderDetails['email'];

    sendEmail($senderEmail, $senderName, $recipients, $subject, $body); 
    
    $date = date('Y-m-d H:i:s');
    if (is_array($recipients)) {
        foreach ($recipients as $emailAddress) {
            addCommDatabase($db_con, $recipients, $date, $senderEmail, $subject, $body);
        }
    } else {
        addCommDatabase($db_con, $recipients, $date, $senderEmail, $subject, $body);
    }

    
    echo json_encode($data);
    mysqli_close($db_con);
    exit(); 

    function getSenderDetails($db_con) {
        $accNo = $_SESSION['accNo'];
        $userType = $_SESSION['userType'];
        if ($userType == 'OA') {
            $sender['name'] = 'Student Office';
            $sender['email'] = 'studentoffice@liverpool.ac.uk';
        } else {
            if ($userType == 'S') {
                $query = "SELECT forename, surname, email from student where studentNo = $accNo";
            } else if ($userType == 'SA' || $userType == 'L') {
                $query = "SELECT forename, surname, email from staff where staffNo = $accNo";
            } 

            $result = mysqli_query($db_con, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);

                $sender['name'] = $row['forename'] . $row['surname'];
                $sender['email'] = $row['email'];
            } else {
                //couldn't find mwsUser in DB
                $data['valid'] = 'false';
                $data['message'] = 'Error getting email';
                echo json_encode($data);
                mysqli_close($db_con);
                exit();  
            }
        // Free and close query+connection
        mysqli_free_result($result);
        }
        return $sender;
    }

    function sendEmail($senderEmail, $senderName, $recipients, $subject, $body) {
        $mail = new PHPMailer ();

        try {
            //Server settings
            // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail1.liv.ac.uk';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'sgdcox';                 // SMTP username
            $mail->Password = 'duckyshine';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            $mail->setFrom($senderEmail, $senderName);
            $mail->addReplyTo($senderEmail);
            if (is_array($recipients)) {
                foreach ($recipients as $emailAddress) {
                    $mail->addAddress($emailAddress);
                }
            } else {
                $mail->addAddress($recipients);
            }
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            $mail->Subject = $subject;
            $mail->Body = $body;
        
            $mail->send();

        } catch (Exception $e) {
            $data['valid'] = 'false';
            $data['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    function addCommDatabase($db_con, $recip, $date, $senderEmail, $subject, $body) {
        $commHistId = 0;
        $read = 0;
        $confidential = 1;
        // echo('commhisid: '. $commHistId .'<br>');
        // echo('recip: '. $recip .'<br>');
        // echo('senderEmail: '. $senderEmail .'<br>');
        // echo('subject: '. $subject .'<br>');
        // echo('body: '. $body .'<br>');
        // echo('read: '. $read .'<br>');
        // echo('confidential: '. $confidential .'<br>');
        // echo('date: '. $date .'<br>');


        $stmt = $db_con->prepare("INSERT INTO commhistory VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("issssiis", $commHistId, $recip, $senderEmail, $subject, $body, $read, $confidential, $date);
        $stmt->execute();
        //commHistId recipient sender subject body read confidential dateTime
        //i = int, s=string
    }
?>