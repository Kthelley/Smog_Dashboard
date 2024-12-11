<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smog_alerts"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if gas level is passed in the URL
if(isset($_GET['gas_levels'])) {
    $gas_level = $_GET['gas_levels'];

    // Insert gas level with the current timestamp into the 'gas_levels' table
    $query = "INSERT INTO gas_levels (level, timestamp) VALUES ('$gas_levels', NOW())";
    
    if ($conn->query($query) === TRUE) {
        echo "Gas level recorded successfully!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
} else {
    echo "No gas level data received.";
}

// Close the connection
$conn->close();
?>
