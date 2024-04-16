<?php
// Assume you have a database connection established already
$servername = "localhost"; // Ang pangalan ng iyong database server
$username = "root"; // Ang username para sa database
$password = ""; // Ang password para sa database
$dbname = "choinventory"; // Ang pangalan ng iyong database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID parameter is set and numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Sanitize the ID to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch supply data based on the ID
    $sql = "SELECT * FROM medicines WHERE medicine_id = $id";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if ($result) {
        // Check if at least one row is returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the supply data
            $row = mysqli_fetch_assoc($result);

            // Convert the data to JSON format
            $supplyData = array(
                'Date' => $row['Date'],
                'Item_Name' => $row['Item_Name'],
                'Batch_Number' => $row['Batch_Number'],
                'Description' => $row['Description'],
                'QTY' => $row['QTY'],
                'Mfg_Date' => $row['Mfg_Date'],
                'Exp_Date' => $row['Exp_Date']
            );

            // Return the supply data as JSON
            header('Content-Type: application/json');
            echo json_encode($supplyData);
        } else {
            // Return an empty object if no data found
            echo json_encode(new stdClass());
        }
    } else {
        // Return an error message if query fails
        echo json_encode(array('error' => 'Failed to fetch supply data: ' . mysqli_error($conn)));
    }
} else {
    // Return an error message if ID parameter is missing or invalid
    echo json_encode(array('error' => 'Invalid ID parameter'));
}

// Close the database connection
$conn->close();
?>
