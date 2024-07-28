<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Search in Exercises</h1>
    <form method="post">
        <input type="text" placeholder="exercise title" name="title" required>
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
            }
        }

        if (isset($_SESSION['exercise_results'])) {
            if (is_array($_SESSION['exercise_results'])) {
                echo "<table>
                    <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>num_sets</th>
                    <th>description</th>
                    </tr>";
                foreach ($_SESSION['exercise_results'] as $row) {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["title"]. "</td><td> " . $row["num_sets"]. "</td><td>" . $row['description'] . "</td></tr>";
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
        <input type="text" placeholder="title" name="title_program" required>
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
                foreach ($_SESSION['program_results'] as $row) {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["title"]. "</td><td> " . $row["num_session"]. "</td></tr>";
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
            <button type="submit">create</button>
        </form>
    <h1>Program user</h1>
    <form method="post" action="php/program_user.php">
        <input type="text" name="username" placeholder="username" required/>
        <input type="text" name="program_id" placeholder="program_id" required/>
        <input type="date" name="start_time" placeholder="start time" required/>
        <input type="time" name="practice_time" placeholder="practice time" required/>
        <input type="text" name="diagnosis" placeholder="diagnosis" required/>
        <button type="submit">create</button>
    </form>
    <button onclick="back()">back</button>
    <script>
        function back(){
            window.location.href = "../index.php";
        }
    </script>
</body>
</html>
