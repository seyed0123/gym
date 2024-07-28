<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $date = $_POST['date'];
    $total_time = $_POST['total_time'];
    $num_session = $_POST['num_session'];
    $time_sauna = $_POST['time_sauna'];
    $time_jacuzzi = $_POST['time_jacuzzi'];
    $time_hydrotherapy = $_POST['time_hydrotherapy'];
    $time_massage = $_POST['time_massage'];
    $id = uniqid();

    $sql = "INSERT INTO session (id,useranme,date,total_time,num_session,time_sauna,time_jacuzzi,time_hydrotherapy,time_massage) values('$id','$username','$date',$total_time,$num_session,$time_sauna,$time_jacuzzi,$time_hydrotherapy,$time_massage);";

    try{
        $conn->query($sql);
        $newURL = '../index.php';
        header('Location: '.$newURL);
    }catch(Exception $e){
        echo  $conn->error;
        echo '<button onclick ="navigate()">ok</button>';
        echo '<script>function navigate(){
                    window.location.href = "../index.php";
                }
                </script>';
    }
    $conn->close();
}
?>