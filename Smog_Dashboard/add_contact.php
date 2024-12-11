<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smog_alerts";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contacts (name, phone_number) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $phone_number); // "ss" means two string parameters

    // Execute the query
    if ($stmt->execute()) {
        echo "New contact added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<form action="add_contact.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="text" id="phone_number" name="phone_number" required><br><br>

    <input type="submit" value="Add Contact">
</form>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contact</title>
    <link rel="stylesheet" href="Style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="form-container">
        <h2>Add New Contact</h2>
        <form action="add_contact.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required placeholder="Enter phone number">
            </div>
            <button type="submit" class="submit-btn">Add Contact</button>
        </form>
        <a href="index.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
