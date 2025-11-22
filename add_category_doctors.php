<?php ob_start(); ?>
<?php include("adminHeader.php"); ?>
<?php $db = mysqli_connect("localhost", "root", "", "meditronix_new"); ?>

<div class="container-xxl py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="text-center">
            <h4 class="section-title bg-white text-primary px-4">Doctor Management Panel</h4>
        </div>

        <div class="text-center my-4">
            <button class="btn btn-success me-2" onclick="showForm('addForm')">➕ Add Doctor</button>
            <button class="btn btn-primary" onclick="showForm('editSelector')">✏️ Edit Doctor</button>
        </div>

        <!-- Status Messages -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success text-center fw-bold shadow-sm"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center fw-bold shadow-sm"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <!-- Add Form -->
        <div id="addForm" style="display: none;">
            <form method="post" class="bg-light p-4 rounded shadow">
                <h5 class="mb-3">Add New Doctor</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="user_id" required>
                            <label>User ID</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="specialization" required>
                            <label>Specialization</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="experience" required>
                            <label>Experience (Years)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="availability" required>
                            <label>Availability</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <select name="status" class="form-select" required>
                                <option selected disabled value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success mt-3" name="add_doctor">Add Doctor</button>
            </form>
        </div>

        <!-- Edit Selector -->
        <div id="editSelector" style="display: none;">
            <form method="get" class="mt-4">
                <label>Select a doctor to edit:</label>
                <select name="edit_id" class="form-select" onchange="this.form.submit()" required>
                    <option selected disabled>-- Choose --</option>
                    <?php
                    $res = mysqli_query($db, "SELECT * FROM doctors ORDER BY id DESC");
                    while ($doc = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$doc['id']}'>" . htmlspecialchars($doc['specialization']) . " (ID: {$doc['id']})</option>";
                    }
                    ?>
                </select>
            </form>
        </div>

        <!-- Edit Form -->
        <?php
        if (isset($_GET['edit_id'])) {
            $id = $_GET['edit_id'];
            $res = mysqli_query($db, "SELECT * FROM doctors WHERE id='$id'");
            $row = mysqli_fetch_assoc($res);
            if ($row):
        ?>
        <form method="post" class="bg-light p-4 rounded shadow mt-4">
            <h5>Edit Doctor: <?= htmlspecialchars($row['specialization']) ?> (ID: <?= $row['id'] ?>)</h5>
            <input type="hidden" name="edit_doctor_id" value="<?= $row['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="user_id" value="<?= $row['user_id'] ?>" required>
                        <label>User ID</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="specialization" value="<?= htmlspecialchars($row['specialization']) ?>" required>
                        <label>Specialization</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="experience" value="<?= $row['experience'] ?>" required>
                        <label>Experience</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="availability" value="<?= htmlspecialchars($row['availability']) ?>" required>
                        <label>Availability</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select name="status" class="form-select" required>
                            <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $row['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary mt-3" name="update_doctor">Update Doctor</button>
                <button class="btn btn-danger mt-3" name="delete_doctor" onclick="return confirm('⚠️ Are you sure you want to delete this doctor?')">Delete</button>
            </div>
        </form>
        <?php endif; } ?>
    </div>
</div>

<!-- PHP CRUD Logic -->
<?php
// ADD
if (isset($_POST['add_doctor'])) {
    $u = (int)$_POST['user_id'];
    $s = mysqli_real_escape_string($db, $_POST['specialization']);
    $e = (int)$_POST['experience'];
    $a = mysqli_real_escape_string($db, $_POST['availability']);
    $st = mysqli_real_escape_string($db, $_POST['status']);
    $insert = mysqli_query($db, "INSERT INTO doctors (user_id, specialization, experience, availability, status, created_at) VALUES ('$u','$s','$e','$a','$st', CURRENT_TIMESTAMP)");
    if ($insert) {
        header("Location: add_category_doctors.php?msg=✅ Doctor added successfully!");
    } else {
        header("Location: add_category_doctors.php?error=❌ Failed to add doctor.");
    }
    exit;
}

// UPDATE
if (isset($_POST['update_doctor'])) {
    $id = $_POST['edit_doctor_id'];
    $u = (int)$_POST['user_id'];
    $s = mysqli_real_escape_string($db, $_POST['specialization']);
    $e = (int)$_POST['experience'];
    $a = mysqli_real_escape_string($db, $_POST['availability']);
    $st = mysqli_real_escape_string($db, $_POST['status']);
    $update = mysqli_query($db, "UPDATE doctors SET user_id='$u', specialization='$s', experience='$e', availability='$a', status='$st' WHERE id='$id'");
    if ($update) {
        header("Location: add_category_doctors.php?msg=✅ Doctor updated successfully!");
    } else {
        header("Location: add_category_doctors.php?error=❌ Update failed.");
    }
    exit;
}

// DELETE
if (isset($_POST['delete_doctor'])) {
    $id = $_POST['edit_doctor_id'];
    $delete = mysqli_query($db, "DELETE FROM doctors WHERE id='$id'");
    if ($delete) {
        header("Location: add_category_doctors.php?msg=🗑️ Doctor deleted successfully.");
    } else {
        header("Location: add_category_doctors.php?error=❌ Deletion failed.");
    }
    exit;
}
?>

<script>
function showForm(id) {
    document.getElementById('addForm').style.display = 'none';
    document.getElementById('editSelector').style.display = 'none';
    document.getElementById(id).style.display = 'block';
}
</script>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
