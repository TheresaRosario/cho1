<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Record</title>
</head>
<body>
    <form method="post">
        <label for="supply_id">Supply ID:</label>
        <input type="text" id="supply_id" name="supply_id">
        <button type="submit" name="restore_btn">Restore</button>
    </form>

    <?php
    // Include the restoreMedicine() function here
    function restoreMedicine($id) {
        $servername = "localhost";
        $username = "root"; 
        $password = ""; 
        $dbname = "choinventory";   

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Select record from archived_supply
        $select_sql = "SELECT * FROM archived_supply WHERE supply_id = $id";
        $result = $conn->query($select_sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Insert the record back into the supply table
            $insert_sql = "INSERT INTO supply (supply_id, Date, Item_Name, Batch_Number, Description, QTY, Manufacturing_Date, Expiration_Date, issued_to, medicine_id) 
                            VALUES ('{$row['supply_id']}','{$row['Date']}', '{$row['Item_Name']}', '{$row['Batch_Number']}', '{$row['Description']}', '{$row['QTY']}', '{$row['Manufacturing_Date']}', '{$row['Expiration_Date']}', '{$row['issued_to']}','{$row['medicine_id']}')";

            if ($conn->query($insert_sql) === TRUE) {
                // Delete the record from archived_supply
                $delete_sql = "DELETE FROM archived_supply WHERE supply_id = $id";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "Record restored successfully.";
                } else {
                    echo "Error deleting record from archived_supply: " . $conn->error;
                }
            } else { 
                echo "Error restoring record to supply: " . $conn->error;
            }
        } else {
            echo "Record not found in archived_supply.";
        }

        $conn->close();
    }

    if(isset($_POST['restore_btn'])) {
        // Check if supply_id is provided
        if(isset($_POST['supply_id'])) {
            $id = $_POST['supply_id'];
            
            // Call the restore function
            restoreMedicine($id);
        } else {
            echo "Supply ID is required.";
        }
    }
    ?>
</body>
</html