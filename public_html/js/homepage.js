function sendSearch(textBox){
    if (searchTerm != "") {
        var searchTerm = textBox.value;
        console.log("Change: "+searchTerm);
        var dataToSend = {
            searchTerm: textBox.value
            // searchTerm : "DA"
        }
        // console.log(dataToSend);

        $.ajax({
            type: 'POST',
            url : 'http://localhost//public_htmlphp/search_student.php',
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
}

function searchResultsTable(studentData) {
    console.log("SEARCH RESULTS TABLE:");
    console.log(studentData);
    var table = "<table  class=\"studentResultTable\">";
    
    if (studentData == "FALSE") {
        
    } else {
        table += "<tr class=\"studentResultTableHead\">";
        for (var i = 0; i < studentData.length; i++) {
            if (i<1) {
                

            } else {
                table += "<tr onclick=\"getStudent(this.cells[0].innerHTML)\" class=\"studentResultTable\">";
            }
            
            for (var j = 0; j < studentData[i].length; j++) {            
                table += "<td>" + studentData[i][j] + "</td>";
            }
            table += "</tr>";
        }
    }
    document.getElementById('searchResults').innerHTML = table;
}

function getStudent(row) {
    console.log(row);
    $("#main").load("student.html");
    //call 
}































