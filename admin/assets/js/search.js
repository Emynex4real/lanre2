// SEARCH COURSES
$(document).ready(function () {
    var originalContent = $("#all-course-list").html();

    $("#courseInput").keyup(function () {
        let searchText = $(this).val();
        var url = "../config/search_courses.php";

        if (searchText != "") {
            $.ajax({
                url: url,
                method: "post",
                data: {
                    course: searchText,
                },
                success: function (response) {
                    $("#all-course-list").html(response);
                },
            });

        } else {
            $("#all-course-list").html(originalContent);
        }
    });
})



// SEARCH EVENTS
$(document).ready(function () {
    var originalEventContent = $("#all-event-list").html();

    $("#eventInput").keyup(function () {
        let searchEvent = $(this).val();
        var url = "../config/search_events.php";

        if (searchEvent != "") {
            $.ajax({
                url: url,
                method: "post",
                data: {
                    event: searchEvent,
                },
                success: function (response) {
                    $("#all-event-list").html(response);
                },
            });

        } else {
            $("#all-event-list").html(originalEventContent);
        }
    });
})



// SEARCH BLOGPOSTS
if ($("#postInput")) {
    $(document).ready(function () {
        var originalPostContent = $("#all-post-list").html();

        $("#postInput").keyup(function () {
            let searchPost = $(this).val();
            var url = "../config/search_posts.php";
            
            if (searchPost != "") {
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        post: searchPost,
                    },
                    success: function (response) {
                        $("#all-post-list").html(response);
                    },
                });
            } else {
                $("#all-post-list").html(originalPostContent);
            }
        });
    });
}



// COPY LINK && SHOW COPY TOOLTIP
var copy_buttons = document.getElementsByClassName("copy-post-link");

for (i = 0; copy_buttons.length > i; i++) {
    copy_buttons[i].addEventListener("click", function (e) {
        var copy = e.target.getAttribute('data-id');
        var copy_link = document.getElementById(copy);
        
        var copy_id = copy.substring(4);
        var copy_tooltip = document.querySelector(".tooltip" + copy_id);

        copy_link.select();
        copy_link.setSelectionRange(0,99999);
        navigator.clipboard.writeText(copy_link.value);

        copy_tooltip.style.display = "block";
        setTimeout(()=> {
            copy_tooltip.style.display = "none";
        }, 1000)
    })
}


var single_copy_button = document.getElementById("copy-button");

single_copy_button.addEventListener("click", () => {
    var copy = document.getElementById("copy-link");

    copy.select();
    copy.setSelectionRange(0,99999);
    navigator.clipboard.writeText(copy.value);
    (copy.value);

    var copy_tooltip = document.getElementById("tooltip");
    copy_tooltip.style.display = "block";
    setTimeout(()=> {
        copy_tooltip.style.display = "none";
    }, 1000)
})