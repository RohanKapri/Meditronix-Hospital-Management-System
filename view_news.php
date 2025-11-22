<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$news = null;

if ($db && $id) {
    $result = mysqli_query($db, "SELECT * FROM news WHERE id = $id");
    $news = mysqli_fetch_assoc($result);
}
?>

<style>
    body {
        background: linear-gradient(to right, #f8f9fa, #e0eafc);
    }

    .news-container {
        max-width: 950px;
        margin: 120px auto;
        padding: 50px;
        background: linear-gradient(135deg, #ffffff, #f1f3f5);
        border-radius: 20px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .news-container::before {
        content: 'NEWS';
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 80px;
        color: rgba(0, 0, 0, 0.05);
        z-index: 0;
        font-weight: 900;
        letter-spacing: 10px;
    }

    .news-title {
        font-size: 40px;
        font-weight: 800;
        color: #0d6efd;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        border-bottom: 3px solid #0d6efd;
        display: inline-block;
        padding-bottom: 5px;
        position: relative;
        z-index: 1;
    }

    .news-meta {
        font-size: 23px;
        color: #6c757d;
        margin-top: 5px;
        margin-bottom: 30px;
        position: relative;
        z-index: 1;
    }

    .news-content {
        font-size: 20px;
        line-height: 1.8;
        color: #212529;
        background: #f8f9fa;
        padding: 30px;
        border-left: 6px solid #0d6efd;
        border-radius: 15px;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        position: relative;
        z-index: 1;
        white-space: pre-wrap;
    }

    .btn-back {
        margin-top: 50px;
        padding: 12px 35px;
        background-color: #0d6efd;
        color: #fff;
        font-size: 16px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }

    .btn-back:hover {
        background-color: #0b5ed7;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }
</style>

<div class="news-container">
    <?php if ($news): ?>
        <h1 class="news-title">📰 <?= htmlspecialchars($news['title']) ?></h1>
        <p class="news-meta">
            🆔 ID: <?= htmlspecialchars($news['id']) ?> &nbsp;  &nbsp;
            <br>
            📅 <?= htmlspecialchars($news['created_at']) ?> &nbsp;  &nbsp;
            <br>
            📌 Status: <?= ucfirst(htmlspecialchars($news['status'])) ?>
            <br>
        </p>
        <div class="news-content"><?= nl2br(htmlspecialchars($news['content'])) ?></div>
        <a href="Daily_news.php" class="btn-back">🔙 Back to News</a>
    <?php else: ?>
        <h2 class="text-danger">No News Found</h2>
        <a href="Daily_news.php" class="btn-back">🔙 Back to News</a>
    <?php endif; ?>
</div>

<?php include("doctorFooter.php"); ?>
