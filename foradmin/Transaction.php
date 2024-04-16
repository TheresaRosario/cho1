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
function releaseMedicine($Date, $itemName, $qty, $description, $batchNumber, $manufacturingDate, $expirationDate, $issuedTo, $conn) {
    if (!isset($Date, $itemName, $qty, $description, $batchNumber, $manufacturingDate, $expirationDate, $issuedTo)) {
        return "Missing required data.";
    }

    $stmt = $conn->prepare("SELECT medicine_id, QTY FROM medicines WHERE Item_Name = ?");
    $stmt->bind_param("s", $itemName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $medicine_id = $row['medicine_id'];
        $current_quantity = $row['QTY'];

        if ($qty > $current_quantity) {
            return "Insufficient quantity available";
        }
        
        $new_quantity = $current_quantity - $qty;
        $update_stmt = $conn->prepare("UPDATE medicines SET QTY = ? WHERE medicine_id = ?");
        $update_stmt->bind_param("ii", $new_quantity, $medicine_id);
        if ($update_stmt->execute()) {
      
            $Date = date("Y-m-d");
            
            $insert_stmt = $conn->prepare("INSERT INTO supply (Date, date_manufactured, item_name, batch_number, description, qty, Expiration_Date, issued_to) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("ssssssss", $Date, $manufacturingDate, $itemName, $batchNumber, $description, $qty, $expirationDate, $issuedTo);
            
            if ($insert_stmt->execute()) {
               
                $sql_log = "INSERT INTO logs (id, action, date_time) VALUES (NULL, 'Admin Medicine Released:  Quantity: $qty, $description, Issued to: $issuedTo', NOW())";
                $conn->query($sql_log);
                
                return "Success"; 
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


$error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['Date'],$_POST['date_manufactured'], $_POST['itemName'], $_POST['batchNumber'], $_POST['description'], $_POST['qty'], $_POST['expirationDate'], $_POST['IssuedTo'])) {
        $error_message = "Missing required data.";
    } else {
      
        $Date = $_POST['Date'];
        $date_manufactured = $_POST['date_manufactured'];
        $itemName = $_POST['itemName'];
        $batchNumber = $_POST['batchNumber'];
        $description = $_POST['description'];
        $qty = $_POST['qty'];
        $expirationDate = $_POST['expirationDate'];
        $issuedTo = $_POST['IssuedTo'];

     
        $result = releaseMedicine($Date, $itemName, $qty, $description, $batchNumber, $date_manufactured, $expirationDate, $issuedTo, $conn);

     
        if ($result === "Success") {
           
            header("Location: Transaction.php");
            exit();
        } else {
            $error_message = $result; 
        }
    }
}


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
    
    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
}

.modal-content {
    background-color: whitesmoke;
    margin: auto; /* Gawaing auto ang margin para sa horizontal centering */
    margin-top: 15%; /* I-maintain ang 15% margin sa top */
    padding: 20px;
    border: 1px solid #888;
    width: 25%;
    text-align: center; /* I-center ang text sa loob ng modal */
}

.modal-content p {
    margin-bottom: 20px;
}

.modal-content button {
    display: block; 
    margin: 0 auto; 
    margin-top: 10px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal-content p {
    margin-bottom: 20px;
}

.modal-content button {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.modal-content button:hover {
    background-color: #d32f2f;
}

.button-container {

    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 10px; 
}

.search-box {
    flex: 1; 
    margin-left: 60%; 
    margin-top:30px;
    width: 20px;
    padding:100px;
}

.search{
width:100%;
}

#recordNotFound {
    text-align: center; 
    color: red; 
    font-weight: bold; 
    margin-top: 20px; 
}

.submit{
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
           .submit:hover{
            background-color: #3d6e26;  
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
            <li><a href="Register.php">Account</a></li>
            <hr class="round"></hr>
            <li><a href="medicine_restore.php">Archive</a></li>
            <hr class="round"></hr>
            <li><a href="logs.php">Logs</a></li>
            <hr class="round"></hr>
        </ul>
        <footer style="background-color:#333; color:white; padding: 20px; text-align: center;  margin-top:400px">
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
    <input type="text" id="searchInput" placeholder="Search by Item Name" style="margin-left: 50%; margin-top: 20px; padding:10px; width:900px">
</div>

</div>

<div class="form-box" style="display: none;">
<form action=" Transaction.php" method="post">
    <label for="Date">Date:</label>
    <input type="date" id="Date" name="Date" required placeholder="Date">

    <label for="itemName"style="margin-right:10px">Item Name:</label>
    <input type="text" id="itemName" name="itemName" required placeholder="Item Name">

    <label for="batchNumber">Batch Number:</label>
    <input type="text" id="batchNumber" name="batchNumber" required placeholder="Batch Number">
    
    <label for="description">Unit:</label>
    <input type="text" id="description" name="description" required placeholder="Unit">
    <br>
    <label for="qty"style="margin-right:0px">Quantity:</label>
    <input type="number" id="qty" name="qty" required placeholder="Quantity">

    <label for="date_manufactured"style="margin-right:0px">Manufacturing Date:</label>
    <input type="date" id="date_manufactured" name="date_manufactured" required>

    <label for="expirationDate"style="margin-right:15px">Expiration Date:</label>
    <input type="date" id="expirationDate" name="expirationDate" required>

    <label for="IssuedTo"style="margin-left:30px">Issued To:</label>
    <input type="text" id="IssuedTo" name="IssuedTo" required placeholder="Iseud To">
    <br>
    <input type="submit" value="Add Transaction" class="submit">
</form>

        </div>

         

        <div class="form-box1" style="display: none;">
    <form id="supply-form" method="post" action="edittransactionfunction.php">
        <label for="edit_supply_id">Supply ID:</label>
        <input type="text" id="edit_supply_id" name="edit_supply_id" value="<?php echo $supplyData['supply_id']; ?>" required>
        <label for="edit_date">Date:</label>
        <input type="date" id="edit_date" name="edit_date" value="<?php echo $supplyData['date']; ?>" required>
        <label for="edit_itemName">Item Name:</label>
        <input type="text" id="edit_itemName" name="edit_itemName" value="<?php echo $supplyData['item_name']; ?>" required>
        <label for="edit_batchNumber">Batch Number:</label>
        <input type="text" id="edit_batchNumber" name="edit_batchNumber" value="<?php echo $supplyData['batch_number']; ?>">
        <label for="edit_lotNumber">Lot Number:</label>
        <input type="text" id="edit_lotNumber" name="edit_lotNumber" value="<?php echo $supplyData['lot_number']; ?>">
        <br>
        <label for="edit_description">Description:</label>   
        <input type="text" id="edit_description" name="edit_description" value="<?php echo $supplyData['description']; ?>">
        <label for="edit_qty">QTY:</label>
        <input type="text" id="edit_qty" name="edit_qty" value="<?php echo $supplyData['qty']; ?>">
        <label for="edit_manufacturingDate">Manufacturing Date:</label>
        <input type="date" id="edit_manufacturingDate" name="edit_manufacturingDate" value="<?php echo $supplyData['manufacturing_date']; ?>">
        <label for="edit_expirationDate">Expiration Date:</label>
        <input type="date" id="edit_expirationDate" name="edit_expirationDate" value="<?php echo $supplyData['expiration_date']; ?>">
        <label for="edit_issuedTo">Issued To:</label>
        <input type="text" id="edit_issuedTo" name="edit_issuedTo" value="<?php echo $supplyData['issued_to']; ?>">
        <label for="edit_medicineID">Medicine ID:</label>
        <input type="text" id="edit_medicineID" name="edit_medicineID" value="<?php echo $supplyData['medicine_id']; ?>">
        <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $id; ?>">
        <button type="submit" name="editSupply">EDIT TRANSACTIONssss</button>
    </form>
</div>


<script>
    function editSupply(id) {
        // Redirect to the edit page with the supply ID
        window.location.href = 'edittransaction.php?id=' + id;
    }

    document.getElementById("addSupplyButton").addEventListener("click", function() {
        var formBox = document.querySelector(".form-box");
        if (formBox.style.display === "none") {
            formBox.style.display = "block";
        } else {
            formBox.style.display = "none";
        }
    });

    document.getElementById("addSupplyButton1").addEventListener("click", function() {
        var formBox1 = document.querySelector(".form-box1");
        if (formBox1.style.display === "none") {
            formBox1.style.display = "block";
        } else {
            formBox.style.display = "none";
        }
    });
</script>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <form id="deleteForm" method="post" action="delete_transaction.php">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <p>Are you sure you want to delete this transaction?</p>
            <input type="hidden" id="deleteSupplyId" name="id">
            <button type="submit">Yes, delete</button>
        </form>
    </div>
</div>

</form>

<!-- Your HTML code -->
<script>
    function searchTable() {

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".data-table");
    tr = table.getElementsByTagName("tr");
    var recordNotFound = document.getElementById("recordNotFound");

    var found = false; 

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]; 

        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                found = true; 
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (found) {
        recordNotFound.style.display = "none";
    } else {
        recordNotFound.style.display = "block";
    }
}

</script>

<script>
    function openDeleteModal(id) {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "block";
        document.getElementById("deleteSupplyId").value = id;
    }

    function closeDeleteModal() {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("deleteModal");
        if (event.target == modal) {
            closeDeleteModal();
        }
    }
</script>

<!-- End of your HTML code -->

 
   <!-- Table Section -->
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <!-- <th>No.</th> -->
                <!-- <th>Date</th> -->
                <th style="color:white">Item Name</th>
                <th style="color:white">Batch/LotNumber</th>
                <th style="color:white">Unit</th>
                <th style="color:white">QTY</th>
                <th style="color:white">Manufacturing Date</th>
                <th style="color:white">Expiration Date</th>
                <th style="color:white">Issued To</th>
                <th style="color:white">Action</th>
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
                        <!-- <td><?php echo $row["supply_id"]; ?></td> -->
                        <!-- <td><?php echo $row["Date"]; ?></td> -->
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["batch_number"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["qty"]; ?></td>
                        <td><?php echo $row["date_manufactured"]; ?></td>
                        <td><?php echo $row["expiration_date"]; ?></td>
                        <td><?php echo $row["issued_to"]; ?></td>
                        <td>
    <!-- <button onclick="editSupply(<?php echo $row['supply_id']; ?>)">Edit</button> -->
    <button onclick="openDeleteModal(<?php echo $row['supply_id']; ?>)">Delete</button>
</td>

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
    function editsupply(id) {
        // Redirect to the edit page with the supply ID
        window.location.href = 'edittransactionfunction.php?id=' + id;
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
