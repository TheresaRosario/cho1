<?php
function deleteArchivedRecords($archive_ids) {
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

    // Loop through each archive ID for deletion
    foreach ($archive_ids as $archive_id) {
        // Prepare and execute deletion query
        $delete_query = "DELETE FROM archived_medicines WHERE archive_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $archive_id);
        $stmt->execute();

        // Check if deletion was successful
        if ($stmt->affected_rows > 0) {
            echo "Record with Archive ID $archive_id permanently deleted.<br>";
        } else {
            echo "Error deleting record with Archive ID $archive_id.<br>";
        }
    }

    // Close connection
    $conn->close();
}
?>
