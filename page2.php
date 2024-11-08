<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_registration";
$port = 3307; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $cnic = $_POST['cnic'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $date = $_POST['date'] ?? '';

    if (empty($name) || empty($cnic) || empty($contact) || empty($destination) || empty($date)) {
        echo "<p class='error'>All fields are required!</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO registrations (name, cnic, contact, destination, date_of_travel) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $cnic, $contact, $destination, $date);

        if ($stmt->execute()) {
            echo "<h2 class='success'>Registration Confirmed</h2>";
            echo "<table class='output-table'>";
            echo "<tr><th>Name</th><td>$name</td></tr>";
            echo "<tr><th>CNIC</th><td>$cnic</td></tr>";
            echo "<tr><th>Contact</th><td>$contact</td></tr>";
            echo "<tr><th>Destination</th><td>$destination</td></tr>";
            echo "<tr><th>Date of Travel</th><td>$date</td></tr>";
            echo "</table>";
        } else {
            echo "<p class='error'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Registration - Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #7fedf5;
            margin: 20px;
            padding: 20px;
        }
        h2.success {
            color: #081f69;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .form-container {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .output-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #7fedf5;
        }
        .output-table th,
        .output-table td {
            border: 3px solid black;
            padding: 8px;
            text-align: left;
        }
        .output-table th {
            background-color: #7fedf5;
        }
    </style>
</head>
<body>


</body>
</html>
