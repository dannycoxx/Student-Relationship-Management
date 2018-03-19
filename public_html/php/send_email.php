<?php
    //ADD PREPARED STATEMENTS
    //NORMALISE RECIPIENTS IF NOT SEPARATED BY COMMA, REMOVE SPACES
    //MAKE SURE DATA IS ESCAPED
    use PHPMailer\PHPMailer\PHPMailer;
    require_once ('../php/db_config.php');
    require_once ('../php/PHPMailer/src/Exception.php');
    require_once ('../php/PHPMailer/src/PHPMailer.php');
    require_once ('../php/PHPMailer/src/SMTP.php');
    
    $recipients = $_POST['recipients'];
    if(isset($_POST['subject'])) { 
                $subject = $_POST['subject'];
                $subjectSet = true;
            } 
    if(isset($_POST['body'])) { 
        $body = $_POST['body'];   
        $bodySet = true;
    }
    $senderName = "Student Office";
    $senderEmail = "csstudy@liverpool.ac.uk";
    $data = Array();
    getSenderDetails();
    sendEmail($senderEmail, $senderName, $recipients, $subject, $body);    
    
    echo json_encode($data);
    mysqli_close($db_con);
    exit(); 

    function getSenderDetails() {
        

        $accNo = $_SESSION['accNo'];
        $userType = $_SESSION['userType'];
        if ($userType == 'OA') {
            $senderName = 'Student Office';
            $senderEmail = 'studentoffice@liverpool.ac.uk';
        } else {
            if ($userType == 'S') {
                $query = "SELECT forename, surname, email from student where studentNo = $accNo";
            } else if ($userType == 'SA' || $userType == 'L') {
                $query = "SELECT forename, surname, email from staff where staffNo = $accNo";
            } 

            $result = mysqli_query($db_con, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);

                $senderName = $row['forename'] + $row['surname'];
                $senderEmail = $row['email'];
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
            $mail->Body    = $body;
        
            $mail->send();
            
            // $data['valid'] = 'True';
            // $data['message'] = 'Email successfully sent';
        } catch (Exception $e) {
            $data['valid'] = 'false';
            $data['message'] = 'Message could not be sent. Mailer Error: ' + $mail->ErrorInfo;
        }
    }

    function addCommDatabase() {
        
    }
?>