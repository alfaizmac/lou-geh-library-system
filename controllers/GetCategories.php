<?php
include '../configs/db.php'; // Database connection

header('Content-Type: application/json');

$sql = "SELECT category_id, name FROM categories";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
?>
