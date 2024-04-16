<?php
include 'database.php'; // Siguraduhing tama ang path ng file

// Suriin kung ang form para sa pag-e-edit ng supply ay naipasa na
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editSupply'])) {
    // Linisin at kunin ang data mula sa form
    $date = mysqli_real_escape_string($conn, $_POST['edit_date']);
    $itemName = mysqli_real_escape_string($conn, $_POST['edit_itemName']);
    $batchNumber = mysqli_real_escape_string($conn, $_POST['edit_batchNumber']);
    $description = mysqli_real_escape_string($conn, $_POST['edit_description']);
    $qty = mysqli_real_escape_string($conn, $_POST['edit_qty']);
    $manufacturingDate = mysqli_real_escape_string($conn, $_POST['edit_manufacturingDate']);
    $expirationDate = mysqli_real_escape_string($conn, $_POST['edit_expirationDate']);
    $issuedTo = mysqli_real_escape_string($conn, $_POST['edit_issuedTo']);
    $medicineId = mysqli_real_escape_string($conn, $_POST['edit_medicineID']); 

    // I-update ang supply sa database
    $update_query = "UPDATE supply SET date='$date', item_name='$itemName', batch_number='$batchNumber', description='$description', qty='$qty', manufacturing_date='$manufacturingDate', expiration_date='$expirationDate', issued_to='$issuedTo' WHERE medicine_id='$medicineId'";

    if (mysqli_query($conn, $update_query)) {
        // I-redirect upang maiwasan ang resubmission ng form sa page refresh
        header("Location: Transaction.php");
        exit();
    } else {
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
    }
}
?>
