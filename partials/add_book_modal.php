<!-- Add Book Modal -->
 
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBookForm" action="controllers/AddBookController.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- Upload Book Image -->
                    <div class="mb-3">
                        <label for="book_image" class="form-label">Upload Book Cover</label>
                        <input type="file" class="form-control" id="book_image" name="book_image" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="publication_year" class="form-label">Publication Year</label>
                        <input type="number" class="form-control" id="publication_year" name="publication_year" required>
                    </div>
                    <div class="mb-3">
                        <label for="num_pages" class="form-label">Number of Pages</label>
                        <input type="number" class="form-control" id="num_pages" name="num_pages" required>
                    </div>

                    <!-- Publisher Dropdown -->
                    <div class="mb-3">
                        <label for="publisher" class="form-label">Publisher</label>
                        <select class="form-control" name="publisher_id" required>
                            <option value="">Select Publisher</option>
                            <?php
                            include __DIR__ . '/../configs/db.php'; // Include database connection
                            $publisherQuery = $conn->query("SELECT * FROM publishers");
                            while ($row = $publisherQuery->fetch_assoc()) {
                                echo '<option value="' . $row["publisher_id"] . '">' . $row["name"] . '</option>';
                            }
                            ?>
                        </select>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addPublisherModal">+ Add New Publisher</button>
                    </div>

                    <!-- Category Checkboxes -->
                    <div class="mb-3">
                        <label class="form-label">Categories</label>
                        <hr>
                        <div id="category-checkboxes">
                            <?php
                            $categoryQuery = $conn->query("SELECT * FROM categories");
                            while ($row = $categoryQuery->fetch_assoc()) {
                                echo '<div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_names[]" value="' . $row["name"] . '" id="category_' . $row["category_id"] . '">
                                        <label class="form-check-label" for="category_' . $row["category_id"] . '">' . $row["name"] . '</label>
                                    </div>';
                            }
                            ?>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add New Category</button>
                    </div>

                    <div class="mb-3">
                        <label for="shelf_location" class="form-label">Shelf Location</label>
                        <input type="text" class="form-control" id="shelf_location" name="shelf_location" required>
                    </div>

                    <button type="submit" name="add_book" class="btn" style="background-color: #0b5ed7; color: white;">
                        Add Book
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
// Fetch publishers and populate dropdown
fetch("controllers/GetPublishers.php")
    .then(response => response.json())
    .then(data => {
        let publisherSelect = document.getElementById("publisher");
        publisherSelect.innerHTML = '<option value="">Select Publisher</option>';
        data.forEach(publisher => {
            let option = document.createElement("option");
            option.value = publisher.id;
            option.textContent = publisher.name;
            publisherSelect.appendChild(option);
        });
    })
    .catch(error => console.error("Error fetching publishers:", error));

// Fetch categories and populate dropdown
fetch("controllers/GetCategories.php")
    .then(response => response.json())
    .then(data => {
        let categoryContainer = document.getElementById("category-checkboxes");
        categoryContainer.innerHTML = ''; // Clear existing checkboxes
        data.forEach(category => {
            let checkbox = document.createElement("div");
            checkbox.classList.add("form-check");
            checkbox.innerHTML = `
                <input class="form-check-input" type="checkbox" name="category_names[]" value="${category.name}" id="category_${category.id}">
                <label class="form-check-label" for="category_${category.id}">${category.name}</label>
            `;
            categoryContainer.appendChild(checkbox);
        });
    })
    .catch(error => console.error("Error fetching categories:", error));
</script>
