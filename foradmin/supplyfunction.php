<?php
$success_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    
    $sql_insert = "INSERT INTO medicines (date, item_name, batch_number, description, qty, Manufacturing_Date, Expiration_Date)
            VALUES ('$date', '$itemName', '$batchNumber', '$description', '$qty', '$manufacturingDate', '$expirationDate')";

    if ($conn->query($sql_insert) === TRUE) {
  
        $success_message = "New record created successfully";

        
        $sql_log = "INSERT INTO logs (id, action, date_time) VALUES (NULL, 'admin supply record insert', NOW())";
        

        $conn->query($sql_log);
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
    
    $conn->close();
}


header("Location: Supply.php");
exit();
?>
