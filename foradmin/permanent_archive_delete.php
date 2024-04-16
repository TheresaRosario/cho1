<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteByDateRange'])) {
    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        
     
        deleteItemsByDateRange($startDate, $endDate);
    } else {
        echo "Start date or end date not provided.";
    }
}

function deleteItemsByDateRange($startDate, $endDate) {
    $servername = "localhost";
    $dbname = "choinventory";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "DELETE FROM archived_medicines WHERE Date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);


    $stmt->bind_param("ss", $startDate, $endDate);

    if ($stmt->execute()) {
        echo "Items deleted successfully within the date range $startDate to $endDate.";
        // Redirect to medicine_store.php
        header("Location: CHOsystem1/forencoder/medicine_store.php");
        exit();
    } else {
        echo "Error deleting items: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
