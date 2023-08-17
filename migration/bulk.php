
<?php
include 'connection.php';
// Set the path to the book_to_copy folder
$bookToCopyPath = 'book_to_copy';

// Function to convert a string to sentence case, excluding specific words
function toSentenceCase($str) {
    $smallWords = array('a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'per', 'the', 'to');
    $words = preg_split('/\s/', strtolower($str));
    foreach ($words as $key => $word) {
        if ($key === 0 || !in_array($word, $smallWords)) {
            $words[$key] = ucfirst($word);
        }
    }
    return implode(' ', $words);
}

// Get a list of all files and folders inside book_to_copy
$items = scandir($bookToCopyPath);

foreach ($items as $item) {
    if ($item === '.' || $item === '..') {
        continue; // Skip the current and parent directory entries
    }

    // Create a folder with the category_name
    $categoryName = toSentenceCase($item);
    $categoryFolderPath = $bookToCopyPath . '/' . $categoryName;
    if (!is_dir($categoryFolderPath)) {
        mkdir($categoryFolderPath);
    }

    // Iterate through each folder inside the category_name folder
    $subItems = scandir($categoryFolderPath);
    foreach ($subItems as $subItem) {
        if ($subItem === '.' || $subItem === '..') {
            continue; // Skip the current and parent directory entries
        }

        // Extract book information from the folder name
        $folderName = $subItem;
        $matches = [];
        $pattern = '/^(.*?) BY (.*?) IN (.*?)$/';
        preg_match($pattern, $folderName, $matches);

        if (count($matches) !== 4) {
            continue; // Skip if the folder name format doesn't match
        }

        $bookTitle = trim($matches[1]);
        $authorNames = trim($matches[2]);
        $publicationYear = trim($matches[3]);

        // Convert book title and author names to sentence case
        $bookTitle = toSentenceCase($bookTitle);
        $authorNames = toSentenceCase($authorNames);

        // Rename the first and second files
        $files = scandir($categoryFolderPath . '/' . $folderName);
        $bookTitleBack = $bookTitle . '_back.' . pathinfo($files[2], PATHINFO_EXTENSION);
        $bookTitleFront = $bookTitle . '_front.' . pathinfo($files[3], PATHINFO_EXTENSION);
        $bookTitleBack = str_replace(' ', '_', $bookTitleBack);
        $bookTitleFront = str_replace(' ', '_', $bookTitleFront);
        rename($categoryFolderPath . '/' . $folderName . '/' . $files[2], $categoryFolderPath . '/' . $bookTitleBack);
        rename($categoryFolderPath . '/' . $folderName . '/' . $files[3], $categoryFolderPath . '/' . $bookTitleFront);

        // Move the renamed files to the book_folder
        $bookFolderPath = 'book_folder';
        if (!is_dir($bookFolderPath)) {
            mkdir($bookFolderPath);
        }
        rename($categoryFolderPath . '/' . $bookTitleBack, $bookFolderPath . '/' . $bookTitleBack);
        rename($categoryFolderPath . '/' . $bookTitleFront, $bookFolderPath . '/' . $bookTitleFront);

        // Store book information in the database using prepared statement
        $sql = "INSERT INTO books_info (category_name, book_title, author_names, year_of_publication, front_image, back_image, date_insert) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Handle the error if preparation fails
            die("SQL statement preparation failed: " . mysqli_error($connection));
        }

        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssssss", $categoryName, $bookTitle, $authorNames, $publicationYear, $bookTitleFront, $bookTitleBack);

        // Execute the statement
        if (!mysqli_stmt_execute($stmt)) {
            // Handle the error if execution fails
            die("SQL statement execution failed: " . mysqli_stmt_error($stmt));
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection
mysqli_close($connection);
