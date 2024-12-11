<?php
// Koneksyon sa DATABASE na eme
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

// Initialize search query
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

// SQL query to fetch contacts based on the search term
$sql = "SELECT id, name, phone_number FROM contacts";
if (!empty($searchQuery)) {
    // Apply a LIKE clause to filter results by name
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);
    $sql .= " WHERE name LIKE '%$searchQueryEscaped%'";
}
$result = $conn->query($sql);

// Handle deleting a contact
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Delete the contact from the database
    $deleteSql = "DELETE FROM contacts WHERE id = ?";
    if ($stmt = $conn->prepare($deleteSql)) {
        $stmt->bind_param("i", $deleteId);
        if ($stmt->execute()) {
            echo "Contact deleted successfully.";
        } else {
            echo "Error deleting contact: " . $stmt->error;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="view-container">
        <h1>Contact List</h1>
        
        <!-- Search form -->
        <form action="view.php" method="POST" class="search-form">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Back Button -->
        <form action="index.php" method="get" style="margin-top: 20px;">
            <button type="submit" class="back-button">Back to Form</button>
        </form>

        <!-- Scrollable Table Container -->
        <div class="scrollable-table-container"> 
        
        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Phone Number</th><th>Action</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["phone_number"] . "</td>
                        <td><a href='view.php?delete_id=" . $row["id"] . "' class='delete-btn'>Delete</a></td>
                    </tr>";  
            }
            echo "</table>";
        } else {
            echo "<p>No contacts found.</p>";
        }
        
        // Close the connection
        $conn->close();
        ?>
    
        </div>
    </div> 
</body>
</html>
