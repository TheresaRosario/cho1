<?php
// Start session
session_start();

// Unset error message if it exists
unset($_SESSION['error_message']);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "choinventory";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to release medicine
function releaseMedicine($medicine_name, $release_quantity, $description, $batch_number, $manufacturing_date, $expiration_date, $issued_to, $conn) {
    if (!isset($medicine_name, $release_quantity, $description,  $batch_number, $manufacturing_date, $expiration_date, $issued_to)) {
        return "Missing required data.";
    }

    $stmt = $conn->prepare("SELECT medicine_id, QTY FROM medicines WHERE Item_Name = ?");
    $stmt->bind_param("s", $medicine_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $medicine_id = $row['medicine_id'];
        $current_quantity = $row['QTY'];

        if ($release_quantity > $current_quantity) {
            return "Insufficient quantity available";
        }
        
        $new_quantity = $current_quantity - $release_quantity;
        $update_stmt = $conn->prepare("UPDATE medicines SET QTY = ? WHERE medicine_id = ?");
        $update_stmt->bind_param("ii", $new_quantity, $medicine_id);
        if ($update_stmt->execute()) {
            $insert_stmt = $conn->prepare("INSERT INTO supply (date, item_name, batch_number, description, qty, manufacturing_date, expiration_date, issued_to, medicine_id) VALUES (CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("ssssisss", $medicine_name,  $batch_number, $description, $release_quantity, $manufacturing_date, $expiration_date, $issued_to, $medicine_id);
            
            
            if ($insert_stmt->execute()) {
                return "Success"; // Return success message
            } else {
                return "Error inserting transaction record: " . $insert_stmt->error;
            }
        } else {
            return "Error updating medicine quantity: " . $update_stmt->error;
        }
    } else {
        return "Medicine not found.";
    }
}

// Error message variable
$error_message = "";

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (!isset($_POST['date'], $_POST['itemName'],$_POST['batchNumber'], $_POST['description'], $_POST['qty'], $_POST['manufacturingDate'], $_POST['expirationDate'], $_POST['IssuedTo'])) {
        $error_message = "Missing required data.";
    } else {
        // Retrieve form data
        $date = $_POST['date'];
        $itemName = $_POST['itemName'];
      
        $batchNumber = $_POST['batchNumber'];
        $description = $_POST['description'];
        $qty = $_POST['qty'];
        $manufacturingDate = $_POST['manufacturingDate'];
        $expirationDate = $_POST['expirationDate'];
        $issuedTo = $_POST['IssuedTo'];

        // Call the function to release medicine
        $result = releaseMedicine($itemName, $qty, $description,  $batchNumber, $manufacturingDate, $expirationDate, $issuedTo, $conn);

        // Check result
        if ($result === "Success") {
            // Redirect to a different page to prevent form resubmission
            header("Location: Transaction.php");
            exit();
        } else {
            $error_message = $result; // Set error message if not successful
        }
    }
}

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar </title>
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
            margin-left: 200px;
            padding: 20px;
            padding-top: 10px; 
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

        .dashboard {
            display: flex;
            justify-content: center; /* Aligns the dashboard in the center */
            margin-top: 50px;
        }

        /* You can add more styles for additional boxes as needed */
        
        .round1 {
            width: 100%;
        }

        .header {
            position: fixed;
            top: 0;
            left: 200px; /* Adjusted to align with the sidebar */
            right: 0;
            background-color: #D9D9D9;
            padding: 4px;
            z-index: 1; /* Ensures the header is above the content */
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

        .button-container button {
            background-color: #498B31;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
        
            font-size: 16px;
          
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            width:500px;
        }

        .button-container button:hover {
            background-color: #3d6e26;
        }

        .form-box {
            margin-top: 20px;
            padding: 10px;
            background-color: #D9D9D9;
            border: 1px solid #ccc; 
            border-radius: 10px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .form-box label,
        .form-box input {
            display: inline-block; 
            width: auto; 
            margin-right: 50px; 
            margin-bottom: 10px;
        }

        .form-box button {
            display: block; /* Change the display to block */
            background-color: #A6C06F;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin-top: 30px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .form-box button:hover{
            background-color: #3d6e26;  
        }
        .container {
            width: 15%;
            margin: 20px auto;
            padding: 0px;
            background-color: #f4f4f4;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top:10px;
        }

        .error-message {
            background-color: #f44336;
            color: black;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align:center;
        }
        .footer-button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: block;
      width: 80%; /* Adjust width as needed */
      margin: 0 auto;
      font-size: 16px;
      margin-top: 20px; /* Adjust margin-top as needed */
      border-radius: 10px;
    }
    
    </style>
</head>
<script>
        // Function to hide "No record found" message
        function hideNoRecordMessage() {
            var noRecordRow = document.getElementById("noRecordRow");
            if (noRecordRow) {
                noRecordRow.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Call the function to hide the message initially
            hideNoRecordMessage();

            var searchInput = document.getElementById("searchInput");

            searchInput.addEventListener("input", function() {
                var searchText = this.value.trim().toLowerCase();
                var rows = document.querySelectorAll(".data-table tbody tr");
                var matchFound = false;

                rows.forEach(function(row) {
                    var itemName = row.querySelector("td:nth-child(3)").textContent.trim().toLowerCase();

                    if (itemName.includes(searchText)) {
                        row.style.display = "table-row";
                        matchFound = true;
                    } else {
                        row.style.display = "none";
                    }
                });

                // Toggle display of "No record found" message based on matchFound variable
                var noRecordRow = document.getElementById("noRecordRow");
                if (!matchFound) {
                    noRecordRow.style.display = "table-row";
                } else {
                    noRecordRow.style.display = "none";
                }
            });
        });
    </script>




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
        </ul>
        <footer style="background-color:#333; color:white; padding: 20px; text-align: center; margin-top:570px">
    <form action="logout.php" method="post">
        <input type="submit" value="Log Out" style="background-color: #498B31; color: white; border: none; padding: 10px 20px; cursor: pointer;">
    </form>
</footer>
    </div>

    <footer>
  <a href="your_other_page.html">
    <button class="footer-button">Your Footer Button</button>
  </a>
</footer>
    <div class="content">
    <div class="container">
        <?php if(!empty($error_message)): ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
        </div>
        <!-- Button Section -->
        <div class="button-container">
        <div style="display: flex; align-items: center;">
    <button id="addTransactionButton">ADD NEW TRANSACTION</button>
    <input type="text" id="searchInput" placeholder="Search by Item Name" style="margin-left: 60%; margin-top: 20px; padding:10px; width:23%">
</div>

</div>

<div class="form-box" style="display: none;">
            <form method="post" action="Transaction.php">
               
            <label for="date" style="">Date:</label>
                <input type="date" id="date" name="date" required placeholder="Date">
               
                <label for="itemName"style="margin-right:10px" >Item Name:</label>
                <input type="text" id="itemName" name="itemName" style="margin-left:0px"  required placeholder="Item Name">

                <label for="batchNumber"style="margin-right:10px">Batch/Lot Number:</label>
                <input type="text" id="batchNumber" name="batchNumber"  style="margin-left:10px" placeholder="Batch Number">

                <br>
                <label for="description" style=" margin-right:5px">Unit:</label>   
                <input type="text" id="description" name="description"style="margin-right: 5px" placeholder="Unit">

                <label for="qty" style="margin-left:25px">QTY:</label>
                <input type="text" id="qty" name="qty"style="margin-left:10px" placeholder="Quantity" >

                <label for="manufacturingDate"style="margin-left:10px">Manufacturing Date:</label>
                <input type="date" id="manufacturingDate" name="manufacturingDate" placeholder="Manufacturing Date">

                <label for="expirationDate"style="margin-right:20px">Expiration Date:</label>
                <input type="date" id="expirationDate" name="expirationDate"style="margin-left: 25px" placeholder="Expiration Date ">    

                <label for="issuedTo" style="margin-right: 21px" >Issued To:</label>
                <input type="text" id="issuedTo" name="IssuedTo"  style="margin-right: 5px"placeholder="Issued To " >
                <button type="submit">Add Transaction</button>
            </form>
        </div>

 
   <!-- Table Section -->
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
              
                <th style="color:white">Date.</th>
                <th style="color:white">Item Name</th>
                <th style="color:white">Batch/LotNumber</th> 
                <th style="color:white">Unit</th>
                <th style="color:white">QTY</th>
                <th style="color:white">Manufacturing Date</th>
                <th style="color:white">Expiration Date</th>
                <th style="color:white">Issued To</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
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
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                   
                        <td><?php echo $row["date"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["batch_number"]; ?></td>
                
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["qty"]; ?></td>
                        <td><?php echo $row["date_manufactured"]; ?></td>
                        <td><?php echo $row["expiration_date"]; ?></td>
                        <td><?php echo $row["issued_to"]; ?></td>
                        <!-- <td><button onclick="editSupply(<?php echo $row["supply_id"]; ?>)">Edit</button></td> -->
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr id="noRecordRow">
                    <td colspan="10" style="text-align: center;">No record found</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


    </script>

  
    <script>
    function editSupply(id) {
        // Redirect to the edit page with the supply ID
        window.location.href = 'editsupply.php?id=' + id;
    }

    document.getElementById("addTransactionButton").addEventListener("click", function() {
        var formBox = document.querySelector(".form-box");
        if (formBox.style.display === "none") {
            formBox.style.display = "block";
        } else {
            formBox.style.display = "none";
        }
    });
</script>
</body>
</html>
