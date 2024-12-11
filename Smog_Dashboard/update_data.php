<?php
// Create a connection to the database
$conn = new mysqli("localhost", "root", "", "smog_alerts");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the POST data sent from NodeMCU (assumed to be in JSON format)
$data = json_decode(file_get_contents("php://input"));

// Ensure the required fields exist
if (isset($data->chemical_name) && isset($data->level)) {
    // Get the chemical name, level, and status from the POST data
    $chemical_name = $data->chemical_name;
    $level = $data->level;
    $status = $data->status ?? 'Good'; // Use 'Good' as default if no status is provided

    // Update the data in the database
    $sql = "UPDATE smog_alerts SET level='$level', status='$status' WHERE chemical_name='$chemical_name'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data updated successfully"; // Send success message to NodeMCU
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid data received";
}

$conn->close();
?>
