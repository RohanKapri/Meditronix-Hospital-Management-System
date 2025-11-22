<?php ob_start(); ?>
<?php
include("adminHeader.php");

// ✅ DB Connection
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("<div class='alert alert-danger text-center mt-5'>❌ Connection failed: " . mysqli_connect_error() . "</div>");
}

$id = $_GET['id'];
$query = "DELETE FROM services WHERE id = $id";
?>

<!-- ✅ Content Container Start -->
<div class="container mt-5 pt-5" style="margin-top: 100px;"> <!-- Adjust this value as per your header height -->
    <?php
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-danger text-center fw-semibold'>
                🗑️ Service has been successfully deleted from the system.
              </div>";
    } else {
        echo "<div class='alert alert-warning text-center fw-semibold'>
                ❌ Failed to delete the service: " . mysqli_error($db) . "
              </div>";
    }
    ?>

    <!-- ✅ Back Button -->
    <div class="text-center mt-4">
        <a href='all_category_services.php' class='btn btn-primary'>← Back to Services List</a>
    </div>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
