<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smog_alerts"; 
$conn = new mysqli($servername, $username, $password, $dbname);

$phone_number = $_POST['phone_number'];
if (substr($phone_number, 0, 2) == '09') {
    $phone_number = '+63' . substr($phone_number, 2);
}

$error_message = ""; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];

    // Check if phone number already exists in the database
    $check_sql = "SELECT * FROM contacts WHERE phone_number = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $phone_number);  // "s" means string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If phone number exists, store the error message
        $error_message = "This phone number is already registered!";
    } else {
        // If phone number does not exist, proceed with insertion
        $insert_sql = "INSERT INTO contacts (name, phone_number) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ss", $name, $phone_number); // "ss" means two string parameters
        if ($stmt->execute()) {
            echo "Contact added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contact</title>
    <link rel="stylesheet" href="Styles.css"> <!-- Link to the external CSS file -->
</head>
<body>

<div class="form-container">
    <h1>Add Contact</h1>

    <!-- Display the error message if phone number is already registered -->
    <?php if ($error_message != ""): ?>
        <div class="error-box">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="add_contact.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br><br>

        <input type="submit" value="Add Contact">
    </form>
</div>

</body>
</html>
