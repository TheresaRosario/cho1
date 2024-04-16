<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['archive_ids'])) {
        $archive_ids = $_POST['archive_ids'];
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "choinventory";

       
        $conn = new mysqli($servername, $username, $password, $dbname);

     
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

    
        foreach ($archive_ids as $archive_id) {
           
            $restore_query = "INSERT INTO medicines (Date,Item_Name, Batch_Number, Description, QTY, Mfg_Date, Exp_Date)
                              SELECT Date, Item_Name, Batch_Number,  Description, QTY, Mfg_Date, Exp_Date
                              FROM archived_medicines WHERE archive_id = ?";
            $stmt = $conn->prepare($restore_query);
            $stmt->bind_param("i", $archive_id);
            $stmt->execute();

            
        }

        $conn->close();

        
        header("Location: Supply.php");
        exit();
    } else {
        echo "No archive IDs provided.";
    }
} else {
    echo "Invalid request.";
}
?>
