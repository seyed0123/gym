<?php
session_start();
$admin_file = fopen("./admin.json", "r") or die("Unable to open file!");
$admin_file_json = json_decode(fread($admin_file,filesize("./admin.json")));
fclose($admin_file);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="js/jquery.js"></script>
    <script src="js/dashbord.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="css/dashbord.css" rel="stylesheet">
    <title>Dashboard</title>

</head>
<body class="bg-warning-subtle bg-gradient py-5">
<?php
include('php/db_connect.php');
$isAdmin = $_SESSION['username'] === $admin_file_json->username;
$navbarClass = $isAdmin ? "" : "non-admin-margin";
?>

<nav class="navbar navbar-expand-lg navbar-light bg-success-subtle my-2 p-2 fixed-top border border-dark-subtle border-2 <?php echo $navbarClass; ?>">
    <a class="navbar-brand mx-auto" href="#">Brand</a>
    <?php
    if ($isAdmin) {
        echo '
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><button class="btn btn-primary mx-2 my-2" id="new_session" onclick="new_session()">New Session</button></li>
                    <li class="nav-item"><button class="btn btn-primary mx-2 my-2" id="new_program" onclick="new_program()">New Program</button></li>
                    <li class="nav-item"><button class="btn btn-primary mx-2 my-2" id="search_user" onclick="search_user()">Search User</button></li>
                </ul>
            ';
    }
    ?>
    <form class="form-inline d-flex mr-2 my-2" method="post">
        <?php
        if ($isAdmin) {
            echo '<div class="form-group position-relative">
                        <input type="text" class="form-control mx-2 mr-2" id="username" name="search_username" placeholder="Enter username" required>
                        <div id="suggestion-box" class="suggestion-list"></div>
                      </div>';
        } else {
            $session_username = $_SESSION['username'];
            echo '<input class="form-control mx-2 mr-2" type="hidden" name="search_username" readonly value="'.$session_username.'" required>';
        }
        ?>
        <button class="btn btn-outline-success mx-2" type="submit">See info</button>
    </form>
    <form class="form-inline mr-3 my-2" method="post">
        <input type="submit" name="logout" value="Logout" class="btn btn-danger">
    </form>
    <?php
    if ($isAdmin) {
        echo '</div>';
    }
    ?>
</nav>

    <!-- Logout Script -->
    <?php
    if (isset($_POST['logout'])) {
        session_destroy();
        $newURL = './index.php';
        header('Location: ' . $newURL);
    }
    ?>
    <div class="container my-5 rounded bg-success-subtle p-3 outer-border middle-border inner-border div-3d">
        <?php
        // Display filter form if a user is selected
        if (isset($_POST['search_username']) && !empty($_POST['search_username'])) {
            $search_username = $_POST['search_username'];
            // Fetch user details
            $user_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $user_query->bind_param("s", $search_username);
            $user_query->execute();
            $user_result = $user_query->get_result();

            if ($user_result->num_rows > 0) {
                $user = $user_result->fetch_assoc();
                echo "<h3>User Details:</h3>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<tr><th>Field</th><th>Value</th></tr>";
                echo "<tr><td>Name</td><td>" . $user['name'] . "</td></tr>";
                echo "<tr><td>Address</td><td>" . $user['address'] . "</td></tr>";
                echo "<tr><td>Height</td><td>" . $user['heigth'] . "</td></tr>";
                echo "<tr><td>Weight</td><td>" . $user['weigth'] . "</td></tr>";
                echo "<tr><td>Phone Number</td><td>" . $user['phone_number'] . "</td></tr>";
                echo "<tr><td>Date of Birth</td><td>" . $user['date_of_birth'] . "</td></tr>";
                echo "<tr><td>Job</td><td>" . $user['job'] . "</td></tr>";
                echo "<tr><td>Gender</td><td>" . ($user['gender'] ? 'Male' : 'Female') . "</td></tr>";
                echo "<tr><td>Way to Introduce</td><td>" . $user['way2intro'] . "</td></tr>";
                echo "</table>";

                // Fetch user programs
                $program_query = $conn->prepare("SELECT * FROM program_user JOIN program ON program_user.program_id = program.id WHERE program_user.username = ?");
                $program_query->bind_param("s", $search_username);
                $program_query->execute();
                $program_result = $program_query->get_result();

                echo "<h3>Programs:</h3>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<tr><th>Program</th><th>Start Time</th><th>Practice Time</th><th>Diagnosis</th></tr>";
                while ($program = $program_result->fetch_assoc()) {
                    echo "<tr onclick='showExercises(\"" . $program['program_id'] . "\" , \"" . $program['title'] . "\")' style='cursor: pointer;'>";
                    echo "<td>" . $program['title'] . "</td>";
                    echo "<td>" . $program['start_time'] . "</td>";
                    echo "<td>" . $program['practice_time'] . "</td>";
                    echo "<td>" . $program['diagnosis'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "    <div id=\"exercise_details\"></div>";
                // Display filter form
                echo "<form method=\"post\">
                        <input type=\"hidden\" name=\"search_username\" value=\"$search_username\">
                        <div class='input-group'>
                            <span class='input-group-text align-middle'>Start Date</span>
                            <input class='form-control' type=\"date\" name=\"start_date\" placeholder=\"Start Date\">
                        </div>
                        <div class='input-group'>
                            <span class='input-group-text align-middle'>End Date</span>
                            <input class='form-control' type=\"date\" name=\"end_date\" placeholder=\"End Date\">
                        </div>
                        
                        
                        <button class='btn btn-outline-success' type=\"submit\">Filter Sessions</button>
                        </form>";

                // Fetch user sessions with optional date filter
                if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];

                    $session_query = $conn->prepare("SELECT * FROM session WHERE username = ? AND date BETWEEN ? AND ?");
                    $session_query->bind_param("sss", $search_username, $start_date, $end_date);
                } else {
                    $session_query = $conn->prepare("SELECT * FROM session WHERE username = ?");
                    $session_query->bind_param("s", $search_username);
                }
                $session_query->execute();
                $session_result = $session_query->get_result();

                echo "<h3>Sessions:</h3>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<tr><th>Date</th><th>Total Time</th><th>Session Number</th><th>Time in Sauna</th><th>Time in Jacuzzi</th><th>Time in Hydrotherapy</th><th>Time in Massage</th></tr>";
                while ($session = $session_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $session['date'] . "</td>";
                    echo "<td>" . $session['total_time'] . " minutes</td>";
                    echo "<td>" . $session['num_session'] . "</td>";
                    echo "<td>" . $session['time_sauna'] . " minutes</td>";
                    echo "<td>" . $session['time_jacuzzi'] . " minutes</td>";
                    echo "<td>" . $session['time_hydrotherapy'] . " minutes</td>";
                    echo "<td>" . $session['time_massage'] . " minutes</td>";
                    echo "</tr>";
                }
                echo "</table></div>";
            } else {
                echo "No user found with username: $search_username";
            }
        }else {
            // Message to display when search box is empty
        // Define the path to the assets folder
        $assets_folder = 'assets/';

        // Get an array of all image files in the assets folder
        $images = glob($assets_folder . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);

        $random_image = $images[array_rand($images)];

        // Display the selected image
        echo "<img src='$random_image' width='100%'>";
        }

        ?>
    </div>


</body>
</html>