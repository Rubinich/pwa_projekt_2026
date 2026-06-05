<?php 

require_once 'paths.php';
require_once 'database_config/connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id === 0) {
    header('Location: index.php');
    exit;
}

$query = 'SELECT datum, naslov, sazetak, tekst, slika, kategorija FROM vijesti WHERE id = :id';
$pred_state = $conn->prepare($query);
$pred_state->execute([':id' => $id]);
$article= $pred_state->fetch(PDO::FETCH_ASSOC);

if(!$article) {
    header('Location: index.php');
    exit;
}

$section_accent = $article['kategorija'] === 'Sport' ? 'orange-details' : 'red-details';

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
            <p class="article-category-badge <?= $section_accent ?>">
                <?= htmlspecialchars($article['kategorija']) ?>
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
