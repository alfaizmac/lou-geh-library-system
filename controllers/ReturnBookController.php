<?php
include '../configs/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $copyId = $_POST['copy_id'];
    $returnDate = date("Y-m-d H:i:s");

    if (empty($copyId)) {
        echo json_encode(["status" => "error", "message" => "Copy ID is missing."]);
        exit;
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update borrow_records: Set return_date and status
        $updateBorrowQuery = "UPDATE borrow_records 
                              SET return_date = ?, status = 'Returned' 
                              WHERE copy_id = ? AND status = 'Borrowed'";
        $stmt = $conn->prepare($updateBorrowQuery);
        $stmt->bind_param("si", $returnDate, $copyId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update borrow record.");
        }

        // Update book_copies: Set availability to 'Available'
        $updateBookQuery = "UPDATE book_copies SET availability = 'Available' WHERE copy_id = ?";
        $stmt = $conn->prepare($updateBookQuery);
        $stmt->bind_param("i", $copyId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update book availability.");
        }

        // Commit transaction
        $conn->commit();

        echo json_encode(["status" => "success", "message" => "Book returned successfully!", "copy_id" => $copyId]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
