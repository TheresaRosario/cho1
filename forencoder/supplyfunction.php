<?php
// Initialize $success_message variable
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "choinventory";  
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $date = $_POST["date"];
    $itemName = $_POST["itemName"];
    $batchNumber = $_POST["batchNumber"];
   
    $description = $_POST["description"];
    $qty = $_POST["qty"];
    $manufacturingDate = $_POST["manufacturingDate"];
    $expirationDate = $_POST["expirationDate"];

    $sql = "INSERT INTO medicines (date, item_name, batch_number, description, qty, mfg_date, exp_date)
            VALUES ('$date', '$itemName', '$batchNumber','$description', '$qty', '$manufacturingDate', '$expirationDate')";

    if ($conn->query($sql) === TRUE) {
        // Set success message
        $success_message = "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

// Redirect only after handling the form submission
// Redirect to same page to prevent redirect loop
header("Location: Supply.php");
exit();
?>
