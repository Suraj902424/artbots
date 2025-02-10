<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";
$database = "contact_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM contacts WHERE id=$id");
    header("Location: display.php");
}

// Handle UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    $conn->query("UPDATE contacts SET first_name='$first_name', last_name='$last_name', mobile='$mobile', email='$email' WHERE id=$id");
    header("Location: display.php");
}

// Fetch all contacts
$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List (CRUD)</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        .edit { background-color: orange; color: white; }
        .delete { background-color: red; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Manage Contacts</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['mobile'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <a href="display.php?edit=<?= $row['id'] ?>" class="btn edit">Edit</a>
                    <a href="display.php?delete=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // Edit Form Display
    if (isset($_GET['edit'])):
        $id = $_GET['edit'];
        $editResult = $conn->query("SELECT * FROM contacts WHERE id=$id");
        $contact = $editResult->fetch_assoc();
    ?>
        <h2 style="text-align:center;">Edit Contact</h2>
        <form method="POST" action="display.php" style="text-align:center;">
            <input type="hidden" name="id" value="<?= $contact['id'] ?>">
            <input type="text" name="first_name" value="<?= $contact['first_name'] ?>" required>
            <input type="text" name="last_name" value="<?= $contact['last_name'] ?>" required>
            <input type="text" name="mobile" value="<?= $contact['mobile'] ?>" required>
            <input type="email" name="email" value="<?= $contact['email'] ?>" required>
            <button type="submit" name="update">Update</button>
        </form>
    <?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>

