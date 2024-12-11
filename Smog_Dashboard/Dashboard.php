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

// Query to get the current gas level
$query_current = "SELECT level FROM gas_data ORDER BY timestamp DESC LIMIT 1";
$result_current = $conn->query($query_current);
if ($result_current->num_rows > 0) {
    $row = $result_current->fetch_assoc();
    $gas_level = $row['level'];
} else {
    $gas_level = "No data available";
}

// Query to get the gas level history
$query_history = "SELECT level, timestamp FROM gas_data ORDER BY timestamp DESC";
$result_history = $conn->query($query_history);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gas Level Monitoring Dashboard</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Gas Level Monitoring Dashboard</h1>
        <p>Current Gas Level:</p>
        <div class="highlighted-box">
            <span id="gas-level"><?php echo htmlspecialchars($gas_level); ?></span>
        </div>

        <!-- History Table -->
        <h2>Gas Level History</h2>
        <div class="scrollable-history">
            <table>
                <tr>
                    <th>Level</th>
                    <th>Timestamp</th>
                </tr>
                <?php if ($result_history->num_rows > 0): ?>
                    <?php while($row = $result_history->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['level']); ?></td>
                            <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="2">No history available.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <!-- Back to Contacts Button -->
        <a href="Index.php" class="back-button">Back to Form</a>   
    </div>

    <script src="DashboardScript.js"></script>
</body>
</html>
