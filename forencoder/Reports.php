<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
 
   
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"> -->


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 200px;
            background-color: #2B4921;
            color: #14e630;
        }

        .sidebar header {
            background-color: white;
            padding: 20px;
            text-align: center;
        }

        .sidebar h2 {
            margin: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
            margin-left: 50px;
            font-style: arial;
        }


        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px; 
        }

        .text {
            background-color: #498B31;
            padding: 100px;
            text-align: center;
        }

        .logo {
            text-align: left;
        }

        .logo img {
            max-width: 100px;
            height: 80px;
        }

        .wrap-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            margin-left:10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="submit"] {
            background-color: #498B31;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left:12px;
        }

        .form-container input[type="date"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            margin-left:10px;
        }

        .form-container input[type="submit"] {
            margin-top: 10px;
        }

        .round1 {
            width: 100%;
        }

        .header {
            position: fixed;
            top: 0;
            left: 200px; /* Adjusted to align with the sidebar */
            right: 0;
            background-color: #D9D9D9;
            padding: 5px;
            z-index: 1; /* Ensures the header is above the content */
        }

        .table-container {
            margin-top: 20px;
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

        .form-container input[type="submit"] {
            background-color: #428f26;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 266px;
        }
    </style>
</head>
<body>
<div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 5px;">
    <div class="logo">
        <img src="logo.png" alt="Logo">
    </div>
    <!-- <a href="FRONT.PHP" style="color: #2B4921; text-decoration: underline; margin-right: 100px; font-weight: bold; text-transform: uppercase;">GO BACK TO FRONT PAGE</a> -->
</div>
    <div class="sidebar">
        <header style="background-color:#498B31; ">
            <h2 style="color:white">INVENTORY SYSTEM</h2>
        </header>
   
        <!-- <hr class="round"></hr> -->
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <hr class="round"></hr>
            <li><a href="Supply.php">Supply</a></li>
            <hr class="round"></hr>
            <li><a href="Transaction.php">Transaction</a></li>
            <hr class="round"></hr>
            <li><a href="Reports.php">Reports</a></li>
            <hr class="round"></hr>
            <!-- <li><a href="Register.php">Account</a></li>
            <hr class="round"></hr> -->
           
            <footer style="background-color:#333; color:white; padding: 20px; text-align: center; margin-top:570px">
    <form action="logout.php" method="post">
        <input type="submit" value="Log Out" style="background-color: #498B31; color: white; border: none; padding: 10px 20px; cursor: pointer;">
    </form>
</footer>
        </ul>
    </div>
    <div class="content">
        <div class="wrap-form">
            <div class="form-container">


                <form method="get" action="printfunction.php">
                    <label for="start_date" style="margin-left:100px">Date Range</label>
                    <input type="date" id="start_date" style=margin-left:10px; name="start_date" >
                    <input type="date" id="end_date" name="end_date">
                    <input type="submit" name="generate_csv">
                </form>

            </div>
        </div>

        <script>
            // Add this script to customize the date input fields
            document.addEventListener("DOMContentLoaded", function() {
                const startDateInput = document.getElementById("start_date");
                const endDateInput = document.getElementById("end_date");
                
                // Set the minimum date for end date input to be the same as start date
                startDateInput.addEventListener("change", function() {
                    endDateInput.min = startDateInput.value;
                });
            });
        </script>

        <div class="table-container" id="tableContainer" style="display: none;">
            <button id="backButton">Back</button> <!-- Back button added here -->
            <table class="data-table" id="reportTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>issued_to</th>
                        <th>Item Name</th>
                        <th>Branch Number</th>
                        <th>Lot Number</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Manufacturing Date</th>
                        <th>Expiration Date</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const reportForm = document.getElementById("report-form");

            reportForm.addEventListener("submit", function(event) {
                event.preventDefault();

                const startDate = document.getElementById("start_date").value;
                const endDate = document.getElementById("end_date").value;

                window.location.href = `generate_report.php?start_date=${startDate}&end_date=${endDate}`;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const reportForm = document.getElementById("report-form");
            const tableContainer = document.getElementById("tableContainer");
            const reportTableBody = document.getElementById("reportTableBody");
            const backButton = document.getElementById("backButton");

            reportForm.addEventListener("submit", function(event) {
                event.preventDefault();

                reportTableBody.innerHTML = "";
                tableContainer.style.display = "block";
                reportForm.style.display = "none";
            });

            // Add event listener to back button
            backButton.addEventListener("click", function() {
                // Show the form container and hide the table container
                reportForm.style.display = "block";
                tableContainer.style.display = "none";
            });
        });
    </script>

</body>
</html>
