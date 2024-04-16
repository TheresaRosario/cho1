<?php
// Sample inventory data
$inventoryData = [
    ['item' => 'Item A', 'supply' => 50],
    ['item' => 'Item B', 'supply' => 30],
    ['item' => 'Item C', 'supply' => 20]
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($inventoryData);
?>
