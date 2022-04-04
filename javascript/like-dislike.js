$(document).ready(function () {
    let guideID = $("#guideID").val();
    let userID = $("#userID").val();
    let token = $("#token").val();
    rebuildLikeDislike();

    // when the like button is clicked, like the guide. But if the user is not logged in, 
    // print a hint which tells him to log in
    $("#like-button").on('click', function () {
        if (userID === "") {
            addLoginHint();
        } else {
            $.ajax({
                url: "./ajax/like-dislike-return.php",
                type: "post",
                dataType: "json",
                data: {
                    "like": 1,
                    "guideID": guideID,
                    "userID": userID,
                    "token": token
                }
            })
            .done(function(data) {
                $("#like-count").text(data.likes);
                $("#dislike-count").text(data.dislikes);
            })
            .fail(function(jqXHR) {
                addErrorHintLike(jqXHR.responseText);
            })
        }
    });

    // when the dislike button is clicked, dislike the guide. But if the user is not logged in, 
    // print a hint which tells him to log in
    $("#dislike-button").on('click', function () {
        if (userID === "") {
            addLoginHint();
        } else {
            $.ajax({
                url: "./ajax/like-dislike-return.php",
                type: "post",
                dataType: "json",
                data: {
                    "dislike": 1,
                    "guideID": guideID,
                    "userID": userID,
                    "token": token
                }
            })
            .done(function(data) {
                $("#like-count").text(data.likes);
                $("#dislike-count").text(data.dislikes);
            })
            .fail(function(jqXHR) {
                addErrorHintLike(jqXHR.responseText);
            })
        }
    });
    
});

function addLoginHint() {
    if ($("#like-dislike-container #like-dislike-login-hint").length === 0) {
        loginHint = document.createElement("p");
        loginHint.id = "like-dislike-login-hint";
        loginHint.classList.add("error-text");
        loginHint.innerHTML = "Um den Guide zu bewerten, musst Du dich einloggen.";
        $("#like-dislike-container").append(loginHint);
    }
}

function addErrorHintLike(hintText) {
    if ($("#like-dislike-container #error-hint").length === 0) {
        errorHint = document.createElement("p");
        errorHint.id = "error-hint";
        errorHint.classList.add("error-text");
        errorHint.innerHTML = hintText;
        $("#like-dislike-container").append(errorHint);
    }
}

function rebuildLikeDislike() {
    // rebuild the like and dislike elements to work with javascript. Many nodes needed for desired layout .-.
    likeCount = $("#like-count").text();
    dislikeCount = $("#dislike-count").text();

    $("#like-dislike-container").empty();

    likeButton = document.createElement("button");
    likeButton.id = "like-button";
    likeButton.classList.add("rating-button");
    likeButton.classList.add("like-button");
    likeButton.innerHTML = "Gefällt mir";

    likeCountElement = document.createElement("p");
    likeCountElement.id = "like-count";
    likeCountElement.innerHTML = likeCount;

    likeContainer = document.createElement("div");
    likeContainer.classList.add("like-dislike-element");
    likeContainer.appendChild(likeButton);
    likeContainer.appendChild(likeCountElement);

    dislikeButton = document.createElement("button");
    dislikeButton.id = "dislike-button";
    dislikeButton.classList.add("rating-button");
    dislikeButton.classList.add("dislike-button");
    dislikeButton.innerHTML = "Gefällt <br> mir nicht";

    dislikeCountElement = document.createElement("p");
    dislikeCountElement.id = "dislike-count";
    dislikeCountElement.innerHTML = dislikeCount;

    dislikeContainer = document.createElement("div");
    dislikeContainer.classList.add("like-dislike-element");
    dislikeContainer.appendChild(dislikeButton);
    dislikeContainer.appendChild(dislikeCountElement);

    likeDislikeInternal = document.createElement("div");
    likeDislikeInternal.classList.add("like-dislike-element-internal");
    likeDislikeInternal.appendChild(likeContainer);
    likeDislikeInternal.appendChild(dislikeContainer);

    $("#like-dislike-container").append(likeDislikeInternal);
}
