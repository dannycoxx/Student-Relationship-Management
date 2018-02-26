$(document).ready(function () {
        loadRequests();
    });

function loadRequests() {
    var dataToSend = {
        requestType: 'retrieve'
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/public_html/php/requests.php',
        data: dataToSend,
        dataType: "json",
        success: function (data) {
            console.log("REQUEST DATA:")
            console.log(data);
            insertRequests(data);
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });
}

function insertRequests(data) {
    $("#requests").append(`
        <div class="studentInfoInner"> 
            <h3>Active Requests</h3>
            <hr> 
        </div>
    `);
    for (var i=0; i<data.length; i++) {
        $("#requests").append(`
        <div class="request">
             <div class="requestContent">
                <h3>`+data[i]['title']+`</h3>
                <p>`+data[i]['requester']+`</p>
                <p>`+data[i]['description']+`</p>
             </div>
             <div class="requestButtons">
                // action dropdown menu with accept/reject etc. buttons to confirm actions
             </div>
        </div>
        `);
    }
    
}