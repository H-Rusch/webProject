$(document).ready(function() {
    // check username input
    $("#username").on("keyup", function() {
        let username = $("#username").val();
        let regex = new RegExp("^([a-zA-Z0-9]{3,17})$");
        if (!regex.test(username)) {
            createErrorAfterElement("#username", "Der Nutzername muss aus 3 bis 16 Buchstaben oder Zahlen bestehen.");
            markErrors("#username");
        } else {
            removeErrorAfterElement("#username");
            markCorrect("#username");

            // send ajax request which checks if the name has been used before
            $.ajax({
                url: "./ajax/check-username-taken.php", 
                type: "get",
                data: {
                    name: username
                }
            })
            .done(function(data) {
                if (data) {
                    // response message gotten, that the username is already in use
                    createErrorAfterElement("#username", data);
                    markErrors("#username");
                } else {
                    // no response message gotten = username not in use
                    removeErrorAfterElement("#username");
                    markCorrect("#username");                    
                }
            })
        }
    });

    // check if passwords are equal
    $(":password").on("keyup", function() {
        let password1 = $("#new-password").val();
        let password2 = $("#confirm-new-password").val();

        if (password2.length !== 0) {
            if (password1 !== password2) {
                createErrorAfterElement("#confirm-new-password", "Die Passwörter müssen übereinstimmen.");
                markErrors(":password");
            } else {
                removeErrorAfterElement("#confirm-new-password");
                markCorrect(":password");
            }
        } 
    });

    //  checks email input
    $("#email").on("keyup", function() {
        // regex taken from https://stackoverflow.com/questions/2507030/email-validation-using-jquery
        let regex = new RegExp("^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$");
        if (!regex.test($("#email").val())) {
            createErrorAfterElement("#email", "Die E-Mail Adresse besitzt kein gültiges Format.");
            markErrors("#email");
        } else {
            removeErrorAfterElement("#email");
            markCorrect("#email");
        }
    });

    // only accept the submit, when all of the input fields are filled correctly
    $("form").submit(function() {
        let username_regex = new RegExp("^([a-zA-Z0-9]{3,17})$");
        let email_regex = new RegExp("^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$");

        return username_regex.test($("#username").val()) && email_regex.test($("#email").val()) &&
            $("#new-password").val().length > 0 && $("#new-password").val() === $("#confirm-new-password").val();

    });
});

// create a text hint what the error is after an element
function createErrorAfterElement(selector, errorMessage) {
    if (!$(selector).next().hasClass("error-text")) {
        $(selector).after('<p class="error-text">' + errorMessage + '</p>');
    }
}

// remove the text hint
function removeErrorAfterElement(selector) {
    if ($(selector).next().hasClass("error-text")) {
        $(selector).next().remove();
    }
}

// mark the input fields with incorrect values
function markErrors(selector) {
    $(selector).removeClass("correct-field");
    $(selector).addClass("error-field");
}

// mark en input field as correct
function markCorrect(selector) {
    if ($(selector).next().hasClass("error-text")) {
        $(selector).next().remove();
    }
    $(selector).removeClass("error-field");
    $(selector).addClass("correct-field");
}
