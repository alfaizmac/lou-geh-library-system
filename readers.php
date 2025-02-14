<?php
// Database connection
include 'configs/db.php';

// Alert messages based on action
$alertMessage = "";
if (isset($_GET['success'])) {
    $alertMessage = '<div id="alert-message" class="alert alert-success" style="background-color: rgba(40, 167, 69, 0.8);">
                        <svg width="40" height="40" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 22a9.97 9.97 0 0 0 7.071-2.929A9.97 9.97 0 0 0 22 12a9.969 9.969 0 0 0-2.929-7.071A9.969 9.969 0 0 0 12 2a9.969 9.969 0 0 0-7.071 2.929A9.969 9.969 0 0 0 2 12a9.969 9.969 0 0 0 2.929 7.071A9.969 9.969 0 0 0 12 22Z"></path>
<path d="m8 12 3 3 6-6"></path>
</svg> Reader added successfully!
                    </div>';
} elseif (isset($_GET['error'])) {
    $alertMessage = '<div id="alert-message" class="alert alert-danger" style="background-color: rgba(220, 53, 69, 0.8);">
                        ❌ Error processing request!
                    </div>';
} elseif (isset($_GET['removed'])) {
    $alertMessage = '<div id="alert-message" class="alert alert-warning" style="background-color: rgba(255, 193, 7, 0.8);">
                        <svg width="40" height="40" fill="#664d03" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10Zm0-2a8 8 0 1 0 0-16.001A8 8 0 0 0 12 20Zm0-10a1 1 0 0 1 1 1v5a1 1 0 0 1-2 0v-5a1 1 0 0 1 1-1Zm0-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"></path>
</svg> Reader removed successfully!
                    </div>';
}

// Fetch readers from database
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT reader_ID, first_name, last_name, city, date_of_birth FROM readers WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR city LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lou Geh | Readers</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="partials/style.css" />
</head>
<body>

    <?php include 'partials/sidebar.php'; ?>

    <div class="container-mt-4">
        <!-- Alert Message -->
        <?php if (!empty($alertMessage)) echo $alertMessage; ?>

        <div class="d-flex justify-content-between align-items-center">
            <h2>Readers</h2>
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
        <input type="text" name="search" class="form-control" placeholder="Search by name or city" value="<?php echo htmlspecialchars($search ?? ''); ?>">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReaderModal">
        <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2Zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9Zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3h2Z"></path>
                </svg> Add Reader
            </button>
    </div>
            </form>


        <!-- Readers Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Reader ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>City</th>
                        <th>Date of Birth</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['reader_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['city']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                            <td>
                                <form action="actions/remove_reader.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this reader?');">
                                    <input type="hidden" name="reader_id" value="<?php echo $row['reader_ID']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <!-- Include the Modal -->
    <?php include 'partials/add_reader_modal.php'; ?>

    <script>
        // Auto-hide alert after 3 seconds
        setTimeout(function() {
            let alertBox = document.getElementById("alert-message");
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.style.display = "none", 500);
            }
        }, 2000);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
