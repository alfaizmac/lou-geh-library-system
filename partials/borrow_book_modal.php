<div class="modal fade" id="borrowBookModal" tabindex="-1" aria-labelledby="borrowBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowBookModalLabel">Borrow Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="bookImage" src="" alt="Book Image" class="img-fluid mb-3" style="max-width: 120px;">
                </div>
                <div class="mb-2"><strong>ISBN:</strong> <span id="bookISBN"></span></div>
                <div class="mb-2"><strong>Title:</strong> <span id="bookTitle"></span></div>
                <div class="mb-2"><strong>Author:</strong> <span id="bookAuthor"></span></div>
                <div class="mb-3"><strong>Categories:</strong> <span id="bookCategories"></span></div>

                <form id="borrowForm">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addReaderModal">Add New Reader</button>
                    </div>
                    <div class="mb-3">
                        <label for="returnDate" class="form-label">Return Date</label>
                        <input type="date" class="form-control" id="returnDate" name="returnDate" required>
                    </div>
                    <input type="hidden" id="hiddenISBN" name="isbn">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("borrowForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("controllers/BorrowBookController.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            var borrowBookModal = bootstrap.Modal.getInstance(
                document.getElementById("borrowBookModal")
            );
            borrowBookModal.hide();  // Close the modal
            location.reload();  // Refresh the page after successful borrowing
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>

