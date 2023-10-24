<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "quizdb"; 

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sqlWithoutTimer = "SELECT name, score FROM quiz_results ORDER BY score DESC";
$resultWithoutTimer = $conn->query($sqlWithoutTimer);

$leaderboardWithoutTimer = "";

if ($resultWithoutTimer->num_rows > 0) {
    $firstRow = true;
    
    while($row = $resultWithoutTimer->fetch_assoc()) {
        
        $crown = $firstRow ? '<img src="crown.png" class="crown_img" alt="Crown">' : '';
        $leaderboardWithoutTimer .= "<tr><td>{$crown}" . $row["name"]. "</td><td>" . $row["score"]. "</td></tr>";
        $firstRow = false; 
    }
} else {
    $leaderboardWithoutTimer = "<tr><td colspan='2'>No results</td></tr>";
}


$sqlWithTimer = "SELECT name, score, completion_time FROM quiz_timer_results ORDER BY score DESC, completion_time ASC";
$resultWithTimer = $conn->query($sqlWithTimer);

$leaderboardWithTimer = "";

if ($resultWithTimer->num_rows > 0) {
    $firstRow = true;
    
    while($row = $resultWithTimer->fetch_assoc()) {
        $crown = $firstRow ? '<img src="crown.png" class="crown_img" alt="Crown">' : '';
        $leaderboardWithTimer .= "<tr><td>{$crown}" . $row["name"]. "</td><td>" . $row["score"]. "</td><td>" . $row["completion_time"]. "</td></tr>";
        $firstRow = false;
    }
} else {
    $leaderboardWithTimer = "<tr><td colspan='3'>No results</td></tr>";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online quiz platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top:50px;
        }

        .crown_img{
            height:35px;
            width:35px;
            margin-left:-30px;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container button {
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border:none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button-container button:hover {
            cursor: pointer;
            background-color: #0056b3;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .leaderboard-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: inline-block;
            vertical-align: top;
            margin-right: 80px;
            margin-left:90px;
        }

        .leaderboard-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .leaderboard-table {
            border-collapse: collapse;
            width: 100%;
        }

        .leaderboard-table th, .leaderboard-table td {
            padding: 8px;
            text-align: left;
        }

        .leaderboard-table th {
            background-color: #f2f2f2;
        }

        .leaderboard-table th, .leaderboard-table td {
            border: none; 
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Online Quiz Platform</h1>
        <p>Welcome to our Web Development Quiz! This quiz contains a variety of multiple-choice questions designed to test your knowledge
             of web development concepts. Good luck and enjoy the quiz!</p>

        <h3>Select a Quiz Type:</h3>
        <div class="button-container">
        <button onclick="promptName('index', 'withoutTimer')">Take Quiz</button>
        <button onclick="promptName('index1', 'withTimer')">Take Quiz with Timer</button>

        </div>
              
    </div>
    <br>
    <br>
    <div class="leaderboard-container">
    <h2>Leaderboard for Quiz Without Timer</h2>
    <table class="leaderboard-table">
        <tr>
            <th>Name</th>
            <th>Score</th>
        </tr>
        <?php echo $leaderboardWithoutTimer; ?>
    </table>
</div>


<div class="leaderboard-container">
    <h2>Leaderboard for Quiz With Timer</h2>
    <table class="leaderboard-table">
        <tr>
            <th>Name</th>
            <th>Score</th>
            <th>Time Taken(in seconds)</th>
        </tr>
        <?php echo $leaderboardWithTimer; ?>
    </table>
</div>

    <script>
        function promptName(quizType) {
    const name = prompt("Please enter your name:");
    if (name) {
        window.location.href = `${quizType}.html?name=${encodeURIComponent(name)}&quizType=${quizType}`;
    }
}

    </script>
    <script src="script.js"></script>
</body>
</html>
