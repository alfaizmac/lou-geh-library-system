<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lou Geh | Books</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f4f5f9;">


        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/add_book_modal.php'; ?>
        <?php include 'partials/add_publisher_modal.php'; ?>
        <?php include 'partials/add_category_modal.php'; ?>
        <?php include 'partials/borrow_book_modal.php'; ?>
        <?php include 'partials/add_reader_modal.php'; ?>
        <?php include 'partials/borrow_logs_modal.php'; ?>
        

        <?php 
        $alertMessage = "";
        if (isset($_GET['success'])) {
            $alertMessage = '<div id="alert-message" class="alert alert-success">
                                <svg width="40" height="40" fill="none" stroke="#0a3522" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 22a9.97 9.97 0 0 0 7.071-2.929A9.97 9.97 0 0 0 22 12a9.969 9.969 0 0 0-2.929-7.071A9.969 9.969 0 0 0 12 2a9.969 9.969 0 0 0-7.071 2.929A9.969 9.969 0 0 0 2 12a9.969 9.969 0 0 0 2.929 7.071A9.969 9.969 0 0 0 12 22Z"></path>
        <path d="m8 12 3 3 6-6"></path>
        </svg> ' . htmlspecialchars($_GET['success']) . '
                            </div>';
        } elseif (isset($_GET['error'])) {
            $alertMessage = '<div id="alert-message" class="alert alert-danger">
                                ❌ ' . htmlspecialchars($_GET['error']) . '
                            </div>';
        }
        echo $alertMessage;

        ?>





<div class="container-mt-4">
    <!-- Alert Message (if any) -->
    <?php if (!empty($alertMessage)) echo $alertMessage; ?>

    <div class="d-flex justify-content-between align-items-center">
        <h2>Books Management</h2>
    </div>
    <br>
    <div class="TableSearchBar">
        <!-- Search Bar -->
        <form method="GET" class="my-3">
            <div class="input-group">
                <span class="input-group-text">
                    <svg width="20" height="20" fill="#0b5ed7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 16.5a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm6.32-1.094 3.58 3.58a.998.998 0 0 1-.318 1.645.999.999 0 0 1-1.098-.232l-3.58-3.58a8 8 0 1 1 1.415-1.413Z"></path>
                    </svg>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Search by title, author, or ISBN" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <div class="ButtonsTable">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowLogsModal">
                    <svg width="20" height="20" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.5 5h-14v17h14V5Z"></path>
                        <path d="M17.5 5V2H4a.5.5 0 0 0-.5.5V19h3"></path>
                        <path d="M10.5 11h6"></path>
                        <path d="M10.5 15h6"></path>
                    </svg>
                    Borrow Logs
                </button>



                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10Zm0-2a8 8 0 1 0 0-16.001A8 8 0 0 0 12 20Zm1-7v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4a1 1 0 0 1 0 2h-4Z"></path>
                </svg> Add New Book
                </button>
                </div>
            </div>
        </form>

        <!-- Books Table -->
        <div class="table-responsive">
            <style>
                .table th, .table td {
                    text-align: center;
                    vertical-align: middle;
                    padding: 5px;
                }
                .category-column {
                    word-break: break-word;
                    max-width: 150px;
                }
            </style>

            <table class="table table-bordered text-center">
                <thead class="table-dark">

                <style>
                    .table-responsive th {
                    background: #007bff;
                    color: #fff;
                    border: 1px solid #007bff;
                    }
            </style>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th> 
                        <th>Publication Year</th>
                        <th>Pages</th>
                        <th>Publisher</th>
                        <th>Publisher Location</th>
                        <th>Categories</th>
                        <th>Shelf Location</th>
                        <th>Availability</th>
                        <th>Book Image</th>
                        <th><svg width="30" height="30" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m2.23 6.42 8.888-1.888a1 1 0 0 1 .752.14L15.92 7.3a1 1 0 0 0 .752.14l2.04-.434a1 1 0 0 1 1.186.77l.312 1.467a1 1 0 0 1-.77 1.186l-3.507.746a1 1 0 0 1-.753-.14l-4.05-2.63a1 1 0 0 0-.752-.139l-1.551.33"></path>
                            <path d="m21.77 16.58-8.888 1.889a1 1 0 0 1-.752-.14L8.08 15.7a1 1 0 0 0-.752-.139l-2.04.434a1 1 0 0 1-1.186-.77l-.312-1.468a1 1 0 0 1 .77-1.186l3.507-.745a1 1 0 0 1 .753.14l4.05 2.629a1 1 0 0 0 .752.14l1.551-.33"></path>
                        </svg></th>
                        <th><svg width="30" height="30" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.5 4 3 7l3.5 3.5"></path>
                            <path d="M3 7h11.497c3.441 0 6.364 2.81 6.498 6.25.142 3.635-2.861 6.75-6.498 6.75H5.999"></path>
                        </svg></th>
                        <th><svg width="30" height="30" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m7.5 6 .6-3.5h7.8l.6 3.5"></path>
                            <path d="M3 6h18"></path>
                            <path d="m18.5 6-1 15.5h-11L5.5 6h13Z" clip-rule="evenodd"></path>
                            <path d="M9.5 17.5h5"></path>
                        </svg></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'configs/db.php';

                    // Capture search query
                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    // Modify SQL query to filter based on search input
                    $sql = "SELECT books.*, publishers.name AS publisher_name, publishers.location AS publisher_location, 
                                   book_copies.shelf_location, book_copies.availability, book_copies.copy_id
                            FROM books 
                            LEFT JOIN publishers ON books.publisher_id = publishers.publisher_id
                            LEFT JOIN book_copies ON books.isbn = book_copies.isbn
                            WHERE books.title LIKE ? OR books.author LIKE ? OR books.isbn LIKE ?";
                    
                    $stmt = $conn->prepare($sql);
                    $searchTerm = "%" . $search . "%";
                    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr id='row-{$row['isbn']}'>";
                            echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                            echo "<td class='p-2 category-column'>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['publication_year']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['number_of_pages']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['publisher_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['publisher_location']) . "</td>";
                            echo "<td class='p-2 category-column'>" . htmlspecialchars($row['categories']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['shelf_location']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['availability']) . "</td>";
                            echo "<td><img src='assets/images/books/" . htmlspecialchars($row['book_image']) . "' alt='Book Image' width='50'></td>";
                            
                            // Borrow Button
                            echo "<td><button class='btn btn-primary btn-sm borrow-book' data-copy-id='{$row['copy_id']}'>Borrow</button></td>";
                            // Return Button
                            echo "<td><button class='btn btn-success btn-sm return-book' data-copy-id='{$row['copy_id']}'>Return</button></td>";
                            // Remove Button
                            echo "<td><button class='btn btn-danger btn-sm delete-book' data-isbn='{$row['isbn']}'>Remove</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='14' class='text-center'>No books found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="js/borrowBookDisplay.js"></script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-book").forEach(button => {
        button.addEventListener("click", function() {
            let isbn = this.getAttribute("data-isbn");
            if (confirm("Are you sure you want to remove this book?")) {
                fetch("controllers/delete_book.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "isbn=" + isbn
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("row-" + isbn).remove();
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
});
</script>

<script>
    // Auto-hide alert after 2 seconds
    setTimeout(function() {
        let alertBox = document.getElementById("alert-message");
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.style.display = "none", 500);
        }
    }, 2000);
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("controllers/GetPublishers.php")
        .then(response => response.json())
        .then(data => {
            let publisherDropdown = document.getElementById("publisher");
            data.forEach(pub => {
                let option = document.createElement("option");
                option.value = pub.publisher_id;
                option.textContent = pub.name;
                publisherDropdown.appendChild(option);
            });
        });

    fetch("controllers/GetCategories.php")
        .then(response => response.json())
        .then(data => {
            let categoryDropdown = document.getElementById("category");
            data.forEach(cat => {
                let option = document.createElement("option");
                option.value = cat.category_id;
                option.textContent = cat.name;
                categoryDropdown.appendChild(option);
            });
        });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    function refreshDropdown(url, dropdownId) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = '<option value="">Select</option>';
                data.forEach(item => {
                    let option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    dropdown.appendChild(option);
                });
            });
    }

    refreshDropdown("controllers/GetPublishers.php", "publisher");
    refreshDropdown("controllers/GetCategories.php", "category");
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function refreshDropdown(url, dropdownId) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = '<option value="">Select</option>';
                data.forEach(item => {
                    let option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    dropdown.appendChild(option);
                });
            })
            .catch(error => console.error("Error loading data:", error));
    }

    refreshDropdown("controllers/GetPublishers.php", "publisher");
    refreshDropdown("controllers/GetCategories.php", "category");
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {  
    document.getElementById("addPublisherForm").addEventListener("submit", function(event) {
        let publisherName = document.getElementById("publisher_name").value.trim();
        let existingPublishers = Array.from(document.querySelectorAll("#publisher option")).map(opt => opt.textContent);

        if (existingPublishers.includes(publisherName)) {
            alert("This publisher already exists!");
            event.preventDefault();
        }
    });

    document.getElementById("addCategoryForm").addEventListener("submit", function(event) {
        let categoryName = document.getElementById("category_name").value.trim();
        let existingCategories = Array.from(document.querySelectorAll("#category option")).map(opt => opt.textContent);

        if (existingCategories.includes(categoryName)) {
            alert("This category already exists!");
            event.preventDefault();
        }
    });
});
</script>


</body>
</html>
