<?php
session_start();
function checkAuthentication() {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("Location: Login.php");
        exit(); 
    }
}
checkAuthentication();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
  
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
            justify-content: center; 
            margin-top: 50px;
        }

        .dashboard-box {
            flex: 1; /* Makes each box take an equal amount of space */
            max-width: 200px; /* Limits the maximum width of each box */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-right: 20px; /* Adjust the space between dashboard boxes */
        }

        .dashboard-box:last-child {
            margin-right: 0; /* No margin for the last dashboard box */
        }

        .dashboard-box h2 {
            margin-top: 0;
        }

        /* Different background colors for dashboard boxes */
        .dashboard-box:nth-child(1) {
            background-color: #498B31; 
            color: white;
        }

        .dashboard-box:nth-child(2) {
            background-color: #D35400; 
            color: white;
        }

        .dashboard-box:nth-child(3) {
            background-color: #2980B9; 
            color: white;
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

        /* Table CSS */
        .table-container {
            display: flex;
            justify-content: space-between;
            margin-top: 100px;
        }

        /* Table containers */
        .supply-table-container,
        .medicine-table-container {
            width: 50%; /* Adjust the width as needed */
            margin: 10px; /* Add margin here */
            max-height: calc(100vh - 200px); /* Adjust the maximum height as needed */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px; 
        }

        th, td {
            border: 1px solid green;
            text-align: left;
            width:10px;
        }

        th {
            background-color: #498B31;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style for the supply table */
        #supply-table th {
            background-color: #498B31; /* Change the background color */
            color: white;
        }

        /* Style for the medicine table */
        #medicine-table th {
            background-color: #D35400; /* Change the background color */
            color: white;
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
        
       
        <!-- <li><a href="register.php">Account</a></li>
        <hr class="round"></hr> -->
    </ul>
    <footer style="background-color:#333; color:white; padding: 20px; text-align: center; margin-top:570px">
    <form action="logout.php" method="post">
        <input type="submit" value="Log Out" style="background-color: #498B31; color: white; border: none; padding: 10px 20px; cursor: pointer;">
    </form>
</footer>


</div>



<div class="content">
    <div class="dashboard">
    <?php

function countTotalRecords() {

    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "choinventory"; 
    

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
   
    $sql = "SELECT COUNT(*) AS total_records FROM medicines"; 
    $result = $conn->query($sql);
    

    if ($result->num_rows > 0) {
     
        $row = $result->fetch_assoc();
        $total_records = $row["total_records"];
    } else {
        $total_records = 0;
    }

    $conn->close();
    
    return $total_records;
}

$total_records = countTotalRecords();
?>
<div class="dashboard-box">
    <h2>Total Supply</h2>
    <p><?php echo $total_records; ?></p>
</div>

<?php

function countTotalSupply() {

    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "choinventory"; 
    

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
   
    $sql = "SELECT COUNT(*) AS total_supply FROM supply"; 
    $result = $conn->query($sql);
    

    if ($result->num_rows > 0) {
     
        $row = $result->fetch_assoc();
        $total_supply = $row["total_supply"];
    } else {
        $total_supply = 0;
    }

    $conn->close();
    
    return $total_supply;
}

$total_supply = countTotalSupply();
?>
        <div class="dashboard-box">
            <h2>Total Transactions</h2>
            <p><?php echo $total_supply; ?></p>
        </div>
        <!-- <div class="dashboard-box">
            <h2>Total </h2>
            <p>50</p>
        </div> -->
    </div>

    <div class="table-container">
        <div class="supply-table-container">
            <h3 style="color: #498B31;"style=margin-left:100px;> Medical Supply</h3>
            <table id="supply-table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Item Name</th>
                    <th>Batch/Lot Number</th>
                   
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>MFG Date</th>
                    <th>EXP Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Connect to your database
                $servername = "localhost";
                $username = "root"; // Replace with your MySQL username
                $password = ""; // Replace with your MySQL password
                $database = "choinventory"; // Replace with your database name
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the supply table
                $sql = "SELECT * FROM medicines";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["Date"] . "</td>
                                <td>" . $row["Item_Name"] . "</td>
                                <td>" . $row["batch_number"] . "</td>
                               
                                <td>" . $row["Description"] . "</td>
                                <td>" . $row["QTY"] . "</td>
                                <td>" . $row["Manufacturing_Date"] . "</td>
                                <td>" . $row["Expiration_Date"] . "</td>
                              </tr>";
                    }
                } else {
                    // echo "0 results";
                }

                // Close the database connection
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>

        <div class="medicine-table-container">
            <h3 style="color: #D35400;">Today's Transaction</h3>
            <table id="medicine-table">
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
                <?php
                // Connect to your database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "choinventory";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to fetch data from the medicine table
                $sql = "SELECT * FROM supply";
                $result = $conn->query($sql);

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                   
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['item_name'] . "</td>";
                    echo "<td>" . $row['batch_number'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['qty'] . "</td>";
                    echo "<td>" . $row['date_manufactured'] . "</td>";
                    echo "<td>" . $row['expiration_date'] . "</td>";
                    echo "<td>" . $row['issued_to'] . "</td>";
                    echo "</tr>";
                }

                // Close connection
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
