<?php ob_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("adminHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");

?>

<div class="container-xxl py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title bg-white text-center text-primary px-4">🗞️ Delete News Article</h2>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 col-md-10">

                <?php
                if (!$db) {
                    echo "<div class='alert alert-danger fw-bold text-center'>
                            ❌ <strong>Database Error:</strong> Unable to connect - " . mysqli_connect_error() . "
                          </div>";
                } elseif (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                    echo "<div class='alert alert-warning fw-bold text-center'>
                            ⚠️ <strong>Invalid Request:</strong> No valid news ID provided.
                          </div>";
                } else {
                    $news_id = intval($_GET['id']);

                    $check = mysqli_query($db, "SELECT * FROM news WHERE id = $news_id");

                    if (mysqli_num_rows($check) == 0) {
                        echo "<div class='alert alert-warning fw-bold text-center'>
                                🚫 <strong>Not Found:</strong> News article doesn't exist or has already been deleted.
                              </div>";
                    } else {
                        $delete = mysqli_query($db, "DELETE FROM news WHERE id = $news_id");

                        if ($delete) {
                            echo "<div class='alert alert-success fw-bold text-center'>
                                    ✅ <strong>Deleted Successfully:</strong> The news article has been permanently removed.
                                  </div>";
                        } else {
                            echo "<div class='alert alert-danger fw-bold text-center'>
                                    ❌ <strong>Error:</strong> Something went wrong while deleting the news article.
                                  </div>";
                        }
                    }
                }
                ?>

                <div class="text-center mt-4">
                    <a href="all_category_news.php" class="btn btn-outline-primary fw-bold px-5 py-2">
                        ← Back to News Panel
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
