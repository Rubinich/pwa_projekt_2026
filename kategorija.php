<?php
require_once 'paths.php';
require_once 'database_config/connect.php';

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$category_query = 'SELECT naziv FROM kategorije WHERE id = :id;';
$category_stmt = $conn->prepare($category_query);
$category_stmt->execute([':id' => $category_id]);
$category = $category_stmt->fetch(PDO::FETCH_ASSOC);

$news_query = 'SELECT id, naslov, sazetak, slika
    FROM vijesti
    WHERE idKategorije = :idKategorije AND arhiva = 0
    ORDER BY datum DESC';
$news_stmt = $conn->prepare($news_query);
$news_stmt->execute([':idKategorije' => $category_id]);
$news = $news_stmt->fetchAll(PDO::FETCH_ASSOC);

$category_colors = [
    'Sport' => 'orange-details',
    'Kultura' => 'red-details'
];
$color_class = $category_colors[$category['naziv']] ?? 'default-details';

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.Z. <?= $category['naziv'] ?></title>
    <link rel="icon" href="<?= IMAGES ?>logo.svg" type="image/svg+xml">
    <link rel="stylesheet" href="<?= ASSETS ?>style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- GLAVNI DIO -->
    <main>
        <section class="news-section <?= $color_class ?>">
            <h2 class="section-title">
                <a href="kategorija.php?id=<?= $category_id ?>"><?= htmlspecialchars($category['naziv']) ?> <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <?php foreach ($news as $row): ?>
                    <a href="clanak.php?id=<?= $row['id'] ?>">
                        <article class="news-card">
                            <div class="card-image">
                                <img src="<?= IMAGES . htmlspecialchars($row['slika']) ?>" alt="<?= htmlspecialchars($row['naslov']) ?>">
                            </div>
                            <div class="card-content">
                                <span class="card-category"><?= htmlspecialchars($row['sazetak']) ?></span>
                                <h3 class="card-heading"><?= htmlspecialchars($row['naslov']) ?></h3>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>