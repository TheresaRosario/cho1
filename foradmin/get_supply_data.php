<?php
include 'database.php';

// Check if ID is provided via GET request
if(isset($_GET['id'])) {
    // Sanitize the ID
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to select supply details by ID
    $query = "SELECT * FROM supply_table WHERE id = $id";

    // Execute query
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if($result) {
        // Fetch supply data as an associative array
        $supply_data = mysqli_fetch_assoc($result);

        // Check if supply data is not null
        if($supply_data) {
            // Return supply data as JSON
            echo json_encode($supply_data);
        } else {
            echo "Supply not found.";
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo "Error fetching supply details: " . mysqli_error($conn); // Display any error in fetching data from database
    }
} else {
    echo "No supply ID provided.";
}
?>
