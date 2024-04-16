<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate CSV Report</title>
</head>
<body>
    <h2>Generate CSV Report</h2>
    <form action="generate_report.php" method="GET">
        <label for="start_date">Start Date (Manufacturing Date):</label>
        <select id="start_date" name="start_date" required>
            <?php
            include_once 'database.php';

            // Fetch unique manufacturing dates from the database
            $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
            $stmt = $pdo->query("SELECT DISTINCT manufacturing_date FROM supply ORDER BY manufacturing_date ASC");

            // Populate select options with fetched manufacturing dates
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['manufacturing_date']}\">{$row['manufacturing_date']}</option>";
            }
            ?>
        </select>
        <label for="end_date">End Date (Expiration Date):</label>
        <select id="end_date" name="end_date" required>
            <?php
            // Re-fetch unique expiration dates from the database to ensure consistency
            $stmt = $pdo->query("SELECT DISTINCT expiration_date FROM supply ORDER BY expiration_date ASC");

            // Populate select options with fetched expiration dates
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['expiration_date']}\">{$row['expiration_date']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="generate_csv">Generate CSV Report</button>
    </form>

    <?php
    // Check if start and end dates are set
    if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
       
        generateReportHTML($start_date, $end_date, $pdo);
        echo "<br><a href=\"generate_report.php?start_date={$start_date}&end_date={$end_date}&generate_csv\">Download CSV Report</a>";
    } else {
        echo "Please select start date and end date.";
    }
    ?>
</body>
</html>

<?php
include_once 'database.php'; 

function generateReportHTML($start_date, $end_date, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM supply WHERE manufacturing_date >= :start_date AND expiration_date <= :end_date");
    $stmt->execute(array(':start_date' => $start_date, ':end_date' => $end_date));

    echo "<h2>Report Preview</h2>";
    echo "<table border='1'>";
    echo "<tr><th>No.</th><th>Date</th><th>Issued To</th><th>Item Name</th><th>Batch Number</th><th>Lot Number</th><th>Description</th><th>Qty</th><th>Manufacturing Date</th><th>Expiration Date</th></tr>";

    $rowNum = 1;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $manufacturing_date = date('m-d-Y', strtotime($row['manufacturing_date']));
        $expiration_date = date('m-d-Y', strtotime($row['expiration_date']));

        echo "<tr>";
        echo "<td>{$rowNum}</td>";
        echo "<td>{$row['date']}</td>";
        echo "<td>{$row['issued_to']}</td>";
        echo "<td>{$row['item_name']}</td>";
        echo "<td>{$row['batch_number']}</td>";
        echo "<td>{$row['lot_number']}</td>";
        echo "<td>{$row['description']}</td>";
        echo "<td>{$row['qty']}</td>";
        echo "<td>{$manufacturing_date}</td>";
        echo "<td>{$expiration_date}</td>";
        echo "</tr>";
        
        $rowNum++;
    }

    echo "</table>";
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
   
    generateReportHTML($start_date, $end_date, $pdo);
    echo "<br><a href=\"generate_report.php?start_date={$start_date}&end_date={$end_date}&generate_csv\">Download CSV Report</a>";
} else {
    echo "Please select start date and end date.";
}
?>

