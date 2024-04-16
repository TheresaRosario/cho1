<?php
include 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editSupply'])) {
  
    $id = $_POST['edit_id'];
    $date = mysqli_real_escape_string($conn, $_POST['edit_date']);
    $itemName = mysqli_real_escape_string($conn, $_POST['edit_itemName']);
    $batchNumber = mysqli_real_escape_string($conn, $_POST['edit_batchNumber']);
    
    $description = mysqli_real_escape_string($conn, $_POST['edit_description']);
    $qty = mysqli_real_escape_string($conn, $_POST['edit_qty']);
    $manufacturingDate = mysqli_real_escape_string($conn, $_POST['edit_manufacturingDate']);
    $expirationDate = mysqli_real_escape_string($conn, $_POST['edit_expirationDate']);

    $update_query = "UPDATE medicines SET date='$date', item_name='$itemName', batch_number='$batchNumber',  description='$description', qty='$qty', manufacturing_date='$manufacturingDate', expiration_date='$expirationDate' WHERE medicine_id='$id'";

    if ($conn->query($update_query) === TRUE) {
  
        $success_message = "Record updated successfully";

        $sql_log = "INSERT INTO logs (id, action, date_time) VALUES (NULL, 'admin supply record update', NOW())";

        if ($conn->query($sql_log) === TRUE) {
            $success_message .= " and log inserted successfully.";
        } else {
            echo "Error inserting log: " . $conn->error;
        }
    } else {
        echo "Error updating supply: " . $conn->error;
    }
}

header("Location: Supply.php");
exit();
?>
