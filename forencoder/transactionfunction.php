<?php
// Start session
session_start();

// Unset error message if it exists
unset($_SESSION['error_message']);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "choinventory";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to release medicine
function releaseMedicine($medicine_name, $release_quantity, $description, $lot_number, $batch_number, $manufacturing_date, $expiration_date, $issued_to, $conn) {
    if (!isset($medicine_name, $release_quantity, $description, $lot_number, $batch_number, $manufacturing_date, $expiration_date, $issued_to)) {
        return "Missing required data.";
    }

    $stmt = $conn->prepare("SELECT medicine_id, QTY FROM medicines WHERE Item_Name = ?");
    $stmt->bind_param("s", $medicine_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $medicine_id = $row['medicine_id'];
        $current_quantity = $row['QTY'];

        if ($release_quantity > $current_quantity) {
            $_SESSION['error_message'] = "Insufficient quantity available";
            header("Location: Transaction.php");
            exit();
        }
        
        $new_quantity = $current_quantity - $release_quantity;
        $update_stmt = $conn->prepare("UPDATE medicines SET QTY = ? WHERE medicine_id = ?");
        $update_stmt->bind_param("ii", $new_quantity, $medicine_id);
        if ($update_stmt->execute()) {
            $insert_stmt = $conn->prepare("INSERT INTO supply (date, item_name, lot_number, batch_number, description, qty, manufacturing_date, expiration_date, issued_to, medicine_id) VALUES (CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("ssssissss", $medicine_name, $lot_number, $batch_number, $description, $release_quantity, $manufacturing_date, $expiration_date, $issued_to, $medicine_id);
            
            if ($insert_stmt->execute()) {
                // Redirect to Transaction page after successful insert
                header("Location: Transaction.php");
                exit(); // Ensure that no other code is executed after redirection
            } else {
                return "Error inserting transaction record: " . $insert_stmt->error;
            }
        } else {
            return "Error updating medicine quantity: " . $update_stmt->error;
        }
    } else {
        return "Medicine not found.";
    }
}

$error_message = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are provided
    if (!isset($_POST['Item_Name'], $_POST['Lot_Number'], $_POST['Batch_Number'], $_POST['Description'], $_POST['QTY'], $_POST['Mfg_Date'], $_POST['Exp_Date'], $_POST['IssuedTo'])) {
        $error_message = "Missing required data.";
    } else {
        // Retrieve form data
        $medicine_name = $_POST['Item_Name'];
        $lot_number = $_POST['Lot_Number'];
        $batch_number = $_POST['Batch_Number'];
        $description = $_POST['Description'];
        $release_quantity = $_POST['QTY'];
        $manufacturing_date = $_POST['Mfg_Date'];
        $expiration_date = $_POST['Exp_Date'];
        $issued_to = $_POST['IssuedTo'];

        // Call the function to release medicine
        $result = releaseMedicine($medicine_name, $release_quantity, $description, $lot_number, $batch_number, $manufacturing_date, $expiration_date, $issued_to, $conn);

        // Check if the result is a string, indicating an error message
        if (is_string($result)) {
            $error_message = $result;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!-- HTML and CSS code continues... -->
