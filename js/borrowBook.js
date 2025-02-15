document.addEventListener("DOMContentLoaded", function () {
  const borrowForm = document.getElementById("borrowForm");

  if (borrowForm) {
    borrowForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(borrowForm);

      fetch("controllers/BorrowBookController.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            alert(data.message);
            const button = document
              .getElementById(`row-${data.isbn}`)
              .querySelector(".borrow-book");
            button.classList.remove("btn-primary");
            button.classList.add("btn-warning");
            button.textContent = "Return";
            button.setAttribute("data-copy-id", data.copy_id); // Store copy ID for returning
            button.classList.add("return-book");
            var borrowBookModal = bootstrap.Modal.getInstance(
              document.getElementById("borrowBookModal")
            );
            borrowBookModal.hide();
          } else {
            alert(data.message);
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  }

  // Handle returning books
  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("return-book")) {
      const copyId = event.target.getAttribute("data-copy-id");

      if (!copyId) {
        alert("Error: Copy ID missing.");
        return;
      }

      const formData = new FormData();
      formData.append("copy_id", copyId);

      fetch("controllers/ReturnBookController.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            alert(data.message);
            event.target.classList.remove("btn-warning");
            event.target.classList.add("btn-primary");
            event.target.textContent = "Borrow";
            event.target.classList.remove("return-book");
            event.target.classList.add("borrow-book");
          } else {
            alert(data.message);
          }
        })
        .catch((error) => console.error("Error:", error));
    }
  });
});
