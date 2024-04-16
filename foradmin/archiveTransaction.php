<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Records</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Select Records to Restore</h2>
    <form method="post">
        <table>
            <tr>
                <th>Select</th>
                <th>Supply ID</th>
                <th>Date</th>
                <th>Item Name</th>
                <th>Batch Number</th>
                <!-- Add more table headers as needed -->
            </tr>
            <?php
            // Fetch records from archived_supply table and display them in a table
            $servername = "localhost";
            $username = "root"; 
            $password = ""; 
            $dbname = "choinventory";   

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $select_sql = "SELECT * FROM archived_supply";
            $result = $conn->query($select_sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='restore_ids[]' value='" . $row['supply_id'] . "'></td>";
                    echo "<td>" . $row['supply_id'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['item_name'] . "</td>";
                    echo "<td>" . $row['batch_number'] . "</td>";
                    echo "<td>" . $row['Manufacturing_Date'] . "</td>";
                    echo "<td>" . $row['Expiration_Date'] . "</td>";
                         echo "<td>" . $row['Expiration_Date'] . "</td>";
                    // Add more table data cells as needed for other columns
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
        <button type="submit" name="restore_btn">Restore Selected Records</button>
    </form>

    <?php
    if(isset($_POST['restore_btn'])) {
        if(isset($_POST['restore_ids']) && is_array($_POST['restore_ids'])) {
            $ids = $_POST['restore_ids'];

            // Call the restore function for each selected ID
            foreach($ids as $id) {
                restoreMedicine($id);
            }
        } else {
            echo "No records selected for restoration.";
        }
    }

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
                    echo "Record with Supply ID $id restored successfully.<br>";
                } else {
                    echo "Error deleting record from archived_supply: " . $conn->error;
                }
            } else { 
                echo "Error restoring record to supply: " . $conn->error;
            }
        } else {
            echo "Record with Supply ID $id not found in archived_supply.<br>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
