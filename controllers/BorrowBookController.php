<?php
include '../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $returnDate = $_POST['returnDate'];
    $borrowDate = date("Y-m-d H:i:s");

    if (empty($isbn) || empty($firstName) || empty($lastName) || empty($returnDate)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Get reader_id based on First Name and Last Name
    $readerQuery = "SELECT reader_id FROM readers WHERE first_name = ? AND last_name = ?";
    $stmt = $conn->prepare($readerQuery);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $readerResult = $stmt->get_result();

    if ($readerResult->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "Reader not found."]);
        exit;
    }

    $readerRow = $readerResult->fetch_assoc();
    $readerId = $readerRow['reader_id'];

    // Get copy_id from book_copies table based on ISBN
    $bookQuery = "SELECT copy_id FROM book_copies WHERE isbn = ? AND availability = 'Available' LIMIT 1";
    $stmt = $conn->prepare($bookQuery);
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $bookResult = $stmt->get_result();

    if ($bookResult->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "No available copies."]);
        exit;
    }

    $bookRow = $bookResult->fetch_assoc();
    $copyId = $bookRow['copy_id'];  // Use `copy_id` instead of `book_id`

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into borrow_records
        $insertQuery = "INSERT INTO borrow_records (reader_id, copy_id, borrow_date, due_date, return_date, status) VALUES (?, ?, ?, ?, NULL, 'Borrowed')";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iiss", $readerId, $copyId, $borrowDate, $returnDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert borrow record.");
        }

        // Update book_copies to set availability as "Borrowed"
        $updateQuery = "UPDATE book_copies SET availability = 'Borrowed' WHERE copy_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("i", $copyId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update book availability.");
        }

        // Commit transaction
        $conn->commit();

        echo json_encode(["status" => "success", "message" => "Book borrowed successfully!", "isbn" => $isbn]);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
