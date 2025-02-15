document.addEventListener("DOMContentLoaded", function () {
  // Borrow Book Button Logic
  const borrowButtons = document.querySelectorAll(".borrow-book");
  borrowButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const row = this.closest("tr");

      // Extract book details
      const bookImage = row.querySelector("img").src;
      const bookISBN = row.children[0].textContent;
      const bookTitle = row.children[1].textContent;
      const bookAuthor = row.children[2].textContent;
      const bookCategories = row.children[7].textContent;

      // Set values in modal
      document.getElementById("bookImage").src = bookImage;
      document.getElementById("bookISBN").textContent = bookISBN;
      document.getElementById("bookTitle").textContent = bookTitle;
      document.getElementById("bookAuthor").textContent = bookAuthor;
      document.getElementById("bookCategories").textContent = bookCategories;
      document.getElementById("hiddenISBN").value = bookISBN;

      // Show the modal
      var borrowBookModal = new bootstrap.Modal(
        document.getElementById("borrowBookModal")
      );
      borrowBookModal.show();
    });
  });

  // Return Book Button Logic
  const returnButtons = document.querySelectorAll(".return-book");
  returnButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const copyId = this.getAttribute("data-copy-id");

      // Confirm the return action
      if (confirm("Are you sure you want to return this book?")) {
        returnBook(copyId);
      }
    });
  });
});

// Function to handle returning a book
function returnBook(copyId) {
  // Send an AJAX request to the server
  fetch("controllers/ReturnBookController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `copy_id=${copyId}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        alert(data.message); // Show success message
        location.reload(); // Reload the page to reflect changes
      } else {
        alert("Error: " + data.message); // Show error message
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred while returning the book.");
    });
}
