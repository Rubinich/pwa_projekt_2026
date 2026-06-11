<?php
require_once 'paths.php';
require_once 'database_config/connect.php';

$category_colors = [
    'Sport' => 'orange-details',
    'Kultura' => 'red-details'
];

$category_query = 'SELECT * FROM kategorije';
$category_stmt = $conn->prepare($category_query);
$category_stmt->execute();
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <?php 
        foreach($categories as $category):
            $news_query = 'SELECT id, naslov, sazetak, slika 
                FROM vijesti
                WHERE idKategorije = :idKategorije AND arhiva = 0
                ORDER BY datum DESC
                LIMIT 3;';
            $news_stmt = $conn->prepare($news_query);
            $news_stmt->execute([':idKategorije' => $category['id']]);
            $news = $news_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(!empty($news)): 
                $color_class = array_key_exists($category['naziv'], $category_colors) ? $category_colors[$category['naziv']] : 'default-details';
            ?>
            
            <!-- svaka sekcija kategorije -->
            <section class="news-section <?= $color_class ?>">
                <h2 class="section-title">
                    <a href="kategorija.php?id=<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['naziv']) ?><span class="arrow"> &gt;</span>
                    </a>
                </h2>
                
                <!-- svaka vijest iz kategorije -->
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

            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>