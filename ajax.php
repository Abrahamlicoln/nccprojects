<?php
// Include your class and functions here
include 'class/class.php';
$library = new physical_library();

// Get the posted data from Ajax request
if(isset($_POST['categories'])) {
  $selectedCategories = $_POST['categories'];
  // Rest of the code for filtering books based on categories and keywords
} else {
  // Handle the case when 'categories' index is not defined
  // For example, you can return all books if no specific category is selected
  $selectedCategories = [];
}
$bookTitle = $_POST['bookTitle'];
$authorNames = $_POST['authorNames'];

// Fetch all books from the database
$books = $library->retrieve_book();

// Filter books based on selected categories and keywords
$filteredBooks = array_filter($books, function ($book) use ($selectedCategories, $bookTitle, $authorNames) {
  return (
    (empty($selectedCategories) || in_array($book['category_name'], $selectedCategories)) &&
    (empty($bookTitle) || stripos($book['book_title'], $bookTitle) !== false) &&
    (empty($authorNames) || stripos($book['author_names'], $authorNames) !== false)
  );
});

// Generate HTML for filtered books
$booksHTML = '';
foreach ($filteredBooks as $book) {
  $booksHTML .= '
    <div class="col-md-3 mb-2">
      <div class="card h-100" style="width:238px;">
        <img src="migration/book_folder/' . $book['front_image'] . '" style="height:250px;" class="p-1" width="230px;" alt="...">
        <div class="card-body d-flex flex-column">
          <h5>
            <a href="single?bookId=' . $book['id'] . '">' . $book['book_title'] . '</a><br>
            <span class="text-secondary py-2" style="font-size: 13px;">' . $book['category_name'] . '</span>
          </h5>
        </div>
      </div>
    </div>
  ';
}

// Return the filtered books HTML
echo $booksHTML;
?>
