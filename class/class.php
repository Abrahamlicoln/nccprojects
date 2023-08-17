<?php
class physical_library
{
    private $conn;
    function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "nccdb");
    }

    function retrieve_book()
    {
        $select = "SELECT * FROM books_info ORDER BY date_insert DESC";
        $query = mysqli_query($this->conn, $select);
        if (mysqli_num_rows($query) > 0) {
            $books = array();
            while ($row = mysqli_fetch_assoc($query)) {
                $books[] = $row;
            }
            return $books;
        }
    }
    function category()
    {

        $select = "SELECT category_name FROM books_info GROUP BY category_name ORDER BY category_name ASC ";
        $query = mysqli_query($this->conn, $select);
        if (mysqli_num_rows($query) > 0) {
            $category = array();
            while ($row = mysqli_fetch_assoc($query)) {
                $category[] = $row;
            }
            return $category;
        }
    }
    function publication() {
   
        $selectMinMax = "SELECT MIN(year_of_publication) AS min_year, MAX(year_of_publication) AS max_year FROM books_info";
        $queryMinMax = mysqli_query($this->conn, $selectMinMax);
        $publicationYears = mysqli_fetch_assoc($queryMinMax);
    
        return $publicationYears;
    }
    function single_book($book_id){
        $select = "SELECT * FROM books_info WHERE id = '$book_id'";
        $query = mysqli_query($this->conn, $select);
        if (mysqli_num_rows($query) > 0) {
            $information = array();
            while ($row = mysqli_fetch_assoc($query)) {
                $information[] = $row;
            }
            return $information;
        }
    }
    function related_category($category_name,$bookid)
    {
        $select = "SELECT * FROM books_info WHERE category_name = '$category_name' AND id != '$bookid' ORDER BY RAND() LIMIT 6";
        $query = mysqli_query($this->conn, $select);
        if (mysqli_num_rows($query) > 0) {
            $category = array();
            while ($row = mysqli_fetch_assoc($query)) {
                $category[] = $row;
            }
            return $category;
        }
    }
}
