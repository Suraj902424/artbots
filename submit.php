<?php
$servername = "localhost";
$username = "root"; // Change this if you have a different MySQL user
$password = "";
$database = "contact_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];

// Insert into database
$sql = "INSERT INTO contacts (first_name, last_name, mobile, email) VALUES ('$first_name', '$last_name', '$mobile', '$email')";

if ($conn->query($sql) === TRUE) {
    // echo "Data saved successfully!";
    header('Location: contact.php');
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>



<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "contact_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM testimonials ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='testimonial'>";
        echo "<p><strong>{$row['name']}</strong></p>";
        echo "<p>{$row['message']}</p>";
        echo "<small>Submitted on: {$row['created_at']}</small>";
        echo "</div>";
    }
} else {
    echo "<p>No testimonials available yet.</p>";
}

$conn->close();
?>



