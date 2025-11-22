<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("patientHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($db, "SELECT * FROM news WHERE id = $id");
$news = mysqli_fetch_assoc($query);
?>

<style>
.container-news {
    max-width: 900px;
    margin: 100px auto;
    padding: 40px;
    border-radius: 20px;
    background: linear-gradient(135deg, #f9f9f9, #ffffff);
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.07);
}
.news-heading {
    font-size: 38px;
    font-weight: 800;
    color: #0d6efd;
    border-bottom: 4px solid #0d6efd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.news-meta {
    font-size: 16px;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.8;
}
.news-content {
    font-size: 17px;
    color: #222;
    line-height: 1.9;
    background-color: #f8f9fa;
    padding: 25px;
    border-left: 6px solid #0d6efd;
    border-radius: 12px;
}
.btn-back {
    display: inline-block;
    margin-top: 30px;
    background-color: #0d6efd;
    color: white;
    font-weight: 600;
    padding: 10px 30px;
    border-radius: 50px;
    transition: 0.3s;
    text-decoration: none;
}
.btn-back:hover {
    background-color: #084298;
}
</style>

<div class="container-news">
    <?php if ($news): ?>
        <h1 class="news-heading">📰 <?= htmlspecialchars($news['title']) ?></h1>
        <p class="news-meta">
            🆔 ID: <?= htmlspecialchars($news['id']) ?> <br>
            📅 Created At: <?= htmlspecialchars($news['created_at']) ?> <br>
            📌 Status: <?= ucfirst(htmlspecialchars($news['status'])) ?>
        </p>
        <div class="news-content">
            <?= nl2br(htmlspecialchars($news['content'])) ?>
        </div>
        <a href="Announcement.php" class="btn-back">🔙 Back to News Dashboard</a>
    <?php else: ?>
        <h2 class="text-danger">No News Found</h2>
        <a href="Announcement.php" class="btn-back">🔙 Back to News Dashboard</a>
    <?php endif; ?>
</div>

<?php include("patientFooter.php"); ?>
