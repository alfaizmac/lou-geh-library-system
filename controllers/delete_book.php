<?php
include '../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["isbn"])) {
    $isbn = $conn->real_escape_string($_POST["isbn"]);

    // Delete book from book_copies first to maintain foreign key integrity
    $conn->query("DELETE FROM book_copies WHERE isbn = '$isbn'");

    // Delete book from books table
    $query = "DELETE FROM books WHERE isbn = '$isbn'";
    if ($conn->query($query) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
