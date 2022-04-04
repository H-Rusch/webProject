let timeout = null;
let search = "";
let offset = 0;

$(document).ready(function() {
    // create the button used to load more guides
    $(".guide-overview").append("<button id='load-more'>Mehr laden</button>");
    $("#load-more").css("margin", "5% 5%")
    $("#load-more").on("click", function() {
        loadGuides(offset);
        offset++;
    });

    $(".guide-filter-overview").append("<div class='guide-filters'>")
    $(".guide-filters").append("<button class='button-basic category-button' id='lastEdit'>Aktualität</button>");
    $(".guide-filters").append("<button class='button-basic category-button' id='category'>Kategorie</button>");
    
    $("#lastEdit").on("click", function() {
        sortGuides(offset,"lastEdit");
        return false;
    });
    $("#category").on("click", function() {
        sortGuides(offset, "category");
        return false;
    });

    /* Show partial results when typing. Only fires after the user has stopped typing for a bit, to reduce the amount of requests sent.
    Source to delay function: https://stackoverflow.com/questions/1909441/how-to-delay-the-keyup-handler-until-the-user-stops-typing */ 
    $("#search-guide").keyup(function() {
        /* Only search for guides if the currens search is different from the last search. 
        This prevents reloading when the user just presses 'shift' or something similar. */
        const searchInput = $("#search-guide").val();
        if (searchInput !== search) {
            search = searchInput;

            // empty the search to remove flickering
            removeGuides();
            if (timeout != null) {
                clearTimeout(timeout);
            }
            timeout = setTimeout(searchFunction, 300);
        }        
    });

    // the initial guides are already loaded
    offset++;
});

function searchFunction() {
    timeout = null;

    offset = 0;
    loadGuides(offset);
    offset++;
}

function sortGuides(offset, filter) {
    var elements = document.getElementById("guides").children;
    for (var i = 0; i < elements.length; i++) {
        this.guides[i] = elements[i].id;
    }

    $.ajax({
        url: "./ajax/get-guides-from-db.php",
        type: "get",
        dataType: "json",
        data: {
            offset: offset,
            filter: filter,
            guides: JSON.stringify(this.guides),
        }
    })
    .done(function (data) {
        removeGuides();
        $.each(data, function() {
            // append the link to a guide in the guide list
            $("#guides").append(createEntry(this));

            $("#load-more").show();
        }
    );
})}

function loadGuides(offset) {
    var search = $("#search-guide").val();
    // send ajax request which gets the next x-guides. 
    // an offset is specified, so only new guides will be loaded
    $.ajax({
        url: "./ajax/get-guides-from-db.php", 
        type: "get",
        dataType: "json",
        data: {
            offset: offset,
            search: search
        }
    })
    .done(function(data) {
        // if guides are found, append their links to the list, but if none are found, show an error
        if (data.length === 0) {
            if ($("#guides").find("p").length === 0) {
                $("#guides").append(
                    "<p class='error-text'>Es sind keine weiteren Guides verfügbar.</p>"
                );
            }            
            $("#load-more").hide();
        } else {
            $("#load-more").show();
            $.each(data, function() {
                // prevent elements from being listed twice very rarely
                if ($("#" + this.guideID).length === 0) {
                    // append the link to a guide in the guide list
                    //$("#guides").append(createEntry(this));
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
}

function removeGuides() {
    $("#guides").empty();
    $("#load-more").hide();
}
