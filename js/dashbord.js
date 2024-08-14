
function new_session() {    
    window.location.href = "new_session.html";
}
function new_program() {
    window.location.href = "new_program.php";
}
function search_user() {
    window.location.href = "search_user.html";
}
function showExercises(programId,programName) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/fetch_exercises_dashbord.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("exercise_details").innerHTML = xhr.responseText;
        }
    };
    xhr.send("program_id=" + encodeURIComponent(programId) + "&program_name=" + encodeURIComponent(programName));
}
$(document).ready(function() {
    $("#username").keyup(function() {
        let query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: "php/suggest_user.php",
                method: "GET",
                data: { term: query },
                success: function(data) {
                    let users = JSON.parse(data);
                    let suggestionBox = $("#suggestion-box");
                    suggestionBox.empty();
                    if (users.length > 0) {
                        users.forEach(function(user) {
                            suggestionBox.append("<div class='suggestion-item' data-username='" + user.username + "'>" + user.username + " (" + user.name + ")</div>");
                        });
                        suggestionBox.show();
                    } else {
                        suggestionBox.hide();
                    }
                }
            });
        } else {
            $("#suggestion-box").hide();
        }
    });

    $(document).on("click", ".suggestion-item", function() {
        $("#username").val($(this).data("username"));
        $("#suggestion-box").hide();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest("#username, #suggestion-box").length) {
            $("#suggestion-box").hide();
        }
    });
});