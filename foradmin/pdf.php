<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
</head>
<body>
    <h1>Inventory Report</h1>
    <table id="inventoryTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Item Name</th>
                <th>Batch Number</th>
                <th>Issued To</th>
                <th>Lot Number</th>
                <th>Expiration Date</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Manufacturing Date</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated dynamically using JavaScript -->
        </tbody>
    </table>

    <button onclick="generatePDF()">Generate PDF</button>

    <script>
        // Function to generate PDF
        function generatePDF() {
            // Create a new instance of jsPDF
            const doc = new jsPDF();

            // Get data from the table
            const table = document.getElementById('inventoryTable');
            
            // Iterate through each row of the table and add cells to the PDF
            for (let i = 0; i < table.rows.length; i++) {
                for (let j = 0; j < table.rows[i].cells.length; j++) {
                    doc.cell(10, 10, 50, 50, table.rows[i].cells[j].innerText, i);
                }
            }

            // Save the PDF
            doc.save('inventory_report.pdf');
        }

        // Function to populate HTML table with data from PHP
        function populateTable(data) {
            const tableBody = document.querySelector('#inventoryTable tbody');
            tableBody.innerHTML = '';

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.date}</td>
                    <td>${item.item_name}</td>
                    <td>${item.batch_number}</td>
                    <td>${item.issued_to}</td>
                    <td>${item.lot_number}</td>
                    <td>${item.expiration_date}</td>
                    <td>${item.description}</td>
                    <td>${item.quantity}</td>
                    <td>${item.manufacturing_date}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Fetch data from PHP script
        fetch('generate_report.php')
            .then(response => response.json())
            .then(data => populateTable(data))
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>
</html>
