<?php ob_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("adminHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}

$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($db, $_POST["title"]);
    $content = mysqli_real_escape_string($db, $_POST["content"]);
    $status = mysqli_real_escape_string($db, $_POST["status"]);

    $query = "INSERT INTO news (title, content, status, created_at) VALUES ('$title', '$content', '$status', CURRENT_TIMESTAMP)";
    if (mysqli_query($db, $query)) {
        $successMessage = "📰 News article added successfully!";
    } else {
        $successMessage = "❌ Error adding news: " . mysqli_error($db);
    }
}
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .add-news-container {
        max-width: 1000px;
        margin: 100px auto;
        padding: 50px 60px;
        background-color: #fff;
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
        font-size: 16px;
        resize: vertical;
    }

    .btn-primary, .btn-success, .btn-secondary {
        padding: 12px 40px;
        font-size: 18px;
        border-radius: 30px;
        font-weight: 600;
    }

    .button-row {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
</style>

<div class="add-news-container">
    <div class="text-center">
        <h2 class="section-title">📰 Add New News Article</h2>
        <p class="section-subtitle">Submit a new update to the medical news database below.</p>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-info fw-semibold text-center"><?= $successMessage ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label fw-bold">Title</label>
            <input type="text" name="title" class="form-control" required placeholder="Enter news title">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Content</label>
            <textarea name="content" class="form-control" required placeholder="Enter news content"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="button-row">
            <a href="all_category_news.php" class="btn btn-secondary">⬅️ Back</a>
            <button type="submit" class="btn btn-success">➕ Add News</button>
        </div>
    </form>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
