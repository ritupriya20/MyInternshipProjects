<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = mysqli_connect("localhost", "root", "", "portfolio");

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $query = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($connection, $query)) {
        mysqli_close($connection);
        header("Location: home.html"); // Redirect to a success page
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    echo "Invalid request.";
}
?>
