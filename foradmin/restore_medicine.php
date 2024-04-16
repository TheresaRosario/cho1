<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['archive_ids'])) {
        $archive_ids = $_POST['archive_ids'];
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
        foreach ($archive_ids as $archive_id) {
            // Prepare and execute restoration query
            $restore_query = "INSERT INTO medicines (Date,Item_Name, Batch_Number, Description, QTY, Manufacturing_Date, Expiration_Date)
                              SELECT Date, Item_Name, Batch_Number,  Description, QTY, Manufacturing_Date, Expiration_Date
                              FROM archived_medicines WHERE archive_id = ?";
            $stmt = $conn->prepare($restore_query);
            $stmt->bind_param("i", $archive_id);
            $stmt->execute();
            
            // Delete the restored records from archived_medicines table
            $delete_query = "DELETE FROM archived_medicines WHERE archive_id = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $archive_id);
            $stmt->execute();
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