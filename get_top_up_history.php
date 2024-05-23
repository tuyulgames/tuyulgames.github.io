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

// Get top-up history
$sql = "SELECT user_id, username, amount, previous_balance, new_balance, date FROM top_up_history ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => "No records found"]);
}

$conn->close();
?>
