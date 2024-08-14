<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
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
        $gender = $_POST['gender'] === 'male'? 1 : 0 ;
        $way2intro = $_POST['way2intro'];
        echo $gender."\n";
    
        $sql = "INSERT INTO users (username, password,name,address,heigth,weigth,phone_number,date_of_birth,job,gender,way2intro) VALUES ('$username', '$password','$name','$address',$height,$weight,$phone_number,'$date_of_birth','$job',$gender,'$way2intro')";
        echo $sql."\n";
        try{
            if ($conn->query($sql) === TRUE) {
//                $newURL = '../index.php';
                echo "<script>
                    window.location.href = '../index.php';
                    alert('account created successfully');
                  </script>";
            } else {
                echo "<script>
                    window.location.href = '../index.php';
                    alert('account doesn\'t created successfully');
                  </script>";
            }
//            header('Location: '.$newURL);
        }catch(Exception $e){
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<script>
                    window.location.href = '../index.php';
                    alert('account doesn\'t created successfully');
                  </script>";

        }
        
    
        $conn->close();
    }
}
?>