<?php
require_once('fpdf/pdf.php');

// Function to generate PDF from HTML
function generatePDF($html) {
    // Define TCPDF constants if not defined
    if (!defined('PDF_PAGE_ORIENTATION')) define('PDF_PAGE_ORIENTATION', 'P');
    if (!defined('PDF_UNIT')) define('PDF_UNIT', 'mm');
    if (!defined('PDF_PAGE_FORMAT')) define('PDF_PAGE_FORMAT', 'A4');
    if (!defined('PDF_MARGIN_LEFT')) define('PDF_MARGIN_LEFT', 15);
    if (!defined('PDF_MARGIN_RIGHT')) define('PDF_MARGIN_RIGHT', 15);
    if (!defined('PDF_MARGIN_TOP')) define('PDF_MARGIN_TOP', 15);
    if (!defined('PDF_MARGIN_BOTTOM')) define('PDF_MARGIN_BOTTOM', 15);
    if (!defined('PDF_FONT_NAME_MAIN')) define('PDF_FONT_NAME_MAIN', 'helvetica');
    if (!defined('PDF_FONT_SIZE_MAIN')) define('PDF_FONT_SIZE_MAIN', 10);
    
    $pdf = new FPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('PDF Report');
    $pdf->SetSubject('Report');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');

    // Return PDF as string
    return $pdf->Output('report.pdf', 'S');
}

// Your PHP code to fetch and filter data from the database goes here

// Generate HTML table with data
$html = '<table border="1">';
$html .= '<tr><th>No.</th><th>Date</th><th>Item Name</th><th>Batch Number</th><th>Lot Number</th><th>Description</th><th>QTY</th><th>Manufacturing Date</th><th>Expiration Date</th><th>Issued To</th></tr>';
// Add table rows dynamically with PHP based on your database records
$html .= '</table>';

// Generate PDF
$pdf_content = generatePDF($html);

// Send PDF content as response
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="report.pdf"');
echo $pdf_content;
