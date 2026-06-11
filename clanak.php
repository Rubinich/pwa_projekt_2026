<?php 
require_once 'paths.php';
require_once 'database_config/connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = 'SELECT v.*, k.naziv as kategorija_naziv
    FROM vijesti v
    JOIN kategorije k on v.idKategorije = k.id
    WHERE v.id = :id';
$stmt = $conn->prepare($query);
$stmt->execute([':id' => $id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

$category_colors = [
    'Sport'   => 'orange-details',
    'Kultura' => 'red-details',
];
$color_class = $category_colors[$article['kategorija_naziv']] ?? 'default-details';

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['naslov']) ?></title>
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
        <article class="article">
            <p class="article-category-badge <?= $color_class ?>">
                <?= htmlspecialchars($article['kategorija_naziv']) ?>
            </p>

            <h1 class="article-title">
                <?= htmlspecialchars($article['naslov']) ?>
            </h1>

            <p class="article-datetime">
                Objavljeno <?= date('j.n.Y.', strtotime($article['datum'])) ?> u <?= date('H:i', strtotime($article['datum']))  ?>
            </p>

            <div class="article-image">
                <img src="<?= IMAGES . htmlspecialchars($article['slika']) ?>" alt="<?= htmlspecialchars($article['naslov']) ?>">
            </div>

            <p class="article-summary">
                <?= htmlspecialchars($article['sazetak']) ?>
            </p>

            <div class="article-text">
                <?= nl2br(htmlspecialchars($article['tekst'])) ?>
            </div>
        </article>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>
