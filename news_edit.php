<?php ob_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("adminHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

$successMsg = "";
$errorMsg = "";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $news_id = intval($_GET['id']);

    $fetch = mysqli_query($db, "SELECT * FROM news WHERE id = $news_id");
    if (mysqli_num_rows($fetch) == 0) {
        $errorMsg = "❌ News article not found.";
    } else {
        $news = mysqli_fetch_assoc($fetch);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $content = mysqli_real_escape_string($db, $_POST['content']);
        $status = mysqli_real_escape_string($db, $_POST['status']);

        $update = "UPDATE news SET title='$title', content='$content', status='$status' WHERE id=$news_id";
        if (mysqli_query($db, $update)) {
            header("Location: all_category_news.php?updated=success");
            exit();
        } else {
            $errorMsg = "❌ Failed to update article: " . mysqli_error($db);
        }
    }
} else {
    $errorMsg = "❌ Invalid request. No news ID provided.";
}
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .edit-news-container {
        max-width: 1000px;
        margin: 100px auto;
        padding: 50px 60px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        color: #ffc107;
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
        border-color: #ffc107;
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
    }

    textarea.form-control {
        height: 220px !important;
        padding: 20px;
        font-size: 16px;
        resize: vertical;
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
    }

    .button-row {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
</style>

<div class="edit-news-container">
    <div class="text-center">
        <h2 class="section-title">📰 Edit News Article</h2>
        <p class="section-subtitle">Update the content, status, and title of the selected news article below.</p>
    </div>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger text-center fw-bold"><?= $errorMsg ?></div>
    <?php elseif (!empty($news)): ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($news['title']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Content</label>
                <textarea name="content" class="form-control" required><?= htmlspecialchars($news['content']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" <?= $news['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $news['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="button-row">
                <a href="all_category_news.php" class="btn btn-secondary">⬅️ Cancel</a>
                <button type="submit" class="btn btn-primary">💾 Update News</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
