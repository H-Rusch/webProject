var timeout = null;
var search = "";
var userID = "";
var token = "";

$(document).ready(function() {
    userID = $("#userID").val();
    token = $("#token").val();

    $("#search-guide").keyup(function() {
        /* Only search for guides if the currens search is different from the last search. 
        This prevents reloading when the user just presses 'shift' or something similar. */
        var searchInput = $("#search-guide").val();
        if (searchInput !== search) {
            search = searchInput;

            // empty the search to remove flickering
            $("#guides").empty();
            if (timeout != null) {
                clearTimeout(timeout);
            }
            timeout = setTimeout(searchFunction, 300);
        }        
    });

    $(".confirm-delete").click(function() {
        return confirmDelete();
    });
});

function searchFunction() {
    timeout = null;

    loadGuides();
}

function loadGuides() {
    search = $("#search-guide").val();
    // send ajax request which loads all guides by this user for the given search.
    $.ajax({
        url: "./ajax/get-guides-from-db.php", 
        type: "get",
        dataType: "json",
        data: {
            search: search,
            userID: userID
        }
    })
    .done(function(data) {
        // if guides are found, append their links to the list, but if none are found, show an error
        if (data.length === 0) {
            $("#guides").append(
                "<p class='error-text'>Es sind keine weiteren Guides verfügbar.</p>"
            );
            
        } else {
            $.each(data, function() {  
                // prevent elements from being listed twice very rarely
                if ($("#" + this.guideID).length === 0) {
                    createEntry(this);
                }
            });
        }
    })
}

// create an entry as the html representation
function createEntry(data) {
    entry = document.createElement("a");
    entry.id = data.guideID;
    entry.setAttribute("href", "./guide.php?id=" + data.guideID);
    entry.classList.add("guide-overview-entry");
    entry.classList.add(data.category + "-icon");
    entry.innerHTML = data.trackName + ", " + data.title;
    $("#guides").append(entry);

    deleteButton = document.createElement("a");
    deleteButton.setAttribute("href", "./logic/delete-guide.php?guideID=" + data.guideID + "&token=" + token + "&pretty");
    deleteButton.classList.add("button-basic");
    deleteButton.classList.add("link-button");
    deleteButton.classList.add("user-page-button");
    deleteButton.classList.add("confirm-delete");
    deleteButton.innerHTML = "Löschen";
    deleteButton.onclick = function() {
        return confirmDelete()
    };
    $("#guides").append(deleteButton);

    editButton = document.createElement("a");
    editButton.setAttribute("href", "./guide-create.php?guideID=" + data.guideID + "&pretty");
    editButton.classList.add("button-basic");
    editButton.classList.add("link-button");
    editButton.classList.add("user-page-button");
    editButton.innerHTML = "Bearbeiten";
    $("#guides").append(editButton);
}

function confirmDelete() {
    return confirm("Ein gelöschter Guide kann nicht wiederhergestellt werden.\nSoll der Guide wirklich gelöscht werden?");
}