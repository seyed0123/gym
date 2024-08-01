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
        echo "<div class='table-responsive'>";
        echo "<table class='table table table-bordered table-striped'>";
        echo "<thead class='thead-dark'>";
        echo "<tr><th>Name</th><th>Username</th><th>Address</th><th>Height</th><th>Weight</th><th>Phone Number</th><th>Date of Birth</th><th>Job</th><th>Gender</th><th>Way to Introduce</th><th>Action</th></tr>";
        echo "</thead><tbody>";
        while ($user = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($user['name']) . "</td>
                    <td>" . htmlspecialchars($user['username']) . "</td>
                    <td>" . htmlspecialchars($user['address']) . "</td>
                    <td>" . htmlspecialchars($user['heigth']) . "</td>
                    <td>" . htmlspecialchars($user['weigth']) . "</td>
                    <td>" . htmlspecialchars($user['phone_number']) . "</td>
                    <td>" . htmlspecialchars($user['date_of_birth']) . "</td>
                    <td>" . htmlspecialchars($user['job']) . "</td>
                    <td>" . ($user['gender'] ? 'Male' : 'Female') . "</td>
                    <td>" . htmlspecialchars($user['way2intro']) . "</td>
                    <td><button class='btn btn-secondary' onclick='editUser(\"" . htmlspecialchars($user['username']) . "\")'>Edit</button></td>
                </tr>";
        }
        echo "</tbody></table>";
        echo "</div>";

    } else {
        echo "No users found with this username.";
    }
} else {
    echo "Invalid request.";
}
?>
