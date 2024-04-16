<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            /* background-color:; */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"].button {
            background-color: #428f26;
            color: #fff;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            margin-left: 30%;
            margin-top: 60px;
            overflow-x: auto;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #498B31;
            color: #333;
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


        input[type="submit"].button {
    background-color: #428f26;
    color: #fff;
    transition: none; /* ito ay tanggalin ang transition para sa submit button na ito */
}


        </style>
</head>
<body>
    
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
       
        <li><a href="register.php">Account</a></li>
        <hr class="round"></hr>
    </ul>
    <footer style="background-color:#333; color:white; padding: 5px; text-align: center; margin-top:490px">
    <form action="logout.php" method="post">
        <input type="submit" value="Log Out" style="background-color: #498B31; color: white; border: none; padding: 10px 20px; cursor: pointer;">
    </form>
</footer>



</div>


    <div class="container">
        <h2>User Registration Form</h2>
        <?php
        // Check if a success message is provided in the URL parameters
        if(isset($_GET['message']) && $_GET['message'] == 'success') {
            echo "<p class='success-message'>Registration successful!</p>";
        }
        ?>
        <form action="registerfunction.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            
            <input type="submit" value="Register" class="button">
        </form>
    </div>
    <table>
            <thead>
                <tr>
               
                    <th>Username</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
           
                $mysqli = new mysqli("localhost", "root", "", "choinventory");

         
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }

   
                $sql = "SELECT id, username, password FROM account";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                 
                    while($row = $result->fetch_assoc()) {
                        echo    "</td><td>" . $row["username"]. "</td><td>" . $row["password"]. "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>0 results</td></tr>";
                }

            
                $mysqli->close();
                ?>
            </tbody>
        </table>
</body>
</html>
