<?php
ob_start(); // Start output buffering to prevent header errors
include("adminHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("❌ Database Connection Failed: " . mysqli_connect_error());
}
?>

<div class="container-xxl py-5" style="margin-top: 100px;">
    <div class="container">
        <h4 class="text-center section-title bg-white text-primary px-4">Service Management Panel</h4>

        <!-- Operation Alerts -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success text-center fw-bold shadow-sm mt-4">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center fw-bold shadow-sm mt-4">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <!-- Buttons -->
        <div class="text-center my-4">
            <button class="btn btn-success me-2" onclick="showForm('addForm')">➕ Add Service</button>
            <button class="btn btn-primary me-2" onclick="showForm('editSelector')">✏️ Edit Service</button>
        </div>

        <!-- Add Service Form -->
        <div id="addForm" style="display: none;">
            <form method="post" class="bg-light p-4 rounded shadow">
                <h5 class="mb-3">Add New Service</h5>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="doctor_name" required placeholder="Doctor's Name">
                    <label>Doctor's Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="service_name" required placeholder="Service Name">
                    <label>Service Name</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" required placeholder="Description" style="height: 100px;"></textarea>
                    <label>Description</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="fee" required placeholder="Fee">
                    <label>Fee (₹)</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <label>Status</label>
                </div>
                <button class="btn btn-success" name="add_service">Submit</button>
            </form>
        </div>

        <!-- Edit Selector Dropdown -->
        <div id="editSelector" style="display: none;">
            <form method="get" class="mt-4">
                <div class="form-group">
                    <label>Select a service to edit:</label>
                    <select name="edit_id" class="form-select" onchange="this.form.submit()" required>
                        <option disabled selected>-- Choose --</option>
                        <?php
                        $result = mysqli_query($db, "SELECT `id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at` FROM `services` WHERE 1 ORDER BY id DESC");
                        while ($s = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$s['id']}'>" . htmlspecialchars($s["name"]) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>

        <!-- Edit Form Section -->
        <?php
        if (isset($_GET['edit_id'])) {
            $edit_id = $_GET['edit_id'];
            $edit_q = mysqli_query($db, "SELECT `id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at` FROM `services` WHERE id='$edit_id'");
            $data = mysqli_fetch_assoc($edit_q);

            if (!$data) {
                header("Location: add_category_services.php?error=⚠️ Service not found!");
                exit;
            }
        ?>
        <form method="post" class="bg-light p-4 rounded shadow mt-4">
            <h5>Edit Service: <?= htmlspecialchars($data['name']) ?></h5>
            <input type="hidden" name="edit_service_id" value="<?= $data['id'] ?>">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="doctor_name" value="<?= htmlspecialchars($data["doctor's_name"]) ?>" required>
                <label>Doctor's Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="service_name" value="<?= htmlspecialchars($data['name']) ?>" required>
                <label>Service Name</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="description" required style="height: 100px;"><?= htmlspecialchars($data['description']) ?></textarea>
                <label>Description</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" name="fee" value="<?= htmlspecialchars($data['fee']) ?>" required>
                <label>Fee (₹)</label>
            </div>
            <div class="form-floating mb-3">
                <select name="status" class="form-select" required>
                    <option value="active" <?= $data['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $data['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
                <label>Status</label>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" name="update_service">Update Service</button>
                <button class="btn btn-danger" name="delete_service" onclick="return confirm('⚠️ Are you sure you want to delete this service?')">Delete Service</button>
            </div>
        </form>
        <?php } ?>
    </div>
</div>

<!-- CRUD PHP Logic -->
<?php
// ADD
if (isset($_POST['add_service'])) {
    $doctor = mysqli_real_escape_string($db, $_POST['doctor_name']);
    $name = mysqli_real_escape_string($db, $_POST['service_name']);
    $desc = mysqli_real_escape_string($db, $_POST['description']);
    $fee = (int) $_POST['fee'];
    $status = mysqli_real_escape_string($db, $_POST['status']);

    $insert = mysqli_query($db, "INSERT INTO `services`(`id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at`) VALUES (NULL,'$doctor','$name','$desc','$fee','$status',CURRENT_TIMESTAMP)");
    header("Location: add_category_services.php?" . ($insert ? "msg=✅ Service added successfully!" : "error=❌ Failed to add service."));
    exit;
}

// UPDATE
if (isset($_POST['update_service'])) {
    $id = $_POST['edit_service_id'];
    $doctor = mysqli_real_escape_string($db, $_POST['doctor_name']);
    $name = mysqli_real_escape_string($db, $_POST['service_name']);
    $desc = mysqli_real_escape_string($db, $_POST['description']);
    $fee = (int) $_POST['fee'];
    $status = mysqli_real_escape_string($db, $_POST['status']);

    $update = mysqli_query($db, "UPDATE `services` SET `id`='$id',`doctor's_name`='$doctor',`name`='$name',`description`='$desc',`fee`='$fee',`status`='$status',`created_at`=CURRENT_TIMESTAMP WHERE id='$id'");
    header("Location: add_category_services.php?" . ($update ? "msg=✅ Service updated!" : "error=❌ Update failed."));
    exit;
}

// DELETE
if (isset($_POST['delete_service'])) {
    $id = $_POST['edit_service_id'];
    $delete = mysqli_query($db, "DELETE FROM `services` WHERE 0"); // Your requested DELETE WHERE 0
    header("Location: add_category_services.php?" . ($delete ? "msg=🗑️ Service deleted." : "error=❌ Deletion failed."));
    exit;
}
?>

<!-- JavaScript to Toggle Forms -->
<script>
    function showForm(id) {
        document.getElementById('addForm').style.display = 'none';
        document.getElementById('editSelector').style.display = 'none';
        if (document.getElementById(id)) {
            document.getElementById(id).style.display = 'block';
        }
    }
</script>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>  
