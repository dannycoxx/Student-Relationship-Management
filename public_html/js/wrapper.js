var query;
var navOpen = false;
var currentPage;

$(document).ready(function () {
    if (authenticateLogIn()) {
        console.log(authenticateLogIn());
        $("#main").load("homepage.html");
        currentPage = 'homepage';
        initialiseNavDrawer();
    } else {
        if (currentPage != 'index') {
            window.location.replace("index.html");
        }
    }
});

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function toggleNav(nav) {
    if (navOpen == false) {
        nav.classList.toggle("change");
        $(navDrawer).animate({
            width: '280px'
        }, 40);
        $(main).animate({
            margin: '0 0 0 280px'
        }, 400);
        navOpen = true;
    } else {
        nav.classList.toggle("change");
        $(navDrawer).animate({
            width: '0',
        }, 40);
        $(main).animate({
            margin: '0 0 0 0'
        }, 400);
        navOpen = false;
    }
}
function authenticateLogIn() {
    var authenticated;
    var dataToSend = {
        action: 'logIn',
    }
    
    $.ajax({
        async: false,
        type: 'POST',
        url: 'http://localhost/public_html/php/authenticate_user.php',
        data: dataToSend,
        dataType: "json",
        success: function (data) {
            if (data['logIn'] == true) {
                // console.log("Data[logIn] = true");
                authenticated = true;
            } else if (data['logIn'] == false) {
                // console.log("Data[logIn] = false");
                authenticated = false;
            }
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });
    return authenticated;
}
function setCurrentPage(page) {
    currentPage = page;
}
function loadContent(page) {
    setCurrentPage(page);
    $("#main").load(page + ".html"); 
}
function getCurrentPage() {
    return currentPage.trim();
}
function loadExternal(page) {
    window.open(page);
}

function getHelp(page) {
    alert("Help for "+getCurrentPage()+".html");
}

function logOut() {
    $.ajax({
        type: 'POST',
        url: 'http://localhost/public_html/php/log_out.php',
        // data: dataToSend,
        dataType: "json",
        success: function (data) {
            // console.log("RECEIVING:");
            // console.log(data);
            window.location.replace("index.html");
            //or just redirect to log_out.html
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
            window.location.replace("index.html");
        }
    });
}

function initialiseNavDrawer() {
    $.ajax({
        type: 'POST',
        url: 'http://localhost/public_html/php/start_data.php',
        // data: dataToSend,
        dataType: "json",
        success: function (data) {
            document.getElementById('mwsUsername').innerHTML = data['mwsUser'];
            var userType = data['userType'];
            switch (userType) {
                //On login if student, load student page by default
                case 'OA': 
                    $("#dynamicDivContent").append(
                        `<div class="navCategory" onclick="loadContent('upload_spreadsheet')"> <h3>Upload Marks</h3> </div>
                        <div class="navCategory" onclick="loadContent('manage_requests')"> <h3>Manage Access Requests</h3> </div>
                        <div class="options"> 
                            <div class="navCategory" onclick="loadContent('manage_auto_letters')"> <h3>Manage Auto Letters</h3> </div>
                            <div class="navOption" onclick="loadContent('generate_auto_letters')"> <h4>Generate Automatic Letters</h4> </div>
                            <div class="navOption" onclick="loadContent('edit_auto_letters')"> <h4>Edit Auto Letter Templates</h4> </div>
                        </div>`
                    );
                break;

                case 'SA': 
                    $("#dynamicDivContent").append(
                        `<div class="navCategory" onclick="loadContent('upload_spreadsheet')"> <h3>Upload Marks</h3> </div>
                        <div class="navCategory" onclick="loadContent('manage_requests')"> <h3>Manage Access Requests</h3> </div>
                        <div class="navCategory" onclick="loadContent('manage_auto_letters')"> <h3>Manage Auto Letters</h3> </div>
                        <div class="navOption"> <h4>Run Auto Letter Scripts</h4> </div>
                        <div class="navCategory" onclick="loadContent('edit_auto_letters')"> <h3>Edit Auto Letters</h3> </div>`
                    );
                break;

                case 'L': 
                    $("#dynamicDivContent").append(
                        `<div class="navCategory" onclick="loadContent('upload_spreadsheet')"> <h3>Upload Marks</h3> </div>`
                    );
                break;

                case 'S':
                    // $("#parent").append(
                    //     `<div class="navCategory" onclick="loadContent('upload_spreadsheet')"> <h3>Upload Marks</h3> </div>`
                    // );
                    break;

                default:
                    console.log('Unable to determine account type');
                    
            }
            
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });

    // document.getElementById('mwsUsername').innerHTML = $data['mwsUser'];
}