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
        <form  id="editForm">
           <input type="hidden" name="username" value="${user.username}">
            <div class="form-row row">
                <div class="form-group col-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="${user.name}">
                </div>
                <div class="form-group col-6">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="${user.address}">
                </div>
            </div>
            <div class="form-row row">
                <div class="form-group col-md-6">
                    <label for="height">Height</label>
                    <input type="number" class="form-control" id="height" name="height" value="${user.heigth}">
                </div>
                <div class="form-group col-md-6">
                    <label for="weight">Weight</label>
                    <input type="number" class="form-control" id="weight" name="weight" value="${user.weigth}">
                </div>
            </div>
            <div class="form-row row">
                <div class="form-group col-md-6">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="${user.phone_number}">
                </div>
                <div class="form-group col-md-6">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="${user.date_of_birth}">
                </div>
            </div>
            <div class="form-row row">
                <div class="form-group col-md-6">
                    <label for="job">Job</label>
                    <input type="text" class="form-control" id="job" name="job" value="${user.job}">
                </div>
                <div class="form-group col-md-6">
                    <label for="way2intro">Way to Introduce</label>
                    <input type="text" class="form-control" id="way2intro" name="way2intro" value="${user.way2intro}">
                </div>
            </div>
            <div class="form-group row">
                <label>Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" ${genderMaleChecked}>
                    <label class="form-check-label" for="genderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" ${genderFemaleChecked}>
                    <label class="form-check-label" for="genderFemale">Female</label>
                </div>
            </div>
            <div class="form-group ">
                <button class="btn btn-primary" type="button" onclick="updateUser()">Save</button>
                <button class="btn btn-danger" type="button" onclick="deleteUser()">Delete</button>
            </div>
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