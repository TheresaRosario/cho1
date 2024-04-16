<?php
include 'database.php'; // Make sure the file path is correct

// Check if the form for editing supply has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editSupply'])) {
    // Clean and retrieve form data
    $id = $_POST['edit_id'];
    $date = mysqli_real_escape_string($conn, $_POST['edit_date']);
    $itemName = mysqli_real_escape_string($conn, $_POST['edit_itemName']);
    $batchNumber = mysqli_real_escape_string($conn, $_POST['edit_batchNumber']);
    $lotNumber = mysqli_real_escape_string($conn, $_POST['edit_lotNumber']);
    $description = mysqli_real_escape_string($conn, $_POST['edit_description']);
    $qty = mysqli_real_escape_string($conn, $_POST['edit_qty']);
    $manufacturingDate = mysqli_real_escape_string($conn, $_POST['edit_manufacturingDate']);
    $expirationDate = mysqli_real_escape_string($conn, $_POST['edit_expirationDate']);

    // Update supply in the database
    $update_query = "UPDATE medicines SET date='$date', item_name='$itemName', batch_number='$batchNumber', lot_number='$lotNumber', description='$description', qty='$qty', manufacturing_date='$manufacturingDate', expiration_date='$expirationDate' WHERE medicine_id='$id'";

    if (mysqli_query($conn, $update_query)) {
        // Redirect to prevent form resubmission on page refresh
        header("Location: Supply.php");
        exit();
    } else {
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
    }
}
?>
