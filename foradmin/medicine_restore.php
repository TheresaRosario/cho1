<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteByDateRange'])) {
    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        
        deleteItemsByDateRange($startDate, $endDate);
    } else {
        echo "Start date or end date not provided.";
    }
}

function deleteItemsByDateRange($startDate, $endDate) {
    $servername = "localhost";
    $dbname = "choinventory";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "DELETE FROM archived_medicines WHERE Date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);


    $stmt->bind_param("ss", $startDate, $endDate);

    if ($stmt->execute()) {
        echo "Items deleted successfully within the date range $startDate to $endDate.";
        // Redirect to medicine_store.php
        header("Location: CHOsystem1/forencoder/medicine_store.php");
        exit();
    } else {
        echo "Error deleting items: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Restore Medicine</title>
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
            margin-left: 190px;
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
            left: 200px; /* Adjusted to align with the sidebar */
            right: 0;
            background-color: #D9D9D9;
            padding: 5px;
            z-index: 1; /* Ensures the header is above the content */
        }

        .table-container {
            margin-top: 5px;
            overflow-x: auto;

        }

        .data-table {
            width: 90%;
            border-collapse: collapse;
            margin-left: 5%;
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
 /* New styles for button and date input */
 .form-box input[type="date"],
        .form-box button {
            margin-top: 10px; /* Adjust as needed */
            margin-right: 10px; /* Adjust as needed */
            padding: 15px;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .form-box button {
            background-color: #498B31;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-box button:hover {
            background-color: #3d6e26;
        }

        /* Centering the form */
        .form-box {
            margin: auto;
            width: fit-content;
            text-align: center;
        }

    </style>
</head>
<body>
<header style="background-color:whitesmoke; display: flex; align-items: center;">
    <img src="logo.png" alt="Logo" style="max-width: 100px; height: auto; margin-right: 10px; margin-left: 40%;">
    <h2 style="margin-left:%;padding:px; margin-bottom: 50px; color: green; margin-top:35px; font-size:30px">Restore Medicine Records</h2>
    <button onclick="redirectToPage()" style="padding: 5px; margin-left: 400px; width: 10%; background-color: green; color: white;">Back</button>
    <script>
function redirectToPage() {
  window.location.href = 'Dashboard.php'; // Palitan mo 'target_page.html' ng URL ng iyong target page
}
</script>
</header>
    
<!-- <form method="post" style="margin-top: 20px" action="permanent_archive_delete.php">
    <label for="startDate" style="margin-left: 40%">From:</label>
    <input type="date" id="startDate" name="startDate" required>
    <label for="endDate" required>To:</label>
    <input type="date" id="endDate" name="endDate" required>
    <button type="submit" name="deleteByDateRange" style="padding:2px; width:100px; background-color: green; color:white">Delete</button>
</form>
 -->


    <form method="post" action="restore_medicine.php">
    <input type="submit" value="Restore " style="padding:5px; margin-left:90px; width: 10%; background-color: green; color: white">
    <button style="width: auto; color:green; border: none; cursor: pointer; margin-left: 60px; margin-top: 10px; font-size: 30px;" onclick="window.location.href='register.php'">
     <!-- <span>&#8592;</span> -->
</button>

    <div class="table-container">
            <table class="data-table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Date</th>
                <th>Item Name</th>
                <th>Lot/Batch Number</th>
              
                <th>Unit</th>
                <th>Quantity</th>
                <th>Manufacturing Date</th>
                <th>Expiration Date</th>
            </tr>
        </thead>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "choinventory";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $select_sql = "SELECT archive_id, Date, Item_Name, Batch_Number,  Description, QTY, Manufacturing_Date, Expiration_Date FROM archived_medicines";
            $result = $conn->query($select_sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><input type='checkbox' name='archive_ids[]' value='<?php echo $row['archive_id']; ?>'></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['Item_Name']; ?></td>
                        <td><?php echo $row['Batch_Number']; ?></td>
                       
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['QTY']; ?></td>
                        <td><?php echo $row['Manufacturing_Date']; ?></td>
                        <td><?php echo $row['Expiration_Date']; ?></td>
                       <td>

                </td>
                        
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8'>No archived records</td></tr>";
            }
            $conn->close();
            ?>
        </table>
 
        </div>
    </form>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <form id="deleteForm" method="post" action="permanent_archive_delete.php">
                <span class="close" onclick="closeDeleteModal()">&times;</span>
                <p>Are you sure you want to delete this supply?</p>
                <input type="hidden" id="deleteSupplyId" name="id">
                <button type="submit">Yes, delete</button>
            </form>
        </div>
       </div>

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

</body>
</html>
