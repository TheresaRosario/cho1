<?php
function archiveMedicine($conn, $id) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $select_sql = "SELECT * FROM medicines WHERE medicine_id = $id";
    $result = $conn->query($select_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check for and delete related records in the 'supply' table first
        $delete_supply_sql = "DELETE FROM supply WHERE medicine_id = $id";
        if ($conn->query($delete_supply_sql) === FALSE) {
            return "Error deleting related supply records: " . $conn->error;
        }
        
        // Log deletion of related supply records
        $supply_log_sql = "INSERT INTO logs (id, action, date_time) VALUES (NULL, 'admin supply record deletion', NOW())";
        if ($conn->query($supply_log_sql) === FALSE) {
            return "Error inserting supply deletion log: " . $conn->error;
        }

        // Archive the medicine
        $archive_sql = "INSERT INTO archived_medicines (Date, Item_Name, batch_number, Description, QTY, Manufacturing_Date, Expiration_Date) 
        VALUES ('{$row['Date']}', '{$row['Item_Name']}', '{$row['batch_number']}', '{$row['Description']}', '{$row['QTY']}', '{$row['Manufacturing_Date']}', '{$row['Expiration_Date']}')";

        if ($conn->query($archive_sql) === TRUE) {
            // Log archiving of the medicine
            $archive_log_sql = "INSERT INTO logs (id, action, date_time) VALUES (NULL, 'admin medicine archive', NOW())";
            if ($conn->query($archive_log_sql) === FALSE) {
                return "Error inserting archive log: " . $conn->error;
            }
            
            // Now that related records are deleted, delete the medicine
            $delete_sql = "DELETE FROM medicines WHERE medicine_id = $id";
            if ($conn->query($delete_sql) === TRUE) {
                // Log deletion of the medicine
                $delete_log_sql = "INSERT INTO logs (id, action, date_time) VALUES (NULL, 'admin medicine deletion', NOW())";
                if ($conn->query($delete_log_sql) === FALSE) {
                    return "Error inserting medicine deletion log: " . $conn->error;
                }
                
                return true;
            } else {
                return "Error deleting medicine: " . $conn->error;
            }
        } else { 
            return "Error archiving medicine: " . $conn->error;
        }
    } else {
        return "Record not found.";
    }
}

// Establish database connection
$conn = new mysqli("localhost", "root", "", "choinventory");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $result = archiveMedicine($conn, $id);
    if ($result === true) {
        header("Location: Supply.php");
        exit();
    } else {
        echo $result; 
    }
}
?>
