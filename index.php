<?php
require_once 'connection.php';

function fetchNews(PDO $conn, string $category) {
    $stmt = $conn->prepare("SELECT * FROM vijesti WHERE kategorija = :kategorija AND arhiva = 0 ORDER BY datum DESC");
    $stmt->execute([":kategorija" => $category]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$sport_news = fetchNews($conn, "Sport");
$culture_news = fetchNews($conn, "Kultura");
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.svg" type="image/svg+xml">
    <title>B.Z. Portal Vijesti</title>
    <link rel="stylesheet" href="style.css">

    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> -->
</head>
<body>
    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- GLAVNI DIO -->
    <main>
        <section class="news-section orange-details">
            <h2 class="section-title">
                <a href="#">Sport <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <?php foreach ($sport_news as $article): ?>
                    <article class="news-card">
                        <div class="card-image">
                            <img src="images/<?= htmlspecialchars($article['slika']) ?>" alt="<?= htmlspecialchars($article['naslov']) ?>">
                        </div>
                        <div class="card-content">
                            <span class="card-category"><?= htmlspecialchars($article['sazetak']) ?></span>
                            <h3 class="card-heading"><?= htmlspecialchars($article['naslov']) ?></h3>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="news-section red-details">
            <h2 class="section-title">
                <a href="">Kultura <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <?php foreach ($culture_news as $article): ?>
                    <article class="news-card">
                        <div class="card-image">
                            <img src="images/<?= htmlspecialchars($article['slika']) ?>" alt="<?= htmlspecialchars($article['naslov']) ?>" loading="lazy">
                        </div>
                        <div class="card-content">
                            <span class="card-category"><?= htmlspecialchars($article['sazetak']) ?></span>
                            <h3 class="card-heading"><?= htmlspecialchars($article['naslov']) ?></h3>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>