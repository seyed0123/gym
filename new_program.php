<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>New program</title>
    <link href="css/new_program.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/new_program.js"></script>
</head>
<body class="bg-warning-subtle bg-gradient">
<div class="container my-4 mx-auto border rounded bg-success-subtle shadow-lg border-4 border-dark-subtle p-3">
    <div class="row">
        <div class="col"><h1 class="text-center my-4">New Exercise</h1>
            <div class="form-container">
                <form action="php/exersice.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control my-2" name="title" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control my-2" name="num_sets" placeholder="Number of Sets" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control my-2" name="description" placeholder="Description" required>
                    </div>
                    <button type="submit" class="btn my-2 mx-2 btn-success">Create</button>
                </form>
            </div>
        </div>
        <div class="col"><h1 class="text-center my-4">Search in Exercises</h1>
            <div class="form-container">
                <form method="post">
                    <div class="form-group">
                        <input type="text" class="form-control my-2" placeholder="Exercise Title" name="title">
                    </div>
                    <input type="hidden" name="form_type" value="search_exercise">
                    <button type="submit" class="btn my-2 mx-2 btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>



    <?php
    session_start();
    include 'php/db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['form_type'] === 'search_exercise') {
            $title = $_POST['title'];
            $sql = "SELECT * FROM exersise WHERE title LIKE '%$title%'";
            $result = $conn->query($sql);
            $_SESSION['exercise_results'] = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['exercise_results'][] = $row;
                }
            } else {
                $_SESSION['exercise_results'] = "no results found";
            }
            $conn->close();
        } elseif ($_POST['form_type'] === 'search_program') {
            $title_program = $_POST['title_program'];
            $sql = "SELECT * FROM program WHERE title LIKE '%$title_program%'";
            $result = $conn->query($sql);
            $_SESSION['program_results'] = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['program_results'][] = $row;
                }
            } else {
                $_SESSION['program_results'] = "no results found";
            }
            $conn->close();
        }elseif ($_POST['form_type'] === 'search_program_exercise') {
            $id_program = $_POST['id_program'];
            $sql = "SELECT * FROM exersise_program WHERE program_id = '$id_program'";
            $result = $conn->query($sql);
            $_SESSION['program_exersice_results'] = [];
            $exercises = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $exercises[] = $row['exersise_id'];
                }
            } else {
                $_SESSION['program_exersice_results'] = "no results found";
            }
            foreach($exercises as $id_exer){
                $sql = "SELECT * FROM exersise WHERE id = '$id_exer'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['program_exersice_results'][] = $row;
                }
            }
            $_SESSION['program_exersice_progid'] = $id_program;
            $conn->close();
        }elseif ($_POST['form_type'] === 'search_program_user') {
            $id_program = $_POST['id_program2'];
            $sql = "SELECT * FROM program_user WHERE program_id = '$id_program'";
            $result = $conn->query($sql);
            $_SESSION['program_user_results'] = [];
            $usernames = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $usernames[] = $row;
                }
            } else {
                $_SESSION['program_user_results'] = "no results found";
            }
            // print_r($usernames);
            foreach($usernames as $username){
                $user = $username['username'];
                $sql = "SELECT name FROM users WHERE username = '$user'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $row['start_time'] = $username['start_time'];
                    $row['practice_time'] = $username['practice_time'];
                    $row['diagnosis'] = $username['diagnosis'];
                    $row['username'] = $username['username'];
                    $_SESSION['program_user_results'][] = $row;
                }
            }
            $_SESSION['program_user_progid'] = $id_program;
            $conn->close();
        }
    }

    if (isset($_SESSION['exercise_results'])) {
        if (is_array($_SESSION['exercise_results'])) {
            echo '<form action="php/clear_results.php" method="post">';
            echo '<input type="hidden" name="clear" value="exercise_results">';
            echo '<button type="submit" class="btn-close" aria-label="Close"></button>';
            echo '</form>';

            echo '<div class="table-responsive"><table class="table table-bordered table-striped">';
            echo '<thead class="thead-dark"><tr><th>ID</th><th>Title</th><th>Num Sets</th><th>Description</th><th>Actions</th></tr></thead><tbody>';
            foreach ($_SESSION['exercise_results'] as $index => $row) {
                echo '<tr>';
                echo "<td onclick='set_exercise_id(\"{$row['id']}\")'>{$row['id']}</td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['num_sets']}</td>";
                echo "<td>{$row['description']}</td>";
                echo '<td>';
                echo "<button class='btn my-2 mx-2 btn-secondary' onclick='toggleFormExer({$index})'>Edit</button>";
                echo "<div id='editFormExer{$index}' style='display:none;' class='form-container'>";
                echo "<form action='php/edit_exersice.php' method='post'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<input type='text' class='form-control my-2' name='title' value='{$row['title']}'>";
                echo "<input type='number' class='form-control my-2' name='num_sets' value='{$row['num_sets']}'>";
                echo "<input type='text' class='form-control my-2' name='description' value='{$row['description']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-success'>Save Changes</button>";
                echo "</form></div>";
                echo "<form action='php/delete_exersice.php' method='post' class='d-inline-block'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-danger'>Delete</button>";
                echo "</form>";
                echo '</td></tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo "<div class='alert alert-info'>{$_SESSION['exercise_results']}</div>";
        }
    }
    ?>
    <div class="row">
        <div class="col">
            <h1 class="text-center my-4">New Program</h1>
            <div class="form-container">
                <form method="post" action="php/program.php">
                    <div class="form-group">
                        <input type="text" class="form-control my-2" name="title" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control my-2" name="num_session" placeholder="Number of Sessions" required>
                    </div>
                    <button type="submit" class="btn my-2 mx-2 btn-success">Create</button>
                </form>
            </div>
        </div>
        <div class="col">
            <h1 class="text-center my-4">Search in Programs</h1>
            <div class="form-container">
                <form method="post">
                    <div class="form-group">
                        <input type="text" class="form-control my-2" placeholder="Program Title" name="title_program">
                    </div>
                    <input type="hidden" name="form_type" value="search_program">
                    <button type="submit" class="btn my-2 mx-2 btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>



    <?php
    if (isset($_SESSION['program_results'])) {
        if (is_array($_SESSION['program_results'])) {
            echo '<form action="php/clear_results.php" method="post">';
            echo '<input type="hidden" name="clear" value="program_results">';
            echo '<button type="submit" class="btn-close" aria-label="Close"></button>';
            echo '</form>';

            echo '<div class="table-container"><table class="table table-bordered table-striped">';
            echo '<thead class="thead-dark"><tr><th>ID</th><th>Title</th><th>Number of Sessions</th><th>Actions</th></tr></thead><tbody>';
            foreach ($_SESSION['program_results'] as $index => $row) {
                echo '<tr>';
                echo "<td onclick='set_program_id(\"{$row['id']}\")'>{$row['id']}</td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['num_session']}</td>";
                echo '<td>';
                echo "<button class='btn my-2 mx-2 btn-secondary' onclick='toggleFormProg({$index})'>Edit</button>";
                echo "<div id='editFormProg{$index}' style='display:none;' class='form-container'>";
                echo "<form action='php/edit_program.php' method='post'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<input type='text' class='form-control my-2' name='title' value='{$row['title']}'>";
                echo "<input type='number' class='form-control my-2' name='num_session' value='{$row['num_session']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-success'>Save Changes</button>";
                echo "</form></div>";
                echo "<form action='php/delete_program.php' method='post' class='d-inline-block'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-danger'>Delete</button>";
                echo "</form>";
                echo '</td></tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo "<div class='alert alert-info'>{$_SESSION['program_results']}</div>";
        }
    }
    ?>
    <div class="row">
        <div class="col">
            <h1 class="text-center my-4">Program Exercise</h1>
            <div class="form-container">
                <form method="post" action="php/program_exercise.php">
                    <div class="form-group">
                        <input id="exercise_id_program_exercise" type="text" class="form-control my-2" name="exercise_id" placeholder="Exercise ID" required>
                    </div>
                    <div class="form-group">
                        <input id="program_id_program_exercise" type="text" class="form-control my-2" name="program_id" placeholder="Program ID" required>
                    </div>
                    <button type="submit" class="btn my-2 mx-2 btn-success">Add</button>
                </form>
            </div>
        </div>
        <div class="col">
            <h1 class="text-center my-4">Search Program Exercise</h1>
            <div class="form-container">
                <form method="post">
                    <div class="form-group">
                        <input id="program_id_exercise_program_search" type="text" class="form-control my-2" placeholder="Program ID" name="id_program" required>
                    </div>
                    <input type="hidden" name="form_type" value="search_program_exercise">
                    <button type="submit" class="btn my-2 mx-2 btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>



    <?php
    if (isset($_SESSION['program_exersice_results'])) {
        if (is_array($_SESSION['program_exersice_results'])) {
            echo '<form action="php/clear_results.php" method="post">';
            echo '<input type="hidden" name="clear" value="program_exersice_results">';
            echo '<button type="submit" class="btn-close" aria-label="Close"></button>';
            echo '</form>';

            echo '<div class="table-container"><table class="table table-bordered table-striped">';
            echo '<thead class="thead-dark"><tr><th>ID</th><th>Title</th><th>Num Sets</th><th>Description</th><th>Actions</th></tr></thead><tbody>';
            foreach ($_SESSION['program_exersice_results'] as $index => $row) {
                echo '<tr>';
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['num_sets']}</td>";
                echo "<td>{$row['description']}</td>";
                echo '<td>';
                echo "<form action='php/delete_program_exersice.php' method='post' class='d-inline-block'>";
                echo "<input type='hidden' name='exersise_id' value='{$row['id']}'>";
                echo "<input type='hidden' name='program_id' value='{$_SESSION['program_exersice_progid']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-danger'>Delete</button>";
                echo "</form>";
                echo '</td></tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo "<div class='alert alert-info'>{$_SESSION['program_exersice_results']}</div>";
        }
    }
    ?>
    <div class="row">
        <div class="col">
            <h1 class="text-center my-4">Program User</h1>
            <div class="form-container">
                <form method="post" action="php/program_user.php">
                    <div class="form-group position-relative">
                        <input type="text" class="form-control my-2" id="username" name="username" placeholder="Username" required>
                        <div id="suggestion-box" class="suggestion-list"></div>
                    </div>
                    <div class="form-group">
                        <input id="program_id_user_program" type="text" class="form-control my-2" name="program_id" placeholder="Program ID" required>
                    </div>
                    <div class="input-group my-2">
                        <span class="input-group-text align-middle">Start Time</span>
                        <input type="date" class="form-control" name="start_time" placeholder="Start Time" required>
                    </div>
                    <div class="input-group my-2">
                        <span class="input-group-text align-middle">Pratice Time</span>
                        <input type="time" class="form-control" name="practice_time" placeholder="Practice Time" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control my-2" name="diagnosis" placeholder="Diagnosis" required>
                    </div>
                    <button type="submit" class="btn my-2 mx-2 btn-success">Add</button>
                </form>
            </div>
        </div>
        <div class="col">
            <h1 class="text-center my-4">Search Program User</h1>
            <div class="form-container">
                <form method="post">
                    <div class="form-group">
                        <input id="program_id_user_program_search" type="text" class="form-control my-2" placeholder="Program ID" name="id_program2" required>
                    </div>
                    <input type="hidden" name="form_type" value="search_program_user">
                    <button type="submit" class="btn my-2 mx-2 btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>





    <?php
    if (isset($_SESSION['program_user_results'])) {
        if (is_array($_SESSION['program_user_results'])) {
            echo '<form action="php/clear_results.php" method="post">';
            echo '<input type="hidden" name="clear" value="program_user_results">';
            echo '<button type="submit" class="btn-close" aria-label="Close"></button>';
            echo '</form>';
            echo '<div class="table-container"><table class="table table-bordered table-striped">';
            echo '<thead class="thead-dark"><tr><th>Username</th><th>Name</th><th>Start Time</th><th>Practice Time</th><th>Diagnosis</th><th>Actions</th></tr></thead><tbody>';
            foreach ($_SESSION['program_user_results'] as $index => $row) {
                echo '<tr>';
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['start_time']}</td>";
                echo "<td>{$row['practice_time']}</td>";
                echo "<td>{$row['diagnosis']}</td>";
                echo '<td>';
                echo "<button class='btn my-2 mx-2 btn-secondary' onclick='toggleFormProgUser({$index})'>Edit</button>";
                echo "<div id='editFormProgUser{$index}' style='display:none;' class='form-container'>";
                echo "<form action='php/edit_program_user.php' method='post'>";
                echo "<input type='hidden' name='username' value='{$row['username']}'>";
                echo "<input type='hidden' name='program_id' value='{$_SESSION['program_user_progid']}'>";
                echo "<input type='date' class='form-control my-2' name='start_time' value='{$row['start_time']}'>";
                echo "<input type='time' class='form-control my-2' name='practice_time' value='{$row['practice_time']}'>";
                echo "<input type='text' class='form-control my-2' name='diagnosis' value='{$row['diagnosis']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-success'>Save Changes</button>";
                echo "</form></div>";
                echo "<form action='php/delete_program_user.php' method='post' class='d-inline-block'>";
                echo "<input type='hidden' name='username' value='{$row['username']}'>";
                echo "<input type='hidden' name='program_id' value='{$_SESSION['program_user_progid']}'>";
                echo "<button type='submit' class='btn my-2 mx-2 btn-danger'>Delete</button>";
                echo "</form>";
                echo '</td></tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo "<div class='alert alert-info'>{$_SESSION['program_user_results']}</div>";
        }
    }
    ?>
    <div class="text-center">
        <button class="btn my-2 mx-2 btn-outline-danger fixed-button" onclick="back()">Back</button>
    </div>

</div>

</body>
</html>
