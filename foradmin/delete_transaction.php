<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "choinventory";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if supply ID is provided
if(isset($_POST['id'])) {
    $supply_id = $_POST['id'];

    // Prepare and execute SQL statement to delete the transaction
    $delete_stmt = $conn->prepare("DELETE FROM supply WHERE supply_id = ?");
    $delete_stmt->bind_param("i", $supply_id);

    if ($delete_stmt->execute()) {
        // Redirect back to the transaction page after deletion
        header("Location: Transaction.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting transaction: " . $delete_stmt->error;
    }
}

// Close database connection
$conn->close();
?>
