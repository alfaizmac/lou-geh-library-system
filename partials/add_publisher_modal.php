<!-- Add Publisher Modal -->
<div class="modal fade" id="addPublisherModal" tabindex="-1" aria-labelledby="addPublisherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPublisherModalLabel">Add New Publisher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPublisherForm" action="controllers/AddPublisherController.php" method="POST">
                    <div class="mb-3">
                        <label for="publisher_name" class="form-label">Publisher Name</label>
                        <input type="text" class="form-control" id="publisher_name" name="publisher_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="publisher_location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="publisher_location" name="publisher_location" required>
                    </div>
                    <button type="submit" name="add_publisher" class="btn btn-primary">Add Publisher</button>
                </form>
            </div>
        </div>
    </div>
</div>
