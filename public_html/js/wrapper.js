var query;
var navOpen = false;
var currentPage;

$(document)
    .ready(function () {
        $("#main").load("homepage.html");
        getStartData();
});

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function toggleNav(nav) {
    if (navOpen == false) {
        nav.classList.toggle("change");
        $(navDrawer).animate({
            // padding: '10px 30px 10px 30px',
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
            // padding: '10px 0px 10px 0px'
        }, 40);
        $(main).animate({
            margin: '0 0 0 0'
        }, 400);
        navOpen = false;
    }
}

function loadContent(page) {
    currentPage = page;
    console.log("PAGE: ")
    console.log(currentPage);
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
        url: 'http://localhost/php/log_out.php',
        // data: dataToSend,
        dataType: "json",
        success: function (data) {
            console.log("RECEIVING:");
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

function getStartData() {
    $.ajax({
        type: 'POST',
        url: 'http://localhost/php/start_data.php',
        // data: dataToSend,
        dataType: "json",
        success: function (data) {
            console.log("RECEIVING:");
            console.log(data);
            document.getElementById('mwsUsername').innerHTML = data['mwsUser'];
        },
        error: function (msg) {
            console.log("ERROR:");
            console.log(msg);
        }
    });

    // document.getElementById('mwsUsername').innerHTML = $data['mwsUser'];
}

// function applyTheme()[

// ]

// function toggleNightMode() {
//     if (nightMode == false) {
//         var filename = "defaultDark.css";
//         nightMode = true;
//     } else if (nightMode == true) {
//         var filename = "defaultLight.css";
//         nightMode = false;
//     }
// }

