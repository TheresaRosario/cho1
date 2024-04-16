<?php

include_once 'database.php'; 

function generateReportCSV($startDate, $endDate, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM Supply WHERE Date BETWEEN :startDate AND :endDate");
    $stmt->execute(array(':startDate' => $startDate, ':endDate' => $endDate));

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the fetched rows
    return $rows;
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        
        // Get the data from the database
        $reportData = generateReportCSV($startDate, $endDate, $pdo);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Please select a date range.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report</title>
    <!-- Remove unnecessary meta tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <style>
        
        /* Hide button when printing */
        @media print {
            button { display: none; }
        }
        
        @media print {
            @page {
                /* Set margin to 0 */
                margin: 0;
            }

            /* Hide header and footer */
             footer {
                display: none !important;
            }
        }

        table {
            width:  95%;
            border-collapse: collapse;
            margin-left:3%;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
        
        /* Header styles */
        header {
            color: black;
            text-align: center;
           
            font-weight: bold;
            font-size: 25px;
            margin-left:45%;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: top center;
        }

        .table-container {
            margin-top: 60px;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background-color: #498B31;
            color: #333;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Add background color to table header */
        table thead th {
            background-color: green; /* Change the color as needed */
            color: white;
        }
       /* Additional styles for the Print Report button */
/* Additional styles for the Print Report button */
.print-report-button {
    background-color: #007bff; /* Change the color as needed */
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 30px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.print-report-button:hover {
    background-color: #0056b3; /* Adjust hover effect if needed */
}

    </style>
    <script>
        function printReport() {
            // Hide the URL by removing it from the header
            document.querySelector('footer > link[rel="canonical"]').remove();
            // Trigger the print dialog
            window.print();
        }
    </script>
</head>
<body>
    <header style="font-size:15px;margin-right:35%;">
    <img src="logo.png" alt="Logo" style="width: 100px; height: auto; margin-right: 10px; vertical-align: middle;">
    <h5  style="margin-top: 0px;">SUPPLY REPORTS</h5>
</header>

<!-- Watermark (Logo) -->
<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; pointer-events: none; z-index: -1;">
    <img src="logo2.png" alt="Watermark Logo" style="width: 500px;">
    <h3>Tang inang Registrar yan</h2>

</div>

    <!-- Display the table with the fetched data -->
    <button style="width: auto; color:green; border: none; cursor: pointer; margin-left: 60px; margin-top: 10px; font-size: 30px;" onclick="window.location.href='Reports.php'">
     <span>&#8592;</span>
</button>

<div class="table-container" style="margin-top: 20px;">
    <table >
        <thead>
            <tr>
                
                <th>Date</th>
                <th>Item Name</th>
               
                <th>Batch/Lot Number</th>
                
                <th>Unit</th>
                <th>Qty</th>
                <th>MFG Date</th>
                <th>EXP Date</th>
                <th>Issued To</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportData as $index => $row): ?>
                <tr>
                    
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['item_name'] ?></td>
                    <td><?= $row['batch_number'] ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['manufacturing_date'] ?></td>
                    <td><?= $row['expiration_date'] ?></td>
                    <td><?= $row['issued_to'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </div>

    <!-- Button for printing -->
    
    <button style="width:10%; margin-left:88%; margin-top:50px; padding:10px; background-color: green; color:white;"onclick="window.print()">Print Report</button>

    <!-- Print date -->
    <!-- <p style="text-align: center; margin-top: 20px;">Printed on: <?= date('Y-m-d H:i:s') ?></p> -->
</body>
</html>
