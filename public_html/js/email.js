var recipientCheck;


function sendEmail() {
    var recipientsRaw = document.getElementById("emailRecipients").value.trim();
    var subject = document.getElementById("emailSubject").value.trim();
    var subject = subject.trim();
    var body = document.getElementById("emailBody").value.trim();
    var body = body.trim();

    // if recipients field contains a comma, separate
    
    console.log(" ")
    if (checkRecipients()) {
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
                //refresh page
            },
            error: function (msg) {
                console.log("ERROR:");
                console.log(msg);
            }
        });
    }
}

function checkRecipients () {
    var recipientsRaw = document.getElementById("emailRecipients").value.trim();
    // console.log(recipientsRaw);

    if (recipientsRaw != "") {
        if (/,/.test(recipientsRaw)) {
            var recipients = recipientsRaw.split(",");
            for (var i = 0; i < recipients.length; i++) {
                recipients[i] = recipients[i].trim();
                // console.log("TESTING: \'" + recipients[i] + "\' = " + /\S+@\S+\.\S+/.test(recipients[i]));
                if (/\S+@\S+\.\S+/.test(recipients[i]) == false) {
                    var recipientCheck = false;
                }
            }
            if (recipientCheck != false) {
                var recipientCheck = true;
            }
        } else if (/,/.test(recipientsRaw) == false){
            recipients = recipientsRaw.trim();
            if (/\S+@\S+\.\S+/.test(recipients) == false) {
                var recipientCheck = false;
                // console.log("Poorly formatted email: " + recipients[i]);
            } else {
                var recipientCheck = true;
            }
            // console.log(recipientCheck);
        }
    } else {
        var recipientCheck = false;
    }
    if (recipientCheck == false) {
        document.getElementById("emailRecipients").style.borderColor = "red";
    } else if (recipientCheck){
        document.getElementById("emailRecipients").style.borderColor = "#1e1e1e";
    }

    return recipientCheck;
}