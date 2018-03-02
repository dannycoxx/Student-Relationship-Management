var changeArray = [];
var j = 0;
$(document).ready(function () {
    loadAutoLetters();
});

function loadAutoLetters() {
    console.log("letters");
    var dataToSend = {
        requestType: 'retrieve'
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/public_html/php/manage_auto_letters.php',
        data: dataToSend,
        dataType: "json",
        success: function (data) {
            console.log("AUTO LETTER DATA:")
            console.log(data);
            insertAutoLetters(data);
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });
}

function insertAutoLetters(data) {
    //Load recent 10 sent auto letters too

    /*
        Removed from dropdown box, make into buttons
        <option value="`+data[i]['requester']+`">Email Requester</option>
        <option value="`+data[i]['student']+`">Email Student</option>
    */
    $("#letters").append(`
        <div> 
            <h2>Manage Pending Automatic Letters</h2>
            <hr> 
            <table class="autoLetterTable" id="autoLetterTable">
                <tr>
                    <th colspan="3">Student</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Queue</th>
                    <th>Edit</th>
                </tr>
            </table>
        </div>
        </div>
    `);
    for (var i = 0; i < data.length; i++) {
        var body = data[i]['body'];
        var bodySubstring = body.substring(0, 30);
        bodySubstring = bodySubstring + '...';
        
        $('#autoLetterTable').append(`
            <tr id="`+data[i]['commHistid']+`">
                <td>`+data[i]['studentNo']+`</td>
                <td>`+data[i]['forename']+`</td>
                <td>`+data[i]['surname']+`</td>
                <td>`+data[i]['subject']+`</td>
                <td>`+bodySubstring+`</td>
                <td><input type="checkbox" checked="checked"></td>
                <td><button type="button" class="editCommButton" onclick="">Edit Comm</button></td>
            </tr>
        `);
    }
}