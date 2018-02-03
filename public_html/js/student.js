$(document).ready(function () {
    loadStudent(studentNo);
    generateTimetable(dataArray);
});

function loadStudent(studentNo) {
    $.ajax({
            type: 'POST',
            url : 'http://localhost/public_html/php/student_info.php',
            data: dataToSend,
            dataType : "json",
            success: function (data) {
                searchResultsTable(data);
            },
            error : function (msg) {
                console.log("ERROR:");
                console.log(msg);
            }
        });
}

function generateTimetable(dataArray){
    var rows = 6;           //days shown
    var columns = 10;       //times shown
    var cellCount = 0;
    var times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00']
    var days = ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri']
    var timetable = document.getElementById('timetable');
    
    for (var r = 0; r < rows; r++) {
        var tr = timetable.insertRow();
        for (var c = 0; c < columns; c++) {
            var cellId = "timetable"+cellCount;
            
            var td = tr.insertCell();
            td.setAttribute('id', cellId);
            if (cellCount<10 && cellCount>0) {
                //add index[i] from times
            } else if (cellCount%10 == 0) {
                //add index[i] from days
            }


            cellCount++;
        }
    }
}

function addData(data) {

}