<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print to PDF</title>
</head>
<body>
    <button onclick="printToPDF()">Print to PDF</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function printToPDF() {
            // Make an AJAX request to your server-side script (printdb.php) to fetch the data from MySQL database
            fetch('printdb.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Once data is fetched, create a PDF
                    createPDF(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function createPDF(data) {
            // Here you would use a library like jsPDF to create the PDF
            // Example:
            var doc = new jsPDF();
            
            // Add data to the PDF
            doc.text(20, 20, 'Inventory Data:');
            data.forEach((row, index) => {
                let yPos = 30 + index * 10;
                doc.text(20, yPos, `Date: ${row.date}`);
                doc.text(50, yPos, `Item Name: ${row.item_name}`);
                doc.text(100, yPos, `Batch Number: ${row.batch_number}`);
                doc.text(150, yPos, `Issued To: ${row.issued_to}`);
                doc.text(200, yPos, `Lot Number: ${row.lot_number}`);
                doc.text(250, yPos, `Expiration Date: ${row.expiration_date}`);
                doc.text(320, yPos, `Description: ${row.description}`);
                doc.text(400, yPos, `Qty: ${row.qty}`);
                doc.text(430, yPos, `Manufacturing Date: ${row.manufacturing_date}`);
            });
            
            // Save the PDF
            doc.save('inventory.pdf');
        }
    </script>
</body>
</html>
