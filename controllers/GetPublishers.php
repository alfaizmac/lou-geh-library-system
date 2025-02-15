<?php
include '../configs/db.php'; // Database connection

header('Content-Type: application/json');

$sql = "SELECT publisher_id, name FROM publishers";
$result = $conn->query($sql);

$publishers = [];
while ($row = $result->fetch_assoc()) {
    $publishers[] = $row;
}

echo json_encode($publishers);
?>
