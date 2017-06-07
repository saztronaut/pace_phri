
function getMethods(input) { //This can be called when changing the device used to collect steps
    "use strict";
    var nudge = input.slice(-(input.length - 6));
    var editname = "editBtn" + nudge;
    if (document.getElementById(editname)) {
        if (document.getElementById(editname).value === "Edit") {
        document.getElementById("method_message").innerHTML = "If you want to update the device used to collect your step count, click 'Edit'";
        $("#methodModal").modal("show");
        }
    }
}

function selectMethods(control_name, pref_method, methods, show) {
    "use strict";
    // Creates the select method DDL
    //pref method is the chosen method for the ddl
    //methods is the method array
    //enable is the status for the control
    console.log(show);
    var print = "";
    if (show === false) {
        print += "<span id='" + control_name + "'>" + methods[pref_method] + "</span>";
    } else {
        print += "<select name='" + control_name + "' id='" + control_name + "' class='form-control' " + control_name + " >";
        for (i in methods) {
            if (i === pref_method) {
                print += "<option selected='selected' value='" + i + "'> " + methods[i] + " </option> ";
            } else {
                print += "<option value='" + i + "'> " + methods[i] + " </option> ";
            }
        }
        print += "</select>";
    }
    return print;
}