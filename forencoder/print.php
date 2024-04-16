<!DOCTYPE html>
<html>
<head>
    <title>Generate CSV</title>
</head>
<body>
    <form method="post">
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="date">
        <button type="submit" name="generate_csv">Generate CSV</button>
    </form>

    <?php
    if(isset($_POST['generate_csv'])) {
        // Include the database connection and functions
        include_once 'database.php'; // assuming your database connection file is named database.php
        include_once 'printfunction.php'; // assuming your functions file is named printfunction.php
        
        // Example usage with PDO
        $pdo = new PDO('mysql:host=localhost;dbname=choinventory', 'root', '');
        $date = $_POST['date']; // Get the selected date from the form
        generateRecordAndPrintCSV($date, $pdo);
    }
    ?>
</body>
</html>
