<?php
function archiveMedicine($id) {
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "choinventory";   

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $select_sql = "SELECT * FROM medicines WHERE medicine_id = $id";
    $result = $conn->query($select_sql);
    if ($result->num_rows > 0) {
      
        $row = $result->fetch_assoc();
        
        $archive_sql = "INSERT INTO archived_medicines (Date, Item_Name, Batch_Number, Description, QTY, Mfg_Date, Exp_Date) 
        VALUES ('{$row['Date']}', '{$row['Item_Name']}', '{$row['Batch_Number']}', '{$row['Description']}', '{$row['QTY']}', '{$row['Mfg_Date']}', '{$row['Exp_Date']}')";

        if ($conn->query($archive_sql) === TRUE) {
        
            $delete_sql = "DELETE FROM medicines WHERE medicine_id = $id";
            if ($conn->query($delete_sql) === TRUE) {
             
                return true;
            } else {
                return "Error deleting supply: " . $conn->error;
            }
        } else {
            return "Error archiving supply: " . $conn->error;
        }
    } else {
        return "Record not found.";
    }

    $conn->close();
}


$id = $_POST['id'];
$result = archiveMedicine($id);
if ($result === true) {
    header("Location: Supply.php");
    exit();
} else {
    echo $result; 
}
?>
