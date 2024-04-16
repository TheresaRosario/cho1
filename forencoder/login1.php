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
            max-width: 200px;
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
            left: 250px; /* Adjusted to align with the sidebar */
            right: 0;
            background-color: #D9D9D9;
            padding: 5px;
            z-index: 1; /* Ensures the header is above the content */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
    </div>
    <div class="sidebar">
        <header style="background-color:#498B31; ">
            <h2 style="color:white">INVENTORY SYSTEM</h2>
        </header>
   
        <!-- <hr class="round"></hr> -->
        <ul>
            <li><a href="#">Dashboard</a></li>
            <hr class="round"></hr>
            <li><a href="#">Supply</a></li>
            <hr class="round"></hr>
            <li><a href="#">Transaction</a></li>
            <hr class="round"></hr>
            <li><a href="#">Reports</a></li>
            <hr class="round"></hr>
        </ul>
    </div>
    <div class="content">
        <!-- Dashboard Section -->
        <div class="dashboard">
            <div class="dashboard-box">
                <h2>Total Supply</h2>
                <p>100</p>
            </div>
            <div class="dashboard-box">
                <h2>Total Transactions</h2>
                <p>50</p>
            </div>
            <div class="dashboard-box">
                <h2>Total </h2>
                <p>50</p>
            </div>
        </div>
    </div>
</body>
</html>