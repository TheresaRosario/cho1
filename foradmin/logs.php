<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 200px;
            background-color: #2B4921;
            color: #fff; /* Changed text color */
        }
        .sidebar header {
            background-color: white;
            padding: 20px;
            text-align: center;
        }
        .sidebar h2 {
            margin: 0;
            color: #fff; /* Changed text color */
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            margin-left: 50px;
            font-style: Arial; /* Changed font */
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
            color: #fff; /* Changed text color */
            font-family: Arial, sans-serif; /* Changed font */
        }
       
        .container {
            margin: 0 auto; 
            width: 80%;
            overflow-x: auto; 
        }
        table {
            width: 100%; /* Table takes full width */
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-family: Arial, sans-serif; /* Changed font */
        }
        th {
            background-color:  #498B31;
            color: #333;
        }
        .no-record {
            text-align: center;
            padding: 10px;
            color: #333; /* Changed text color */
            font-family: Arial, sans-serif; /* Changed font */
        }
    </style>
</head>
<body>
<header style="background-color:whitesmoke; display: flex; align-items: center;">
    <img src="logo.png" alt="Logo" style="max-width: 100px; height: auto; margin-right: 15px; margin-left: 50%;">
    <h2 style="margin-left:%;padding:px; margin-bottom: 50px; color: green; margin-top:35px; font-size:30px">DATA LOGS</h2>
</header>
<div class="sidebar">
    <header style="background-color:#498B31; ">
        <h2>INVENTORY SYSTEM</h2>
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
    <footer style="background-color:#333; color:#fff; padding: 20px; text-align: center;  margin-top:400px">
        <form action="logout.php" method="post">
            <input type="submit" value="Log Out" style="background-color: #498B31; color: #fff; border: none; padding: 10px 20px; cursor: pointer;">
        </form>
    </footer>
</div>
<div class="content">
    <div class="container">
        <table>
            <tr>
                <th>Action</th>
                <th>Date and Time</th>
            </tr>
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "choinventory";

            $conn = new mysqli($servername, $username, $password, $database);


            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            $sql = "SELECT id, action, date_time FROM logs WHERE id ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["action"] . "</td>";
                    echo "<td>" . $row["date_time"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="2" class="no-record">0 results</td></tr>';
            }

            $conn->close();
            ?>
        </table>
    </div>
</div>
</body>
</html>
