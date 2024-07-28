<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $requiredFields = ['username', 'password', 'name','address', 'phone_number', 'height', 'weight', 'date_of_birth', 'job', 'gender', 'way2intro'];
    $missingFields = array_filter($requiredFields, function($field) {
        return empty($_POST[$field]);
    });
    if (!empty($missingFields)) {
        echo '<h1>All fields are required</h1>';
    } else
    {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $name = $_POST['name']; 
        $address = $_POST['address'];
        $phone_number = $_POST['phone_number'];
        $height = $_POST['height']; 
        $weight = $_POST['weight'];
        $date_of_birth = $_POST['date_of_birth'];
        $job = $_POST['job'];
        $gender = $_POST['gender'] === 'male'; 
        $way2intro = $_POST['way2intro']; 
    
        $sql = "INSERT INTO users (username, password,name,address,heigth,weigth,phone_number,date_of_birth,job,gender,way2intro) VALUES ('$username', '$password','$name','$address',$height,$weight,$phone_number,'$date_of_birth','$job',$gender,'$way2intro')";
        try{
            if ($conn->query($sql) === TRUE) {
                $newURL = '../index.php';
                header('Location: '.$newURL);
            } else {
                $newURL = '../login.html';
                header('Location: '.$newURL);
            }
        }catch(Exception $e){
            echo "Error: " . $sql . "<br>" . $conn->error;
            $newURL = '../login.html';
            header('Location: '.$newURL);
        }
        
    
        $conn->close();
    }
}
?>