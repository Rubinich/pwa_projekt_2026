<?php
require_once 'paths.php';
require_once 'database_config/connect.php';

function fetchTop3Articles(PDO $conn, string $category) {
    $query = 'SELECT id, naslov, sazetak, slika FROM vijesti WHERE kategorija = :kategorija AND arhiva = 0 ORDER BY datum DESC LIMIT 3';
    $prep_state = $conn->prepare($query);
    $prep_state->execute([":kategorija" => $category]);
    return $prep_state->fetchAll(PDO::FETCH_ASSOC);
}

$sport_news = fetchTop3Articles($conn, "Sport");
$culture_news = fetchTop3Articles($conn, "Kultura");
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.Z. Portal Vijesti</title>
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
        <section class="news-section orange-details">
            <h2 class="section-title">
                <a href="kategorija.php?kategorija=Sport">Sport <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <?php foreach ($sport_news as $row): ?>
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

        <section class="news-section red-details">
            <h2 class="section-title">
                <a href="kategorija.php?kategorija=Kultura">Kultura <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <?php foreach ($culture_news as $row): ?>
                    <a href="clanak.php?id=<?= $row['id'] ?>">
                        <article class="news-card">
                            <div class="card-image">
                                <img src="<?= IMAGES . htmlspecialchars($row['slika']) ?>" alt="<?= htmlspecialchars($row['naslov']) ?>" loading="lazy">
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