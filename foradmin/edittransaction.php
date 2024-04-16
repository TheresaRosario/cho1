    <?php
    include 'database.php';

    function getSupplyData($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $query = "SELECT * FROM supply WHERE supply_id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    // Check if ID is provided in the URL
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $supplyData = getSupplyData($id);




    

    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Supply</title>
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
                width: 250px;
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
                margin-left: 100px;
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

            .dashboard {
                display: flex;
                justify-content: center; 
                margin-top: 50px;
            }

        
            
            .round1 {
                width: 100%;
            }

            .header {
                position: fixed;
                top: 0;
                left: 250px; 
                right: 0;
                background-color: #D9D9D9;
                padding: 5px;
                z-index: 1; 
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
                text-align: center;
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
                padding: 15px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin-top: 30px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s;
            }

            .button-container button:hover {
                background-color: #3d6e26;
            }

            .form-box {
                margin-top: 150px;
                padding: 10px;
                background-color: #D9D9D9;
                border: 1px solid #ccc; 
                border-radius: 10px;
                padding: 60px;
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
                display: block; 
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

        
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); 
    }

    .modal-content {
        background-color: whitesmoke;
        margin: auto;
        margin-top: 15%; 
        padding: 20px;
        border: 1px solid #888;
        width: 25%;
        text-align: center; 
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
        display: flex;
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 10px; 
    }

    .search-box {
        flex: 1; 
        margin-left: 60%; 
        margin-top:30px;
        width: 20px;
    }

    .search{
    width:75%;
    }

    #recordNotFound {
        text-align: center; 
        color: red; 
        font-weight: bold; 
        margin-top: 20px; 
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

            .header {
                position: fixed;
                top: 0;
                left: 200px; /* Adjusted to align with the sidebar */
                right: 0;
                background-color: #D9D9D9;
                padding: 5px;
                z-index: 1; /* Ensures the header is above the content */
            }

            /* Modal CSS */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: white;
                margin: auto;
                margin-top: 15%;
                padding: 20px;
                border: 1px solid #888;
                width: 25%;
                text-align: center;
                border-radius: 5px;
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
        display: flex;
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 10px; 
    }

        </style>
    </head>
    <body>

<div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
    <div class="logo">
        <img src="logo.png" alt="Logo">
    </div>
    <!-- <a href="FRONT.php" style="color: #2B4921; text-decoration: underline; margin-right: 100px; font-weight: bold; text-transform: uppercase;">GO BACK TO FRONT PAGE</a> -->
</div>

<div class="sidebar">
    <header style="background-color:#498B31;">
        <h2 style="color:white">INVENTORY SYSTEM</h2>
    </header>

    <ul>
        <li><a href="Dashboard.php">Dashboard</a></li>
        <hr class="round">
        <li><a href="Supply.php">Supply</a></li>
        <hr class="round">
        <li><a href="Transaction.php">Transaction</a></li>
        <hr class="round">
        <li><a href="Reports.php">Reports</a></li>
        <hr class="round">
        <li><a href="Register.php">Account</a></li>
        <hr class="round">
        <li><a href="medicine_restore.php">Archive</a></li>
        <hr class="round">
    </ul>

    <footer style="background-color:#333; color:white; padding: 20px; text-align: center; margin-top:570px">
        <form action="logout.php" method="post">
            <input type="submit" value="Log Out" style="background-color: #498B31; color: white; border: none; padding: 10px 20px; cursor: pointer;">
        </form>
    </footer>
</div>

<div class="content">
    <div class="form-box">


    <form id="supply-form" method="post" action="edittransactionfunction.php">

<label for="edit_date">Date:</label>
<input type="date" id="edit_date" name="edit_date" value="<?php echo isset($supplyData['date']) ? $supplyData['date'] : ''; ?>" required>

<label for="edit_itemName" style="margin-right:10px">Item Name:</label>
<input type="text" id="edit_itemName" name="edit_itemName" value="<?php echo isset($supplyData['item_name']) ? $supplyData['item_name'] : ''; ?>" required>

<label for="edit_batchNumber" style="margin-right:10px">Batch/Lot Number:</label>
<input type="text" id="edit_batchNumber" name="edit_batchNumber" value="<?php echo isset($supplyData['batch_number']) ? $supplyData['batch_number'] : ''; ?>">



<label for="edit_description" style="margin-top:20px; margin-right:5px">Unit:</label>
<input type="text" id="edit_description" style="margin-right:5px" name="edit_description" value="<?php echo isset($supplyData['description']) ? $supplyData['description'] : ''; ?>">
<br>
<label for="edit_qty">QTY:</label>
<input type="text" id="edit_qty" name="edit_qty" value="<?php echo isset($supplyData['qty']) ? $supplyData['qty'] : ''; ?>">

<label for="edit_manufacturingDate" style="margin-right:0px">Manufacturing Date:</label>
<input type="date" id="edit_manufacturingDate" style="margin-left:0px" name="edit_manufacturingDate"  value="<?php echo isset($supplyData['manufacturing_date']) ? $supplyData['manufacturing_date'] : ''; ?>">

<label for="edit_expirationDate" style="margin-top:20px;margin-right:30px">Expiration Date:</label>
<input type="date" id="edit_expirationDate" name="edit_expirationDate" style="margin-right:10px"value="<?php echo isset($supplyData['expiration_date']) ? $supplyData['expiration_date'] : ''; ?>">

<label for="edit_issuedTo" style="margin-top:20px;margin-left:20px">Issued To:</label>
<input type="text" id="edit_issuedTo" name="edit_issuedTo"style="margin-right:10px" value="<?php echo isset($supplyData['issued_to']) ? $supplyData['issued_to'] : ''; ?>">

<!-- <label for="edit_medicineId" style="margin-top:20px;margin-left:250px">Medicine ID:</label>
<input type="text" id="edit_medicineId" name="edit_medicineId" value="<?php echo isset($supplyData['medicine_id']) ? $supplyData['medicine_id'] : ''; ?>"> -->

<!-- Add a hidden field for supply ID if necessary -->
<input type="hidden" id="edit_id" name="edit_id" value="<?php echo isset($supply_id) ? $supply_id : ''; ?>">

<button type="submit" name="editSupply" style="margin-left:40%; padding:16px; width:200px;">EDIT TRANSACTION</button>
</form>


        <?php
        if(isset($_GET['success']) && $_GET['success'] == 'true') {
        ?>
            <div id="successModal" class="modal" style="display: block;">
                <div class="modal-content">
                    <span class="close" onclick="closeSuccessModal()">&times;</span>
                    <p>Successfully edited supply!</p>
                </div>
            </div>
        <?php
        }
        ?>
        <script>
            var successModal = document.getElementById("successModal");
            function openSuccessModal() {
                successModal.style.display = "block";
            }
            function closeSuccessModal() {
                successModal.style.display = "none";
            }
            window.onload = function() {
                openSuccessModal();
            };
        </script>
    </div>
    
    <div class="table-container">
        <table class="data-table">
            <thead></thead>
            <tbody id="supplyTableBody">
            <?php
            
            ?>
            </tbody>
        </table>
        <p id="recordNotFound" style="display: none;">Record not found</p>
    </div>
</div>

</body>
    </html>
