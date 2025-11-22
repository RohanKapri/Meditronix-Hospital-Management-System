
<?php ob_start(); ?>
<?php
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

    $update = mysqli_query($db, "UPDATE appointments SET status = '$action' WHERE id = $id");

    if ($update) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
<?php ob_end_flush(); ?>
