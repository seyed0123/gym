<?php
include('db_connect.php');

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $namen = "%{$name}%";
    $query = $conn->prepare("SELECT * FROM users WHERE name LIKE ?");
    $query->bind_param("s", $namen);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo "<h3>Users with username like '$name' :</h3>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Username</th><th>Address</th><th>Height</th><th>Weight</th><th>Phone Number</th><th>Date of Birth</th><th>Job</th><th>Gender</th><th>Way to Introduce</th><th>Action</th></tr>";
        while ($user = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $user['name'] . "</td>
                <td>" . $user['username'] . "</td>
                <td>" . $user['address'] . "</td>
                <td>" . $user['heigth'] . "</td>
                <td>" . $user['weigth'] . "</td>
                <td>" . $user['phone_number'] . "</td>
                <td>" . $user['date_of_birth'] . "</td>
                <td>" . $user['job'] . "</td>
                <td>" . ($user['gender'] ? 'Male' : 'Female') . "</td>
                <td>" . $user['way2intro'] . "</td>
                <td><button onclick='editUser(\"" . $user['username'] . "\")'>Edit</button></td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found with this username.";
    }
} else {
    echo "Invalid request.";
}
?>
