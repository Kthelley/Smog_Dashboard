<?php
header('Content-Type: application/json');

// Define the function to calculate status based on chemical level
function getStatus($chemical, $level) {
    // Check the status based on the chemical and its level
    if ($chemical == "Nitrogen Dioxide (NO₂)") {
        if ($level <= 40) return 'Good';
        if ($level <= 80) return 'Moderate';
        if ($level <= 180) return 'Unhealthy for Sensitive Groups';
        if ($level <= 300) return 'Unhealthy';
        return 'Very Unhealthy';
    }

    if ($chemical == "Ozone (O₃)") {
        if ($level <= 50) return 'Good';
        if ($level <= 100) return 'Moderate';
        if ($level <= 200) return 'Unhealthy for Sensitive Groups';
        if ($level <= 300) return 'Unhealthy';
        return 'Very Unhealthy';
    }

    if ($chemical == "PM2.5") {
        if ($level <= 35) return 'Good';
        if ($level <= 75) return 'Moderate';
        if ($level <= 150) return 'Unhealthy for Sensitive Groups';
        if ($level <= 250) return 'Unhealthy';
        if ($level <= 350) return 'Very Unhealthy';
        return 'Hazardous';
    }

    if ($chemical == "PM10") {
        if ($level <= 50) return 'Good';
        if ($level <= 100) return 'Moderate';
        if ($level <= 150) return 'Unhealthy for Sensitive Groups';
        if ($level <= 250) return 'Unhealthy';
        if ($level <= 350) return 'Very Unhealthy';
        return 'Hazardous';
    }

    if ($chemical == "VOCs") {
        if ($level <= 500) return 'Good';
        if ($level <= 1000) return 'Moderate';
        if ($level <= 1500) return 'Unhealthy for Sensitive Groups';
        if ($level <= 2000) return 'Unhealthy';
        if ($level <= 3000) return 'Very Unhealthy';
        return 'Hazardous';
    }

    return 'Unknown';  // In case the chemical is not recognized
}

// Database connection
$conn = new mysqli("localhost", "root", "", "smog_alerts");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch chemical data
$sql = "SELECT chemical_name, level FROM smog_alerts";
$result = $conn->query($sql);

// Initialize an array to store chart data
$chartData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chemical_name = $row['chemical_name'];
        $level = $row['level'];

        // Get the status based on the chemical and its level
        $status = getStatus($chemical_name, $level);

        // Add the data to the chart data array
        $chartData[] = [
            'chemical_name' => $chemical_name,
            'level' => $level,
            'status' => $status
        ];

        // Display the data dynamically in the table
        echo "<tr>
                <td>{$chemical_name}</td>
                <td>{$level}</td>
                <td class='" . strtolower($status) . "'>{$status}</td>
              </tr>";
    }
} else {
    echo "No data available.";
}

// Close the database connection
$conn->close();

// Return the chart data as JSON
echo json_encode($chartData);
?>
