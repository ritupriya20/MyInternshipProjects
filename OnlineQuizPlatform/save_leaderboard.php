<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "quizdb"; 

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$score = $_POST['score'];
$quizType = $_POST['quizType'];

if($quizType=="index"){
$sql = "INSERT INTO quiz_results(name, score) VALUES ('$name', '$score')";
if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
}
 else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
elseif($quizType=="index1"){
    $completionTime = $_POST['completionTime'];
    $sql = "INSERT INTO quiz_timer_results(name, score, completion_time) VALUES ('$name', '$score', '$completionTime')";
    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

