<?php
include '../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_publisher"])) {
    $publisher_name = trim($_POST["publisher_name"]);
    $publisher_location = trim($_POST["publisher_location"]);

    // Check if publisher already exists
    $check_sql = "SELECT publisher_id FROM publishers WHERE name = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $publisher_name);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Publisher already exists
        header("Location: ../books.php?error=Publisher already exists");
        exit();
    }

    // Insert new publisher
    $sql = "INSERT INTO publishers (name, location) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $publisher_name, $publisher_location);

    if ($stmt->execute()) {
        header("Location: ../books.php?success=Publisher added");
    } else {
        header("Location: ../books.php?error=Failed to add publisher");
    }

    $stmt->close();
    $conn->close();
}
?>
