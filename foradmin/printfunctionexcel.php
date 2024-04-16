<?php

include_once 'database.php'; 


function generateReportCSV($date, $pdo) {
  
    $stmt = $pdo->prepare("SELECT * FROM supply WHERE manufacturing_date = :date");
    $stmt->execute(array(':date' => $date));

  
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="report.csv"');
    
 
    $output = fopen('php://output', 'w');
    
    
    fputcsv($output, array('No.', 'Date', 'Issued To', 'Item Name', 'Batch Number', 'Lot Number', 'Description', 'Qty', 'Manufacturing Date', 'Expiration Date'));


    $rowNum = 1;


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $manufacturing_date = date('m-d-Y', strtotime($row['Date']))
        $manufacturing_date = date('m-d-Y', strtotime($row['manufacturing_date']));
        $expiration_date = date('m-d-Y', strtotime($row['expiration_date']));

        fputcsv($output, array(
            $rowNum++,
            $row['date'],
            $row['issued_to'],
            $row['item_name'],
            $row['batch_number'],
            $row['lot_number'],
            $row['description'],
            $row['qty'],
            $manufacturing_date, 
            $expiration_date 
        ));
    }


    fclose($output);
}


if (isset($_GET['date'])) {
    
    $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
    $date = $_GET['date']; 
    
   
    generateReportCSV($date, $pdo);
} elseif (isset($_GET['generate_csv'])) {
    
    echo "Please select a date.";
}
?>
