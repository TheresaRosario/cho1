<?php
include_once 'database.php'; 

function generateReportCSV($start_date, $end_date, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM supply WHERE manufacturing_date >= :start_date AND expiration_date <= :end_date");
    $stmt->execute(array(':start_date' => $start_date, ':end_date' => $end_date));

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="report.csv"');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, array('date', 'item_name', 'batch_number', 'issued_to', 'lot_number', 'expiration_date', 'description', 'qty', 'manufacturing_date'));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $manufacturing_date = date('m-d-Y', strtotime($row['manufacturing_date']));
        $expiration_date = date('m-d-Y', strtotime($row['expiration_date']));

        fputcsv($output, array(
            $row['date'],
            $row['item_name'],
            $row['batch_number'],
            $row['issued_to'],
            $row['lot_number'],
            $expiration_date,
            $row['description'],
            $row['qty'],
            $manufacturing_date
        ));
    }

    fclose($output);
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
   
    generateReportCSV($start_date, $end_date, $pdo);
} else {
    echo "Please select start date and end date.";
}
?>
