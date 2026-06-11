<?php
require_once 'paths.php';
require_once 'database_config/connect.php';

$category = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';
if($category === '') {
    header('Location: index.php');
    exit;
}

$query = 'SELECT * FROM vijesti WHERE kategorija = :kategorija AND arhiva = 0 ORDER BY datum DESC';
$pred_state = $conn->prepare($query);
$pred_state->execute([':kategorija' => $category]);
$news = $pred_state->fetchAll(PDO::FETCH_ASSOC);

if(empty($news)) {
    header('Location: index.php');
    exit;
}

$section_accent = $category === 'Sport' ? 'orange-details' : 'red-details';
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.Z. <?= $category ?></title>
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
        <section class="news-section <?= $section_accent ?>">
            <h2 class="section-title">
                <a href="kategorija.php?kategorija="><?= $category ?> <span class="arrow">&gt;</span></a>
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