<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost"; // e.g., sqlXXXXXX.infinityfree.com
$username = "smilan_lanciaw";
$password = "18Lanciaw##";
$dbname = "smilan_lanciaw";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate the input data
if (isset($data['username'], $data['password'])) {
    $username = $data['username'];
    $password = $data['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Login successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}

$conn->close();
?>
