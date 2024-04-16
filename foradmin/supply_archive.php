<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['supply_ids'])) {
        $archive_ids = $_POST['supply_ids'];
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "choinventory";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }       

        // Loop through each archive ID for restoration
        foreach ($supply_ids as $supply_id) {
            // Prepare and execute restoration query
            $restore_query = "INSERT INTO supply (supply_id, date, item_name, batch_number, description, qty, manufacturing_date, expiration_date, issued_to)
                              SELECT supply_id, date, item_name, batch_number, description, qty, manufacturing_date, expiration_date, issued_to
                              FROM archived_supply WHERE supply_id = ?";
            $stmt_restore = $conn->prepare($restore_query);
            $stmt_restore->bind_param("i", $supply_id);
            $stmt_restore->execute();
            
            // Delete the restored records from archived_medicines table
            $delete_query = "DELETE FROM archived_supply WHERE supply_id = ?";
            $stmt_delete = $conn->prepare($delete_query);
            $stmt_delete->bind_param("i", $archive_id);
            $stmt_delete->execute();
        }

        // Close connection
        $conn->close();

        // Redirect to Supply.php after restoration
        header("Location: Supply.php");
        exit();
    } else {
        echo "No archive IDs provided.";
    }
} else {
    echo "Invalid request.";
}
?>
