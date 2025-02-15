<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="controllers/AddCategoryController.php" method="POST">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>

                    <!-- Parent Category Dropdown -->
                    <div class="mb-3">
                        <label for="parent_category" class="form-label">Parent Category (Optional)</label>
                        <select class="form-control" id="parent_category" name="parent_category_id">
                            <option value="">None (Main Category)</option>
                            <?php
                            include __DIR__ . '/../configs/db.php'; // Include database connection
                            $categoryQuery = $conn->query("SELECT category_id, name FROM categories WHERE parent_category_id IS NULL");
                            while ($row = $categoryQuery->fetch_assoc()) {
                                echo '<option value="' . $row["category_id"] . '">' . $row["name"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
