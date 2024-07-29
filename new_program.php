<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="js/new_program.js"></script>
</head>
<body>
    <h1>New Exersice</h1>
        <form action="php/exersice.php" method="post">
            <input type="text" name="title" placeholder="Title" required>
            <input type="number" name="num_sets" placeholder="number of sets" required>
            <input type="text" name="description" placeholder="Description" required> 
        
            <button type="submit">Create</button>
        </form>
    <h1>Search in Exercises</h1>
    <form method="post">
        <input type="text" placeholder="exercise title" name="title">
        <input type="hidden" name="form_type" value="search_exercise">
        <button type="submit">search</button>
    </form>
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
                echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Num Sets</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>";
                foreach ($_SESSION['exercise_results'] as $index => $row) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['num_sets']}</td>
                            <td>{$row['description']}</td>
                            <td>
                                <button onclick=\"toggleFormExer({$index})\">Edit</button>
                                <div id=\"editFormExer{$index}\" style=\"display:none;\">
                                    <form action='php/edit_exersice.php' method='post'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='text' name='title' value='{$row['title']}'>
                                        <input type='number' name='num_sets' value='{$row['num_sets']}'>
                                        <input type='text' name='description'value='{$row['description']}'></input>
                                        <input type='submit' value='Save Changes'>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <form action='php/delete_exersice.php' method='post'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='submit' value='delete'>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo $_SESSION['exercise_results'];
            }
        }
    ?> 

    <h1>New Program</h1>
    <form method="post" action="php/program.php">
        <input type="text" name="title" placeholder="title" required>
        <input type="number" name="num_session" placeholder="number of sessions" required>
        <button type="submit">create</button>
    </form>

    <h1>Search in Programs</h1>
    <form method="post">
        <input type="text" placeholder="title" name="title_program">
        <input type="hidden" name="form_type" value="search_program">
        <button type="submit">search</button>
    </form>
    <?php
        if (isset($_SESSION['program_results'])) {
            if (is_array($_SESSION['program_results'])) {
                echo "<table>
                    <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>Number of sessions</th>
                    </tr>";
                foreach ($_SESSION['program_results'] as $index => $row) {
                    echo "<tr>
                            <td>{$row["id"]}</td>
                            <td>{$row["title"]}</td>
                            <td>{$row["num_session"]}</td>
                            <td>
                                <button onclick=\"toggleFormProg({$index})\">Edit</button>
                                <div id=\"editFormProg{$index}\" style=\"display:none;\">
                                    <form action='php/edit_program.php' method='post'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='text' name='title' value='{$row['title']}'>
                                        <input type='number' name='num_session' value='{$row['num_session']}'>
                                        <input type='submit' value='Save Changes'>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <form action='php/delete_program.php' method='post'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='submit' value='delete'>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo $_SESSION['program_results'];
            }
        }
    ?>
    <h1>Program Exercise</h1>
        <form method="post" action="php/program_exercise.php">
            <input type="text" name="exercise_id" placeholder="exercise_id" required/>
            <input type="text" name="program_id" placeholder="program_id" required/>
            <button type="submit">Add</button>
        </form>
    <h1>Search program Exersice</h1>
        <form method="post">
            <input type="text" placeholder="program id" name="id_program" require>
            <input type="hidden" name="form_type" value="search_program_exercise">
            <button type="submit">search</button>
        </form>
        <?php
        if (isset($_SESSION['program_exersice_results'])) {
            if (is_array($_SESSION['program_exersice_results'])) {
                echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Num Sets</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>";
                foreach ($_SESSION['program_exersice_results'] as $index => $row) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['num_sets']}</td>
                            <td>{$row['description']}</td>
                            <td>
                                <form action='php/delete_program_exersice.php' method='post'>
                                    <input type='hidden' name='exersise_id' value='{$row['id']}'>
                                    <input type='hidden' name='program_id' value='{$_SESSION['program_exersice_progid']}'>
                                    <input type='submit' value='delete'>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo $_SESSION['program_exersice_results'];
            }
        }
        ?>
    <h1>Program user</h1>
    <form method="post" action="php/program_user.php">
        <input type="text" name="username" placeholder="username" required/>
        <input type="text" name="program_id" placeholder="program_id" required/>
        <input type="date" name="start_time" placeholder="start time" required/>
        <input type="time" name="practice_time" placeholder="practice time" required/>
        <input type="text" name="diagnosis" placeholder="diagnosis" required/>
        <button type="submit">Add</button>
    </form>
    <h1>Search program User</h1>
        <form method="post">
            <input type="text" placeholder="program id" name="id_program2" require>
            <input type="hidden" name="form_type" value="search_program_user">
            <button type="submit">search</button>
        </form>
        
        <?php
        if (isset($_SESSION['program_user_results'])) {
            if (is_array($_SESSION['program_user_results'])) {
                echo "<table>
                <tr>
                    <th>Username</th>
                    <th>name</th>
                    <th>start time</th>
                    <th>Practice time</th>
                    <th>diagnosis</th>
                    <th>Action</th>
                </tr>";
                foreach ($_SESSION['program_user_results'] as $index => $row) {
                    echo "<tr>
                            <td>{$row['username']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['start_time']}</td>
                            <td>{$row['practice_time']}</td>
                            <td>{$row['diagnosis']}</td>
                            <td>
                                <button onclick=\"toggleFormProgUser({$index})\">Edit</button>
                                <div id=\"editFormProgUser{$index}\" style=\"display:none;\">
                                    <form action='php/edit_program_user.php' method='post'>
                                        <input type='hidden' name='username' value='{$row['username']}'>
                                        <input type='hidden' name='program_id' value='{$_SESSION['program_user_progid']}'>
                                        <input type='date' name='start_time' value='{$row['start_time']}'>
                                        <input type='time' name='practice_time' value='{$row['practice_time']}'>
                                        <input type='text' name='diagnosis' value='{$row['diagnosis']}'></input>
                                        <input type='submit' value='Save Changes'>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <form action='php/delete_program_user.php' method='post'>
                                    <input type='hidden' name='username' value='{$row['username']}'>
                                    <input type='hidden' name='program_id' value='{$_SESSION['program_user_progid']}'>
                                    <input type='submit' value='delete'>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo $_SESSION['program_user_results'];
            }
        }
        ?>
    <button onclick="back()">back</button>
</body>
</html>
