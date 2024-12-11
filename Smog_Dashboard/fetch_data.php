<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "smog_alerts");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT chemical_name, level, status FROM smog_alerts";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

// Return data in JSON format
echo json_encode($data);
?>
