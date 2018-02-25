$(document).ready(function () {  
    // var studentMWS = "sgdjones2"; 
    // loadStudent(studentNo);
});

function loadStudent(studentNo) {
    console.log("student.js loadStudent(): ");
    console.log(studentNo);
    var dataToSend = {
        studentNo : studentNo
    }
    $.ajax({
            type: 'POST',
            url : 'http://localhost/public_html/php/student_info.php',
            data: dataToSend,
            dataType : "json",
            success: function (data) {
                console.log("STUDENT INFO DATA:")
                console.log(data);
                if (data['requesterUserType'] == 'S') {
                } else if (data['requesterUserType'] == 'L') {
                    generatePersonalInfo(data['personalInfo']);
                    generateTimetable(data['timetable']);
                    generateModules(data['moduleInfo']);
                    generateAttendance(data['attendance']);
                    generateMeetingNotes(data['meetingNotes']);
                } else if (data['requesterUserType'] == 'OA') {
                    
                }else if (data['requesterUserType'] == 'SA') {
                    
                }

            },
            error : function (msg) {
                console.log("ERROR:");
                console.log(msg);
            }
        });
}
function generatePersonalInfo(data) {
    $("#studentInformation").append(`
        <div class="studentInfoInner"> 
            <h3>Non-Confidential Information</h3>
                <hr>
                <table>
                    <tr>
                        <td>Student Name:</td>
                        <td id='studentName'>`+ data['forename'] +`</td>
                    </tr>
                    <tr>
                        <td>MWS Username:</td>
                        <td id='mwsUsername'>`+ data['mwsUser'] +`</td>
                    </tr>
                    <tr>
                        <td>Term Contact Number:</td>
                        <td id='termContact'>`+ data['termPhone'] +`</td>
                    </tr>
                    <tr>
                        <td>Term Address:</td>
                        <td id='termAddress'>`+ data['termAddress'] +`</td>
                    </tr>
                    <tr>
                        <td>Email Address:</td>
                        <td id='emailAddress'>`+ data['email'] +`</td>
                    </tr>
                </table>
        </div>


    `);
}
function generateModules(data) {
    
}

function generateTimetable(data){
    $("#studentInformation").append(`
        <div class="studentInfoInner"> 
            <h3>Timetable</h3>
                <hr>
                <table class="timetable" id="timetable"></table>
        </div>
    `);
    var rows = 6;           //days shown
    var columns = 10;       //times shown
    var cellCount = 0;
    var times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
    var days = ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri'];
    var timetable = document.getElementById('timetable');
    var i = 0;
    var j = 0;
    var k = 0;
    
    for (var r = 0; r < rows; r++) {
        var tr = timetable.insertRow();
        for (var c = 0; c < columns; c++) {
            var cellId = "timetableCell"+cellCount;
            
            var td = tr.insertCell();
            td.setAttribute('id', cellId);
            if (cellCount<10 && cellCount>0) {
                td.innerHTML = times[i];
                i++;
                //add index[i] from times
            } 
            // console.log(cellCount%10);
            if (cellCount%10 == 0 && cellCount>0)  {
                //covert to day and compate with days[j]
                td.innerHTML = days[j];
                j++;
            }
            //if not first row or first column
            if (!(cellCount%10 == 0) && cellCount>9)  {
                // console.log(data);
                //convert time to hh:mm and compare to column 
                // var time = data[k]['time'].substring(0,5);
                // td.innerHTML = data[k]['moduleCode'];
                k++;
            }

            cellCount++;
        }
    }
}

function generateAttendance(data) {}

function generateMeetingNotes(data) {}