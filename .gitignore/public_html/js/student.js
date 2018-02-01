$(document).ready(function () {
    loadStudent(studentNo);
    generateTimetable(dataArray);
});

function loadStudent(studentNo) {
    alert("SUCESS CALLING");
    var dataToSend = {
            studentNo: studentNo
        }

    $.ajax({
            type: 'POST',
            url : 'http://localhost/public_html/php/student_info.php',
            data: dataToSend,
            dataType : "json",
            success: function (data) {
                // console.log("RECEIVING:");
                // console.log(data);
                searchResultsTable(data);
            },
            error : function (msg) {
                console.log("ERROR:");
                console.log(msg);
            }
        });
}

function generateTimetable(dataArray){
    //set class to 
    cellCount = 0;
    for (var r = 0; r < rows; r++) {
        var tr = board.insertRow();
        for (var c = 0; c < columns; c++) {
            var td = tr.insertCell();
            td.setAttribute('id', cellCount);
            cellCount++;
        }
    }


}

function addData(data) {

}