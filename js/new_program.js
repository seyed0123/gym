function toggleFormExer(index) {
    var form = document.getElementById("editFormExer" + index);
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}
function toggleFormProg(index) {
    var form = document.getElementById("editFormProg" + index);
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}
function toggleFormProgUser(index) {
    var form = document.getElementById("editFormProgUser" + index);
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}
function back(){
    window.location.href = "../index.php";
}
function set_exercise_id(exer_id){
    let exercise_id_program_exercise = document.getElementById('exercise_id_program_exercise')
    exercise_id_program_exercise.value = exer_id
    
}
function set_program_id(prog_id){
    let program_id_program_exercise = document.getElementById('program_id_program_exercise')
    let program_id_user_program = document.getElementById('program_id_user_program')
    let program_id_user_program_search = document.getElementById('program_id_user_program_search')
    let program_id_exercise_program_search = document.getElementById('program_id_exercise_program_search')
    program_id_exercise_program_search.value = prog_id
    program_id_user_program_search.value = prog_id
    program_id_user_program.value = prog_id
    program_id_program_exercise.value = prog_id
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

