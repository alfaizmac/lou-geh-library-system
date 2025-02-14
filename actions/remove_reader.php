<?php
// Database connection
include '../configs/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reader_id'])) {
    $reader_id = intval($_POST['reader_id']);

    // Prepare and execute the delete query
    $query = "DELETE FROM readers WHERE reader_ID = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $reader_id);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect with 'removed' parameter to display correct alert
            header("Location: ../readers.php?removed=success");
            exit();
        } else {
            header("Location: ../readers.php?error=remove");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../readers.php?error=remove");
        exit();
    }
} else {
    header("Location: ../readers.php?error=remove");
    exit();
}
?>
