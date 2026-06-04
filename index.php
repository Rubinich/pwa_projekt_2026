<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "portal";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=cp1250", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Greška pri spajanju na bazu podataka: " . $e->getMessage());
}

function dohvatiVijesti(PDO $conn, string $kategorija) {
    $stmt = $conn->prepare("SELECT * FROM vijesti WHERE kategorija = :kategorija AND arhiva = 0 ORDER BY datum DESC");
    $stmt->execute([":kategorija" => $kategorija]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$vijesti_sport = dohvatiVijesti($conn, "Sport");
$vijesti_kultura = dohvatiVijesti($conn, "Kultura");
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.svg" type="image/svg+xml">
    <title>B.Z. Portal Vijesti</title>
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HEADER -->
    <?php include "header.php"; ?>

    <!-- GLAVNI DIO -->
    <main>
        <section class="news-section orange-details">
            <h2 class="section-title">
                <a href="#">Sport <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <?php foreach ($vijesti_sport as $vijest): ?>
                    <article class="news-card">
                        <div class="card-image">
                            <img src="images/<?= htmlspecialchars($vijest['slika']) ?>" alt="<?= htmlspecialchars($vijest['naslov']) ?>">
                        </div>
                        <div class="card-content">
                            <span class="card-category"><?= htmlspecialchars($vijest['sazetak']) ?></span>
                            <h3 class="card-heading"><?= htmlspecialchars($vijest['naslov']) ?></h3>
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
                <?php foreach ($vijesti_kultura as $vijest): ?>
                    <article class="news-card">
                        <div class="card-image">
                            <img src="images/<?= htmlspecialchars($vijest['slika']) ?>" alt="<?= htmlspecialchars($vijest['naslov']) ?>">
                        </div>
                        <div class="card-content">
                            <span class="card-category"><?= htmlspecialchars($vijest['sazetak']) ?></span>
                            <h3 class="card-heading"><?= htmlspecialchars($vijest['naslov']) ?></h3>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <?php include "footer.php"; ?>
</body>
</html>