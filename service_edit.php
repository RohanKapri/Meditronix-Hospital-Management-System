<?php ob_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("adminHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='text-danger text-center mt-5'>Invalid Request: Service ID is missing.</div>";
    exit;
}

$id = intval($_GET['id']);
$service = mysqli_query($db, "SELECT * FROM services WHERE id = $id LIMIT 1");

if (mysqli_num_rows($service) === 0) {
    echo "<div class='text-danger text-center mt-5'>Service not found.</div>";
    exit;
}

$data = mysqli_fetch_assoc($service);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $fee = floatval($_POST['fee']);
    $status = mysqli_real_escape_string($db, $_POST['status']);

    $updateQuery = "UPDATE services SET name='$name', description='$description', fee='$fee', status='$status' WHERE id=$id";

    if (mysqli_query($db, $updateQuery)) {
        header("Location: all_category_services.php?updated=success");
        exit;
    } else {
        echo "<div class='text-danger text-center mt-4'>❌ Failed to update service. Error: " . mysqli_error($db) . "</div>";
    }
}
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .edit-container {
        max-width: 1000px;
        margin: 100px auto;
        padding: 50px 60px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 10px;
    }

    .section-subtitle {
        font-size: 16px;
        color: #6c757d;
        margin-bottom: 30px;
    }

    .form-control {
        height: 50px;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 12px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
    }

    textarea.form-control {
        height: 200px !important;
        padding: 20px;
        resize: vertical;
        font-size: 16px;
    }

    .btn-primary {
        padding: 12px 40px;
        font-size: 18px;
        border-radius: 30px;
        font-weight: 600;
    }

    .btn-secondary {
        padding: 12px 40px;
        font-size: 18px;
        border-radius: 30px;
        font-weight: 600;
        margin-left: 10px;
    }

    .button-row {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
</style>

<div class="edit-container">
    <div class="text-center">
        <h2 class="section-title">✏️ Update Service Details</h2>
        <p class="section-subtitle">Use the form below to modify and update this service's information.</p>
    </div>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label fw-bold">Service Name</label>
            <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($data['name']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($data['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Fee (INR)</label>
            <input type="number" step="0.01" name="fee" class="form-control" required value="<?php echo htmlspecialchars($data['fee']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select" required>
                <option value="active" <?php if ($data['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($data['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </div>

        <div class="button-row">
            <a href="all_category_services.php" class="btn btn-secondary">🔙 Cancel</a>
            <button type="submit" class="btn btn-primary">💾 Save Changes</button>
        </div>
    </form>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
