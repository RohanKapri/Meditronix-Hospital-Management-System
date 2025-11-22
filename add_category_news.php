<?php include("adminHeader.php"); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
?>

<div class="container-xxl py-5" style="margin-top: 100px;">
    <div class="container">
        <h4 class="section-title bg-white text-primary text-center px-4">🗞️ Manage News Articles</h4>

        <!-- Message Alert -->
        <?php
        if (isset($_GET['msg'])) {
            echo "<div class='alert alert-success text-center mt-3 fw-bold fs-6' style='font-family: \"Segoe UI\", sans-serif;'>
                    ✅ " . htmlspecialchars($_GET['msg']) . "
                  </div>";
        }
        ?>

        <!-- Buttons -->
        <div class="text-center mb-4">
            <button class="btn btn-success me-2" onclick="toggleForm('addForm')">Add News</button>
            <button class="btn btn-warning me-2" onclick="toggleForm('editSelector')">Edit News</button>
        </div>

        <!-- Add Form -->
        <div id="addForm" style="display:none;">
            <form method="post" class="bg-light p-4 rounded shadow">
                <h5 class="mb-3 text-success">🆕 Create New Article</h5>
                <div class="form-floating mb-3">
                    <input type="text" name="title" class="form-control" required placeholder="Title">
                    <label>News Title</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="content" class="form-control" placeholder="Content" required style="height: 120px;"></textarea>
                    <label>Content</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <label>Status</label>
                </div>
                <button class="btn btn-success" name="add_news">Publish News</button>
            </form>
        </div>

        <!-- Edit Selector -->
        <div id="editSelector" style="display:none;">
            <form method="get" class="mt-3">
                <div class="form-group">
                    <label>Select News to Edit/Delete:</label>
                    <select name="edit_id" class="form-select" onchange="this.form.submit()" required>
                        <option disabled selected>-- Choose News --</option>
                        <?php
                        $news = mysqli_query($db, "SELECT * FROM news ORDER BY id DESC");
                        while ($n = mysqli_fetch_assoc($news)) {
                            echo "<option value='{$n['id']}'>" . htmlspecialchars($n['title']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>

        <!-- Edit/Update Form -->
        <?php
        if (isset($_GET['edit_id'])) {
            $id = $_GET['edit_id'];
            $editQ = mysqli_query($db, "SELECT * FROM news WHERE id='$id'");
            $data = mysqli_fetch_assoc($editQ);
            if ($data) {
        ?>
        <form method="post" class="bg-light p-4 rounded shadow mt-4">
            <h5 class="text-warning">✏️ Edit News Article</h5>
            <input type="hidden" name="news_id" value="<?= $data['id'] ?>">
            <div class="form-floating mb-3">
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['title']) ?>" required>
                <label>News Title</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="content" class="form-control" style="height: 120px;" required><?= htmlspecialchars($data['content']) ?></textarea>
                <label>Content</label>
            </div>
            <div class="form-floating mb-3">
                <select name="status" class="form-select" required>
                    <option value="active" <?= $data['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $data['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
                <label>Status</label>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" name="update_news">Update</button>
                <button class="btn btn-danger" name="delete_news" onclick="return confirm('Are you sure to delete this news?')">Delete</button>
            </div>
        </form>
        <?php }} ?>
    </div>
</div>

<!-- Backend CRUD Operations -->
<?php
if (isset($_POST['add_news'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $content = mysqli_real_escape_string($db, $_POST['content']);
    $status = mysqli_real_escape_string($db, $_POST['status']);

    mysqli_query($db, "INSERT INTO news (title, content, status, created_at)
                       VALUES ('$title', '$content', '$status', CURRENT_TIMESTAMP)");
    echo "<script>window.location.href='add_category_news.php?msg=📰 News published successfully!';</script>";
}

if (isset($_POST['update_news'])) {
    $id = $_POST['news_id'];
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $content = mysqli_real_escape_string($db, $_POST['content']);
    $status = mysqli_real_escape_string($db, $_POST['status']);

    mysqli_query($db, "UPDATE news SET title='$title', content='$content', status='$status' WHERE id='$id'");
    echo "<script>window.location.href='add_category_news.php?msg=✅ News updated successfully!';</script>";
}

if (isset($_POST['delete_news'])) {
    $id = $_POST['news_id'];
    mysqli_query($db, "DELETE FROM news WHERE id='$id'");
    echo "<script>window.location.href='add_category_news.php?msg=❌ News deleted successfully!';</script>";
}
?>

<!-- Script to Toggle Forms -->
<script>
    function toggleForm(id) {
        document.getElementById('addForm').style.display = 'none';
        document.getElementById('editSelector').style.display = 'none';
        if (id) document.getElementById(id).style.display = 'block';
    }
</script>

<?php include("adminFooter.php"); ?>
