<?php
include("adminHeader.php");
?>

<!-- Contact Start -->
<div class="container-xxl py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h4 class="section-title bg-white text-center text-primary px-5">ADD CATEGORY PAGE</h4>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12 wow fadeInUp" data-wow-delay="0.5s">
                <form action="" method="post" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
                    <div class="row g-3">

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name" required>
                                <label for="category_name">Category Name</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="category_password" placeholder="Password" name="category_password" required>
                                <label for="category_password">Password</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="category_image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="category_image" id="category_image" accept="image/*" required>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit" name="submit_button">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<?php

if(isset($_POST["submit_button"])){

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $catName = $_POST["category_name"];   

    $db = mysqli_connect("localhost","root","","meditronix_new");

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $catName = mysqli_real_escape_string($db, $catName);

   
    $query = "INSERT INTO `category`(`name`) VALUES ('$catName')";

    $result = mysqli_query($db, $query);

    if($result){
        echo "<div class='text-center text-success mt-3'>Category Added Successfully!</div>";
    } else {
        echo "<div class='text-center text-danger mt-3'>Failed to Add Category: " . mysqli_error($db) . "</div>";
    }
}
?>

<?php
include("adminFooter.php");
?>
