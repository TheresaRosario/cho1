<?php

require_once 'fpdf/fpdf.php'; // Include TCPDF library

include_once 'database.php'; 

function generateReportPDF($date, $pdo) {
  
    $stmt = $pdo->prepare("SELECT * FROM supply WHERE manufacturing_date = :date");
    $stmt->execute(array(':date' => $date));

    $pdf = new FPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Report');
    $pdf->SetSubject('Report PDF');
    $pdf->SetKeywords('FPDF, PDF, report');

    $pdf->AddPage();

    $html = '<h1>Report</h1>';

    $html .= '<table border="1">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Issued To</th>
                    <th>Item Name</th>
                    <th>Batch Number</th>
                    <th>Lot Number</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Manufacturing Date</th>
                    <th>Expiration Date</th>
                </tr>
            </thead>
            <tbody>';

    $rowNum = 1;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       
        $manufacturing_date = date('m-d-Y', strtotime($row['manufacturing_date']));
        $expiration_date = date('m-d-Y', strtotime($row['expiration_date']));

        $html .= "<tr>
                    <td>{$rowNum}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['issued_to']}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['batch_number']}</td>
                    <td>{$row['lot_number']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['qty']}</td>
                    <td>{$manufacturing_date}</td>
                    <td>{$expiration_date}</td>
                </tr>";

        $rowNum++;
    }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('report.pdf', 'D'); // 'D' for force download

    exit;
}


if (isset($_GET['date'])) {
    
    $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
    $date = $_GET['date']; 
    
    generateReportPDF($date, $pdo);
} elseif (isset($_GET['generate_csv'])) {
    
    echo "Please select a date.";
}
?>
