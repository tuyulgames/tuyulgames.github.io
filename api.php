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
if (isset($data['user_id'], $data['username'], $data['amount'], $data['previous_balance'], $data['new_balance'], $data['date'])) {
    $user_id = $data['user_id'];
    $username = $data['username'];
    $amount = $data['amount'];
    $previous_balance = $data['previous_balance'];
    $new_balance = $data['new_balance'];
    $date = $data['date'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO top_up_history (user_id, username, amount, previous_balance, new_balance, date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isddds", $user_id, $username, $amount, $previous_balance, $new_balance, $date);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Top-up history recorded"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}

$conn->close();
?>
