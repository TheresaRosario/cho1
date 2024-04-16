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
            left: 250px; /* Adjusted to align with the sidebar */
            right: 0;
            background-color: #D9D9D9;
            padding: 5px;
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

        /* Modal Styles */
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
    display: block; /* Gawaing block para ma-center ang button */
    margin: 0 auto; /* I-center ang button horizontally */
    margin-top: 10px; /* Lagyan ng margin sa top para hindi dikit sa text */
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
    justify-content: space-between; /* Pantayin ang mga elements horizontally */
    align-items: center; /* I-center vertically ang mga elements */
    margin-bottom: 10px; /* Dagdagan ang bottom margin para hindi dikit sa search box */
}

.search-box {
    flex: 1; /* Patagin ang search box */
    margin-left: 60%; /* Magdagdag ng right margin para hindi dikit sa button */
    margin-top:30px;
    width: 20px;
}

.search{
width:75%;
}

#recordNotFound {
    text-align: center; /* I-center ang text */
    color: red; /* Kulay na pula */
    font-weight: bold; /* Pakapal na font */
    margin-top: 20px; /* Magdagdag ng space sa itaas */
}

    </style>
</head>

<body>
    
<?php if (!empty($success_message)): ?>
    <div style="background-color: #A6C06F; color: black; padding: 10px; border-radius: 5px; margin-bottom: 50px;"><?php echo $success_message; ?></div>
<?php endif; ?>

  
    <!-- Your HTML content -->
    <div class="header">
        <div class="logo">
            <img src="logo.png" alt="Logo"> 
        </div>
    </div>
    <div class="sidebar">
        <header style="background-color:#498B31;">
            <h2 style="color:white">INVENTORY SYSTEM</h2>
        </header>
   
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <hr class="round"></hr>
            <li><a href="Supply.php">Supply</a></li>
            <hr class="round"></hr>
            <li><a href="Transaction.php">Transaction</a></li>
            <hr class="round"></hr>
            <li><a href="Report.php">Reports</a></li>
            <hr class="round"></hr>
        </ul>
    </div>
    <div class="content">
    <div class="button-container">
    <button id="addSupplyButton">ADD NEW SUPPLY</button>
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search..." class="search" oninput="searchTable()">
    </div>
</div>

       
        <div class="form-box" style="display: none;">
            <form id="supply-form" method="post" action="supplyfunction.php">
               
                <label for="date" style="">Date:</label>
                <input type="date" id="date" name="date" required placeholder="Date">
               
                <label for="itemName"style="margin-left:11px">Item Name:</label>
                <input type="text" id="itemName" name="itemName" style="margin-left:0px"  required placeholder="Item Name">

                <label for="batchNumber">Batch Number:</label>
                <input type="text" id="batchNumber" name="batchNumber"  style="margin-left:10px" placeholder="Batch Number">

                <label for="lotNumber" style="margin-left:4px">Lot Number:</label>
                <input type="text" id="lotNumber" name="lotNumber"  style="margin-left: 20px" placeholder="Lot Number">

                <br>
                <label for="description" style="margin-right: 10px">Description:</label>   
                <input type="text" id="description" name="description"style="margin-right: 5px" placeholder="Description">

                <label for="qty" style="margin-left:30px">QTY:</label>
                <input type="text" id="qty" name="qty"style="margin-left:0px" placeholder="Quantity" >

                <label for="manufacturingDate">Manufacturing Date:</label>
                <input type="date" id="manufacturingDate" name="manufacturingDate" placeholder="Manufacturing Date">

                <label for="expirationDate"style="margin-left: 20px">Expiration Date:</label>
                <input type="date" id="expirationDate" name="expirationDate"style="margin-left: 25px" placeholder="Expiration Date ">    

                <button type="submit">ADD SUPPLY</button>
            </form>
        </div>

        <div id="deleteModal" class="modal">
        <div class="modal-content">
            <form id="deleteForm" method="post" action="delete_supply.php">
                <span class="close" onclick="closeDeleteModal()">&times;</span>
                <p>Are you sure you want to delete this supply?</p>
                <input type="hidden" id="deleteSupplyId" name="id">
                <button type="submit">Yes, delete</button>
            </form>
        </div>
       </div>

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
        var modal = document.getElementById("deleteModal");
        function openDeleteModal(id) {
        modal.style.display = "block";
        document.getElementById("deleteSupplyId").value = id;
         }
        function closeDeleteModal() {
        modal.style.display = "none";
        }
        window.onclick = function(event) {
        if (event.target == modal) {
        closeDeleteModal();
        }
        }
        </script>

              
        <?php
            // Establish database connection
            $servername = "localhost";
            $username = "root"; // Replace with your MySQL username
            $password = ""; // Replace with your MySQL password
            $dbname = "choinventory";   // Replace with your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the database
            $sql = "SELECT * FROM supply_table";
            $result = $conn->query($sql);

            // Close database connection
            $conn->close();
        ?>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr >
                        <th style="color:white; text-align:center">No.</th>
                        <th style="color:white; text-align:center">Date</th>
                        <th style="color:white; text-align:center">Item Name</th>
                        <th style="color:white; text-align:center">Batch Number</th>
                        <th style="color:white; text-align:center">Lot Number</th>
                        <th style="color:white; text-align:center">Description</th>
                        <th style="color:white; text-align:center">QTY</th>
                        <th style="color:white;text-align:center">Manufacturing Date</th>
                        <th style="color:white; text-align:center">Expiration Date</th>
                        <th style="color:white; text-align:center">Action</th>
                    </tr>
                </thead>

               <tbody id="supplyTableBody">
                <?php
                    // Display fetched data in the table
                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['batch_number']; ?></td>
                            <td><?php echo $row['lot_number']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['qty']; ?></td>
                            <td><?php echo $row['manufacturing_date']; ?></td>
                            <td><?php echo $row['expiration_date']; ?></td>
                            <td>
                                <button onclick="editSupply(<?php echo $row['id']; ?>)">Edit</button>
                                <button onclick="openDeleteModal(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                <?php
                        }
                    } else {
                ?>
                   
                <?php
                    }
                ?>
            </tbody>
            </table>
            <p id="recordNotFound" style="display: none;">Record not found</p>
        </div>
    </div>

<script>
    function editSupply(id) {
        // Redirect to the edit page with the supply ID
        window.location.href = 'editsupply.php?id=' + id;
    }

    document.getElementById("addSupplyButton").addEventListener("click", function() {
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
