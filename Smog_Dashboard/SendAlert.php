<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smog_alerts";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to fetch phone numbers from contacts table
$sql = "SELECT phone_number FROM contacts";
$result = $conn->query($sql);

$contacts = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $contacts[] = $row['phone_number'];
  }
} else {
  echo "No contacts found";
}
$conn->close();

// Return contacts as JSON
echo json_encode($contacts);
?>
