<?php
// Fetch borrow records
include './configs/db.php';
$query = "
    SELECT 
        borrow_records.borrow_id, 
        CONCAT(readers.first_name, ' ', readers.last_name) AS reader_name, 
        books.isbn AS book_isbn, 
        borrow_records.borrow_date, 
        borrow_records.due_date, 
        borrow_records.return_date, 
        borrow_records.status
    FROM borrow_records
    JOIN readers ON borrow_records.reader_id = readers.reader_id
    JOIN book_copies ON borrow_records.copy_id = book_copies.copy_id
    JOIN books ON book_copies.isbn = books.isbn
";

$result = mysqli_query($conn, $query);
?>

<!-- Borrow Logs Modal -->
<div class="modal fade" id="borrowLogsModal" tabindex="-1" aria-labelledby="borrowLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowLogsModalLabel">Borrow Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="borrowLogsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Reader Name</th>
                                <th>Book ISBN</th>
                                <th>Borrowed Date</th>
                                <th>Due Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['reader_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['book_isbn']); ?></td>
                                    <td><?php echo htmlspecialchars($row['borrow_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                                    <td><?php echo $row['return_date'] ? htmlspecialchars($row['return_date']) : 'Not returned yet'; ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
