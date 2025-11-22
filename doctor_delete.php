<?php ob_start(); ?>
<?php
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
$id = $_GET['id'];
$query = "DELETE FROM doctors WHERE id=$id";
if (mysqli_query($db, $query)) {
    header("Location: all_category_doctors.php");
    exit();
} else {
    echo "<div class='text-danger text-center'>Failed to delete record.</div>";
}
?>
<?php ob_end_flush(); ?>


