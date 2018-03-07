$(document).ready(function () {
    generateAutoLetters();
});

function generateAutoLetters() {
    console.log("letters");
    var dataToSend = {
        requestType: 'retrieve'
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/public_html/php/generate_auto_letters.php',
        data: dataToSend,
        dataType: "json",
        success: function (data) {
            console.log("AUTO LETTER DATA:")
            console.log(data);
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });
}
