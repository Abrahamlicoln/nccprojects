<?php
include 'include/header.php';
include 'class/class.php';
$library = new physical_library();
$books = $library->retrieve_book();
$publication = $library->publication();
$category = $library->category();

?>
<?php
// Assuming $books is an array of book data
$booksPerPage = 12; // Number of books to display per page
$totalBooks = count($books);
$totalPages = ceil($totalBooks / $booksPerPage);

// Get the current page from the URL, or set it to 1 if not provided
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the starting index and ending index of books for the current page
$startIndex = ($currentPage - 1) * $booksPerPage;
$endIndex = min($startIndex + $booksPerPage, $totalBooks);

?>
<main>
  <div class="container">
    <div class="mt-4">
      <div class="row">
        <div class="col-md-3">
          <div class="card border-gray rounded-4">
            <div class="card-body">
              <h5 class="card-title text-secondary">Categories</h5>
              <hr class="mt-3 w-100">
              <?php
              foreach ($category as $book) { ?>
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" value="<?php echo $book['category_name']; ?>" name="categories" id="<?php echo $book['category_name']; ?>">
                  <label class="form-check-label" for="<?php echo $book['category_name']; ?>"><?php echo $book['category_name']; ?></label>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
      
        <div class="mt-4">
          <div class="card border-gray rounded-4">
            <div class="card-body">
              <h5 class="card-title text-secondary">Keyword</h5>
              <hr class="mt-3 w-100">
              <div class="mb-2">
                <label for="bookTitle" class="mb-1">Book Title</label>
                <input type="text" class="form-control" placeholder="Enter Book Title Here" name="bookTitle" id="bookTitle">
              </div>
              <div class="mb-2">
                <label for="authorNames" class="mb-1">Author(s) Names</label>
                <input type="text" class="form-control" placeholder="Search by Author(s) name" name="authorNames" id="authorNames">
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4 mb-3">
          <div class="card border-gray rounded-4">
            <div class="card-body">
              <h5 class="card-title text-secondary">Filter by Year</h5>
              <hr class="mt-3 w-100">
              <div class="mb-2">
                <input type="range" class="form-range" min="<?php echo $publication['min_year']; ?>" max="<?php echo $publication['max_year']; ?>" id="customRange2">
                <label for="customRange2" id="yearLabel"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="row">
        <div class="row" id="bookList">
          <?php
          // Loop through the books for the current page
          for ($i = $startIndex; $i < $endIndex; $i++) {
            $book = $books[$i];
          ?>

            <div class="col-md-3 mb-2">
              <div class="card h-100" style="width:238px;">
                <img src="migration/book_folder/<?php echo $book['front_image'] ?>" style="height:250px;" class="p-1" width="230px;" alt="...">
                <div class="card-body d-flex flex-column">
                  <h5>
                    <a href="single?bookId=<?php echo $book['id']; ?>"><?php echo $book['book_title']; ?></a><br>
                    <span class="text-secondary py-2" style="font-size: 13px;"><?php echo $book['category_name']; ?></span>
                  </h5>
                </div>
              </div>
            </div>
          <?php
          }
          ?>

        </div>
        </div>

        <!-- Pagination links -->
        <nav aria-label="Books Pagination">
          <ul class="pagination justify-content-center mt-3">
            <?php
            // Generate pagination links
            for ($page = 1; $page <= $totalPages; $page++) {
              $isActive = ($page === $currentPage) ? 'active' : '';
            ?>
              <li class="page-item <?php echo $isActive; ?>">
                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
              </li>
            <?php
            }
            ?>
          </ul>
        </nav>

      </div>
    </div>
  </div>
  </div>
</main>
<?php
include 'include/footer.php';
