function sendEmail() {
    var recipients = document.getElementById('emailRecipients').value;
    var subject = document.getElementById('emailSubject').value;
    var body = document.getElementById('emailBody').value;
    
    var dataToSend = {
        recipients: recipients,
        subject: subject, 
        body: body
    }
    console.log(dataToSend);
    $.ajax({
        type: 'POST',
        url: 'http://localhost/public_html/php/send_email.php',
        data: dataToSend,
        dataType: "json",
        success: function (data) {
            console.log("EMAIL DATA:")
            console.log(data);
            document.getElementById('emailRecipients').value = "";
            document.getElementById('emailSubject').value = "";
            document.getElementById('emailBody').value = "";
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });
}