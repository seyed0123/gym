<?php
include('db_connect.php');

if (isset($_POST['program_id'])) {
    $program_id = $_POST['program_id'];
    $program_name = $_POST['program_name'];

    // Fetch exercises for the given program
    $exercise_query = $conn->prepare("SELECT exersise.* FROM exersise_program JOIN exersise ON exersise_program.exersise_id = exersise.id WHERE exersise_program.program_id = ?");
    $exercise_query->bind_param("s", $program_id);
    $exercise_query->execute();
    $exercise_result = $exercise_query->get_result();

    if ($exercise_result->num_rows > 0) {
        echo "<h3>Exercises in $program_name:</h3>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<tr><th>Title</th><th>Number of Sets</th><th>Description</th></tr>";
        while ($exercise = $exercise_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $exercise['title'] . "</td>";
            echo "<td>" . $exercise['num_sets'] . "</td>";
            echo "<td>" . $exercise['description'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No exercises found for this program.";
    }
} else {
    echo "Invalid request.";
}
?>
