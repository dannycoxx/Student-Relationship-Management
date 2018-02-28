var changeArray = [];
var j = 0;
$(document).ready(function () {
    loadAutoLetters();
});

function loadAutoLetters() {
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

// function insertAutoLetters(data) {
//     //Load recent 10 sent auto letters too

//     /*
//         Removed from dropdown box, make into buttons
//         <option value="`+data[i]['requester']+`">Email Requester</option>
//         <option value="`+data[i]['student']+`">Email Student</option>
//     */
//     $("#requests").append(`
//         <div class="studentInfoInner"> 
//             <h3>Manage Pending Automatic Letters</h3>
//             <hr> 
//         </div>
//     `);
//     for (var i = 0; i < data.length; i++) {
//         $("#requests").append(`
//         <div class="request">
//              <div class="requestContent">
//                 <h3 class="requestTitle">` + data[i]['title'] + `</h3>
//                 <select class="requestAction" onChange="updateChangeArray(` + data[i]['requestId'] + `, this.value)">
//                     <option value="none">No Action</option>
//                     <option value="accept">Accept Request</option>
//                     <option value="reject">Reject Request</option>
//                 </select>
//                 <p title="Date and time of request creation">` + data[i]['dateTime'] + `</p>
//                 <hr>
//                 <p title="Email address of staff requesting access.">Requester: ` + data[i]['requester'] + `</p>
//                 <p title="Email address of student request is concerned with.">Student: ` + data[i]['student'] + `</p>
//                 <p>` + data[i]['description'] + `</p>
//              </div>
//              <div class="requestButtons">
//                 <!-- action dropdown menu with accept/reject etc. buttons to confirm actions -->
//              </div>
//         </div>
//         `);
//     }
//     $("#requests").append(`
//         <button type="button" id="requestConfirmButton" onclick="confirmChanges()">Confirm</button> 
            
//         `);
// }