<?php
include '../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_category"])) {
    $category_name = trim($_POST["category_name"]);
    $parent_category_id = !empty($_POST["parent_category_id"]) ? intval($_POST["parent_category_id"]) : NULL;

    // Check if category already exists
    $check_sql = "SELECT category_id FROM categories WHERE name = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $category_name);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Category already exists
        header("Location: ../books.php?error=Category already exists");
        exit();
    }

    // Insert new category with parent category
    $sql = "INSERT INTO categories (name, parent_category_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category_name, $parent_category_id);

    if ($stmt->execute()) {
        header("Location: ../books.php?success=Category added successfully!");
    } else {
        header("Location: ../books.php?error=Failed to add category");
    }

    $stmt->close();
    $conn->close();
}
?>
