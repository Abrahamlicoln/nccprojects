<?php
session_start();
include 'include/header.php';
include 'class/class.php';
$library = new physical_library();

if (isset($_GET['bookId'])) {
    $bookid = $_GET['bookId'];
    $information = $library->single_book($bookid);

        $related = $library->related_category($_SESSION['category'],$bookid);
  
}

?>
<?php
foreach ($information as $data) {
$_SESSION['category'] = $data['category_name'];
?>
    <div class="container">
        <div class="mt-4 mb-4">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?php echo $data['category_name']; ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $data['book_title']; ?></li>
                </ol>
            </nav>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card border-gray rounded-4">
                        <div class="card-body">
                            <section class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">


                                        <li class="splide__slide"><img src="migration/book_folder/<?php echo $data['front_image']; ?>" class="img-fluid rounded-3" alt=""></li>
                                        <li class="splide__slide"><img src="migration/book_folder/<?php echo $data['back_image']; ?>" class="img-fluid rounded-3" alt=""></li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-gray rounded-4">
                        <div class="card-body">
                            <div class="mt-3 mb-3">

                                <h2 style="font-weight:600;"><?php echo $data['book_title']; ?></h2>
                                <p style="font-size:14px; color:grey; font-weight:200;">Author(s): <span style="color:black; font-weight:300"><?php echo $data['author_names']; ?></span> </p>
                                <!-- <p style="font-size:14px; color:grey; font-weight:200;">ISBN: <span style="color:black; font-weight:300">ISBN594049</span> </p> -->
                                <p style="font-size:14px; color:grey; font-weight:200;">Publication Year: <span style="color:black; font-weight:300"><?php echo $data['year_of_publication']; ?></span> </p>
                                <hr class="text-secondary">
                                <p class="text-secondary fs-5">This book can be located in the <?php echo $data['category_name']; ?> Category(s)</p>
                                <hr class="text-secondary">
                                <p style="font-size:16px; color:grey; font-weight:200;">Category: <span style="color:black; font-weight:300"><?php echo $data['category_name']; ?></span> </p>
                                <!-- <p style="font-size:16px; color:grey; font-weight:200;">Tag: <span style="color:black; font-weight:300">Book</span> </p> -->
                            <?php
                        }
                            ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="mt-5 mb-5">
            <div class="row">
                <div class="side-border">
                    <h2>Related Books</h2>
                    <hr>
                </div>
                <div class="container">
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                <?php
            foreach ($related as $category) { ?>
              <div class="col-md-2 mb-2">
                <div class="card d-flex flex-column h-100">
                  <img src="migration/book_folder/<?php echo $category['front_image'] ?>" style="height:400px; object-fit:cover;" class="img-fluid rounded-3" alt="...">
                  <div class="card-body d-flex flex-column">
                    <h5>
                    <a href="single?bookId=<?php echo $category['id']; ?>"><?php echo $category['book_title']; ?></a><br>
                      <span class="text-secondary py-2" style="font-size: 13px;"><?php echo $category['category_name']; ?></span>
                    </h5>
                  </div>
                </div>
              </div>


            <?php
            }
            ?>
                                    

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    include 'include/footer.php';
    ?>