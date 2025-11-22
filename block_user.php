<?php
$db = mysqli_connect("localhost", "root", "", "users");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($db, "UPDATE users SET status='inactive' WHERE id='$id'");
    header("Location: all_category_users.php?msg=🚫 User has been successfully blocked.");
    exit;
}
?>
