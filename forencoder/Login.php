
<?php
session_start();
if(isset($_SESSION['username'])) {
    header("Location: Dashboard.php"); // Redirect to the dashboard if user is already logged in
    exit();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "choinventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to authenticate user
function authenticateUser($username, $password, $conn) {
    $username = sanitizeInput($username);
    $password = sanitizeInput($password);

    $sql = "SELECT * FROM account WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Authentication successful
        $_SESSION['username'] = $username;
        header("Location: Dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        // Authentication failed
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: Login.php"); // Redirect back to login form
        exit();
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Authenticate user
    authenticateUser($username, $password, $conn);
}
?>
 <div class="go-back-link">
    <a href="FRONT.php" style="color: #2B4921; text-decoration: underline; font-weight: bold; text-transform: uppercase;">GO BACK TO FRONT PAGE</a>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('f.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .logo {
            margin-left: 10px;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.7); /* White with 70% opacity */
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow effect */
            width: 380px;
            height: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 10px; /* Add margin below the header */
        }

        .login-text {
            text-align: center;
            margin-bottom: 20px; /* Add margin below the login text */
            margin-top: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 50%;
            padding: 10px;
            background-color: #2B4921;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #A6C06F;
        }
        .go-back-link {
    position: fixed;
    top: 20px;
    left: 20px;
}

    </style>
</head>
<body>
<div class="container">
    <div class="login-form">
        <h2>Login</h2>
        <div class="logo">
            <img src="logo.png" alt="Logo" width="100">
        </div>
        <div class="login-text">Inventory System</div>
        <form id="loginForm" action="Login.php" method="post">
            <?php
            if(isset($_SESSION['error'])) {
                echo '<div class="error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
       

    </div>
</div>



</body>
</html>
