function login() {
    document.getElementById("username").style.borderColor = "#1e1e1e";
    document.getElementById("usernameError").innerHTML = "";
    document.getElementById("password").style.borderColor = "#1e1e1e";
    document.getElementById("passwordError").innerHTML = "";

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    if (username && password) {

        var dataToSend = {
            username: username,
            password: password
        }
        // console.log(dataToSend);
        // console.log("SENDING: ");
        // console.log(username);
        // console.log(password);
    
            $.ajax({
                type: 'POST',
                url : 'http://localhost/public_html/php/login.php',
                data: dataToSend,
                dataType : "json",
                success: function (data) {
                    // console.log("RECEIVING:");
                    // console.log(data);
                    if (data['login'] == 'true') {
                        loginSuccess();
                    } else {
                        if (data['failType'] == "username") {
                            usernameError(data['message']);
                        } else if (data['failType'] == "password") {
                            passwordError(data['message']);
                        }
                        //add data['message'] to index page
                    }
                    // alert("SUCCESS");
                },
                error : function (msg) {
                    console.log("ERROR:");
                    console.log(msg);
                }
            });
    } else {
        if (!username) {
            usernameError("Please enter username");
        }
        if (!password) {
            passwordError("Please enter password");
        }
    }
}

function usernameError(fail) {
    console.log(fail);
    document.getElementById("username").style.borderColor = "red";
    document.getElementById("usernameError").innerHTML = fail;
    
}
function passwordError(fail) {
    console.log(fail);
    document.getElementById("password").style.borderColor = "red";
    document.getElementById("passwordError").innerHTML = fail;
}

function loginSuccess() {
    window.location.replace("home.html");
    // document.getElementById('mwsUser').value = mwsUser;
}