function redirect(gothere) {
    "use strict";
  window.location.assign(gothere);
}

function doXHR(url, callback, data) {
    "use strict";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            if (typeof callback === "function") {
        // apply() sets the meaning of "this" in the callback
        console.log("callback " + xhr.responseText);
                callback.apply(xhr);
            }
        }
    };
  // send the request *after* the event handler is defined
    if (data !== 0) {
        xhr.send(data);
    } else {
        xhr.send();
    }
}

function getlogin() {
    "use strict";
    doXHR("./loggedon.php", function () {
        var response = this.responseText;
        console.log(response);
        var print = [];
        if (parseInt(response) === 0) {
            print.push("<li><a href='./register_form.php'>");
            print.push("<span class='glyphicon glyphicon-user'> </span> Sign Up </a></li>");
            print.push("<li><a href='./landing_text.php'>");
            print.push("<span class='glyphicon glyphicon-log-in'></span> Login </a></li>");
        } else {
            var userdata = JSON.parse(response);
            var role = userdata.role;
            var username = userdata.username;
            if (role === "R" || role === "S") {
            	var ape_user = userdata.ape_user;
            	console.log(ape_user);
                print.push("<li><a href='./admin.php'><span class='glyphicon glyphicon-pencil'></span> Admin </a></li>");
                if (ape_user !== "") {
                	print.push("<li><a href='#' onclick='quitApeUser()'><span class='glyphicon glyphicon-eye-open'></span> Viewing as " + ape_user + " </a></li>");
                } else {
                	print.push("<li><a href='#'><span class='glyphicon glyphicon-user'></span> Hi " + username + " </a></li>");	
                }               
            } else {
                print.push("<li><a href='#'><span class='glyphicon glyphicon-user'></span> Hi " + username + " </a></li>");
            }
            print.push("<li><a href='#' onclick='logout()'><span class='glyphicon glyphicon-log-in' id='logout'></span> Log out</a></li>");
        }
            var login = print.join("\n");
            document.getElementById("login_bar").innerHTML = login;
        });
}

function logout(){
   "use strict";
    doXHR("./logout.php", function(){
    window.location.assign("./landing_text.php");
    }, 0)
}

function quitApeUser(){
    "use strict";
    doXHR("./quitApeUser.php", function(){
        console.log(this.responseText);
        window.location.assign("./admin.php");
    }, 0)
}