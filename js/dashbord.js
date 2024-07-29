
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