function uploadSpreadsheet(){
    var spreadsheetFile = document.getElementById("spreadsheetFile").files[0]; 
    var spreadsheetForm = new FormData();
    spreadsheetForm.append("file", spreadsheetFile);
    // console.log(spreadsheetForm);
    $.ajax({
        url: "http://localhost/public_html/php/marks.php",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        data: spreadsheetForm,                         
        type: 'post',
        success: function(data){
            console.log(data);
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });

}





// function uploadSpreadsheet() {
//     //CHECK FILETYPE IS .XLSX OR .xls
//     //USE SHEET.JS TO PARSE SPREADSHEET FILES
//     // https://abandon.ie/notebook/simple-file-uploads-using-jquery-ajax
//     var spreadsheet = document.getElementById("spreadsheetFile").files[0];
//     // console.log(spreadsheet);
//     // Create a formdata object and add the files
//     var data = new FormData();



//     $.each(spreadsheet, function(key, value)
//     {
//         data.append(key, value);
//     });

//     $.ajax({
//         url: 'http://localhost/public_html/php/marks.php',
//         type: 'POST',
//         data: data,
//         cache: false,
//         dataType: 'json',
//         processData: false, // Don't process the files
//         contentType: false, // Set content type to false as jQuery will tell the server its a query string request
//         success: function(data){
//             console.log(data);
//         },
//         error: function (msg) {
//             console.log("ERROR:");
//             console.log(msg);
//         }
//     });
// }
//     // $("#markWrapper").append(`
//     //     <div class="marks">
             
//     //     </div>
//     //     `);

