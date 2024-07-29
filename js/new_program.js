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