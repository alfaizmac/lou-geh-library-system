<?php
include __DIR__ . '/../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_book"])) {
    // Get form values
    $isbn = $_POST["isbn"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $publication_year = $_POST["publication_year"];
    $num_pages = $_POST["num_pages"];
    $publisher_id = $_POST["publisher_id"];
    $category_names = isset($_POST["category_names"]) ? $_POST["category_names"] : []; // Array of selected categories
    $shelf_location = $_POST["shelf_location"];

    // Convert category names array to a comma-separated string
    $categories = implode(", ", $category_names);

    // Check if ISBN already exists
    $check_sql = "SELECT isbn FROM books WHERE isbn = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $isbn);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        header("Location: ../books.php?error=Book with this ISBN already exists.");
        exit();
    }

    $check_stmt->close();

    // Handle book image upload
    $targetDir = __DIR__ . '/../assets/images/books/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageFileName = "default.png"; // Default image
    if (!empty($_FILES["book_image"]["name"])) {
        $bookImage = $_FILES["book_image"]["name"];
        $imageTmpName = $_FILES["book_image"]["tmp_name"];
        $imageExt = strtolower(pathinfo($bookImage, PATHINFO_EXTENSION));
        $allowedExts = ["jpg", "jpeg", "png", "gif"];
        $imageFileName = uniqid("book_") . "." . $imageExt;
        $targetFilePath = $targetDir . $imageFileName;

        if (!in_array($imageExt, $allowedExts) || $_FILES["book_image"]["size"] > 2 * 1024 * 1024) {
            header("Location: ../books.php?error=Invalid image file.");
            exit();
        }

        if (!move_uploaded_file($imageTmpName, $targetFilePath)) {
            header("Location: ../books.php?error=Failed to upload image.");
            exit();
        }
    }

    // Insert book into `books` table
    $sql = "INSERT INTO books (isbn, title, author, publication_year, number_of_pages, publisher_id, categories, book_image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiss", $isbn, $title, $author, $publication_year, $num_pages, $publisher_id, $categories, $imageFileName);

    if ($stmt->execute()) {
        // Insert shelf location into `book_copies`
        $copy_sql = "INSERT INTO book_copies (isbn, shelf_location) VALUES (?, ?)";
        $copy_stmt = $conn->prepare($copy_sql);
        $copy_stmt->bind_param("ss", $isbn, $shelf_location);
        $copy_stmt->execute();

        header("Location: ../books.php?success=Book added successfully");
    } else {
        header("Location: ../books.php?error=Failed to add book");
    }

    $stmt->close();
    $copy_stmt->close();
    $conn->close();
}
?>
