<?php
function releaseMedicine($supply_id, $Date, $item_name, $batch_number, $date_manufactured, $expired_date, $issued_to, $conn) {
    // Implement your releaseMedicine() function logic here
}

function archiveMedicine($id) {
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "test";   

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $select_sql = "SELECT * FROM supply WHERE supply_id = $id";
    $result = $conn->query($select_sql);
    if ($result->num_rows > 0) {
      
        $row = $result->fetch_assoc();
        
        // Check if the record already exists in archived_supply table
        $existing_record_sql = "SELECT * FROM archived_supply WHERE supply_id = '{$row['supply_id']}'";
        $existing_record_result = $conn->query($existing_record_sql);
        if ($existing_record_result->num_rows == 0) {
            $archive_sql = "INSERT INTO archived_supply (supply_id, Date, item_name, batch_number, description, qty, date_manufactured, expired_date, issued_to) 
            VALUES ('{$row['supply_id']}','{$row['Date']}', '{$row['item_name']}', '{$row['batch_number']}', '{$row['description']}', '{$row['qty']}', '{$row['date_manufactured']}', '{$row['expired_date']}', '{$row['issued_to']}')";

            if ($conn->query($archive_sql) === TRUE) {
                $delete_sql = "DELETE FROM supply WHERE supply_id = $id";
                if ($conn->query($delete_sql) === TRUE) {
                    // Deletion successful, return true
                    return true;
                } else {
                    // Error deleting supply
                    return "Error deleting supply: " . $conn->error;
                }
            } else { 
                // Error archiving supply
                return "Error archiving supply: " . $conn->error;
            }
        } else {
            // Record already exists in archived_supply table, no action needed
        }
    } else {
        // Record not found
        return "Record not found.";
    }

    $conn->close();
}

$id = $_POST['id'];
$result = archiveMedicine($id);
if ($result === true) {
    header("Location: Transaction.php");
    exit();
} else {
    echo $result; 
}
?>
