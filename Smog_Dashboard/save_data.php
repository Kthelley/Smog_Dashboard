<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Validate the data
    if(isset($data['chemical_name']) && isset($data['level']) && isset($data['status'])) {
        // Database connection
        $conn = new mysqli("localhost", "root", "", "smog_alerts");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO smog_alerts (chemical_name, level, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $data['chemical_name'], $data['level'], $data['status']);

        if ($stmt->execute()) {
            echo "Data updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid data received!";
    }
} else {
    echo "Only POST method is allowed!";
}
?>
