<?php
    //ADD PREPARED STATEMENTS
    //NORMALISE RECIPIENTS IF NOT SEPARATED BY COMMA, REMOVE SPACES
    //MAKE SURE DATA IS ESCAPED
    use PHPMailer\PHPMailer\PHPMailer;

    // require_once ('../php/db_config.php');
    require_once ('../php/PHPMailer/src/Exception.php');
    require_once ('../php/PHPMailer/src/PHPMailer.php');
    require_once ('../php/PHPMailer/src/SMTP.php');
    // $recipients = $_POST['recipients'];
    // $subject = $_POST['subject'];
    // $body = $_POST['body'];

    $mail = new PHPMailer ();
    try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'in-v3.mailjet.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '62b3bfd014779a5665ffe7a461c42309';                 // SMTP username
    $mail->Password = '81983d8961fbdc66c71699173d561563';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('dannyc179@gmail.com', 'UoL Admin');
    $mail->addAddress('danfgbrfbfgbtrbrtbvrtvbt440000000nycox1996@gmail.com');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
    
?>