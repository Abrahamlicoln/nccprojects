$(document).ready(function() {
  // Function to update books based on category and keyword
  function updateBooks() {
    var selectedCategories = [];
    var bookTitle = $("#bookTitle").val();
    var authorNames = $("#authorNames").val();

    // Get selected category checkboxes
    $(".form-check-input:checked").each(function() {
      selectedCategories.push($(this).val());
    });

    // Ajax request to filter books
    $.ajax({
      type: "POST",
      url: "ajax.php", // Create a PHP file to handle the Ajax request
      data: {
        categories: selectedCategories, // Send the selected categories as an array
        bookTitle: bookTitle,
        authorNames: authorNames
      },
      dataType: "html",
      success: function(data) {
        // Update the book list with the filtered results
        var maxBooksToShow = 12;
        var bookListContainer = $("#bookList");
        bookListContainer.html(data);

        // Get all the book items in the container
        var bookItems = bookListContainer.find(".col-md-3.mb-2");

        // Hide any extra book items if the number of filtered books exceeds 12
        if (bookItems.length > maxBooksToShow) {
          bookItems.slice(maxBooksToShow).hide();
        }
      }
    });
  }

  // Event listeners for category and keyword input changes
  $(".form-check-input, #bookTitle, #authorNames").on("change keyup", function() {
    updateBooks();
  });

  // Initial update of books on page load
  updateBooks();
});
