function showUser() {
    var text_field = document.getElementById("name_field");
    var name = text_field.value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/fetch_user_search.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("user_details").innerHTML = xhr.responseText;
        }
    };
    xhr.send("name=" + encodeURIComponent(name));
}


function showEditForm(user) {
    var genderMaleChecked = user.gender ? "checked" : "";
    var genderFemaleChecked = !user.gender ? "checked" : "";

    var userDetails = `
        <form id="editForm">
            <input type="hidden" name="username" value="${user.username}">
            <label>Name: <input type="text" name="name" value="${user.name}"></label><br>
            <label>Address: <input type="text" name="address" value="${user.address}"></label><br>
            <label>Height: <input type="number" name="height" value="${user.heigth}"></label><br>
            <label>Weight: <input type="number" name="weight" value="${user.weigth}"></label><br>
            <label>Phone Number: <input type="text" name="phone_number" value="${user.phone_number}"></label><br>
            <label>Date of Birth: <input type="date" name="date_of_birth" value="${user.date_of_birth}"></label><br>
            <label>Job: <input type="text" name="job" value="${user.job}"></label><br>
            <label>Gender: 
                <input type="radio" name="gender" value="Male" ${genderMaleChecked}> Male
                <input type="radio" name="gender" value="Female" ${genderFemaleChecked}> Female
            </label><br>
            <label>Way to Introduce: <input type="text" name="way2intro" value="${user.way2intro}"></label><br>
            <button type="button" onclick="updateUser()">Save</button>
            <button type="button" onclick="deleteUser()">Delete</button>
        </form>
    `;
    document.getElementById("user_details").innerHTML = userDetails;
}

function editUser(username) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/get_user.php?username=" + encodeURIComponent(username), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var user = JSON.parse(xhr.responseText);
            showEditForm(user);
        }
    };
    xhr.send();
}

function updateUser() {
    var form = document.getElementById("editForm");
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/update_user.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("User updated successfully");
            showUser();
        }
    };
    xhr.send(formData);
}

function deleteUser() {
    var form = document.getElementById("editForm");
    var username = form.elements['username'].value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/delete_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("User deleted successfully");
            showUser();
        }
    };
    xhr.send("username=" + encodeURIComponent(username));
}

function back(){
    window.location.href = "../index.php";
}