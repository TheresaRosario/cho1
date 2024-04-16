<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create PDF Report</title>
</head>
<body>
    <h2>Create PDF Report</h2>
    <form id="filterForm">
        <label for="mfg_date">Manufacturing Date:</label><br>
        <input type="date" id="mfg_date" name="mfg_date"><br><br>
        <label for="exp_date">Expiration Date:</label><br>
        <input type="date" id="exp_date" name="exp_date"><br><br>
        <button type="submit">Generate PDF Report</button>
    </form>

    <!-- Table Section -->
    <div class="table-container" id="tableContainer">
        <!-- Table will be populated dynamically here -->
        <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "choinventory";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the supply table
            $sql = "SELECT * FROM supply";
            $result = $conn->query($sql);

            // Output data of each row
            if ($result->num_rows > 0) {
                echo '<table class="data-table">';
                echo '<thead><tr><th>No.</th><th>Date.</th><th>Item Name</th><th>Batch Number</th><th>Lot Number</th><th>Description</th><th>QTY</th><th>Manufacturing Date</th><th>Expiration Date</th><th>Issued To</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["supply_id"] . '</td>';
                    echo '<td>' . $row["date"] . '</td>';
                    echo '<td>' . $row["item_name"] . '</td>';
                    echo '<td>' . $row["batch_number"] . '</td>';
                    echo '<td>' . $row["lot_number"] . '</td>';
                    echo '<td>' . $row["description"] . '</td>';
                    echo '<td>' . $row["qty"] . '</td>';
                    echo '<td>' . $row["manufacturing_date"] . '</td>';
                    echo '<td>' . $row["expiration_date"] . '</td>';
                    echo '<td>' . $row["issued_to"] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                // No records found
                echo '<p>No record found</p>';
            }

            $conn->close();
        ?>
    </div>

    <script>
        document.getElementById("filterForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission
            
            var formData = new FormData(this);
            fetch('functionreport.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("tableContainer").innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
