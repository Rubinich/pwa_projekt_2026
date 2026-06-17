<?php

session_start();
require_once 'paths.php';
require_once 'database_config/connect.php';


$message = '';
$edit_mode = false;
$article = null;
$categories_list = [];
$news = [];

$isAdmin = isset($_SESSION['username']) && $_SESSION['razina'] == 1;

if (isset($_POST['prijava'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['lozinka']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['lozinka'])) {
            $_SESSION['username'] = $user['korisnicko_ime'];
            $_SESSION['razina'] = $user['razina'];
            $_SESSION['ime'] = $user['ime'];
            $_SESSION['prezime'] = $user['prezime'];
            

            header('Location: administracija.php');
            exit;
        } else {
            $message = 'Nije uneseno ispravno korisničko ime ili lozinka.';
        }
    }
}

if ($isAdmin) {
    $stmt = $conn->query("SELECT * FROM kategorije ORDER BY naziv");
    $categories_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM vijesti WHERE id = :id");
            $stmt->execute([':id' => $id]);
        }
    }

    if (isset($_POST['submit_update'])) {
        $id = (int)$_POST['id'];
        $title = trim($_POST['title']);
        $about = trim($_POST['about']);
        $content = trim($_POST['content']);
        $category_id = (int)$_POST['category'];
        $archive = isset($_POST['archive']) ? 1 : 0;

        if (!empty($_FILES['photo']['name'])) {
            $picture = $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], IMAGES . $picture);
        } else {
            $picture = $_POST['old_photo'];
        }

        if ($id > 0 && !empty($title) && !empty($content)) {
            $stmt = $conn->prepare(
                "UPDATE vijesti SET
                    naslov = :naslov,
                    sazetak = :sazetak,
                    tekst = :tekst,
                    slika = :slika,
                    idKategorije = :idKategorije,
                    arhiva = :arhiva
                WHERE id = :id"
            );

            $stmt->execute([
                ':naslov' => $title,
                ':sazetak' => $about,
                ':tekst' => $content,
                ':slika' => $picture,
                ':idKategorije' => $category_id,
                ':arhiva' => $archive,
                ':id' => $id
            ]);
        }
    }

    if (isset($_GET['update'])) {
        $id = (int)$_GET['update'];
        $stmt = $conn->prepare("SELECT * FROM vijesti WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        $edit_mode = $article ? true : false;
    }

    $stmt = $conn->query("SELECT v.*, k.naziv AS kategorija_naziv
    FROM vijesti v
    JOIN kategorije k
    ON v.idKategorije = k.id
    ORDER BY v.datum DESC");
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.Z. Administracija</title>
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
        <!-- ako je neko prijavljen u sesiji i on je ADMIN i zeli IZMIJENITI clanak dobije ovo -->
        <?php if (isset($_SESSION['username']) && $_SESSION['razina'] == 1): ?>
            <!-- ak editira onda prikazi formu s popunjenim podacima -->
            <?php if ($edit_mode): ?>
                <div>
                    <form action="administracija.php" method="POST" enctype="multipart/form-data">
                        <h1>Izmjena članka</h1>
                        <input type="hidden" name="id" value="<?= $article['id'] ?>">
                        <input type="hidden" name="old_photo" value="<?= $article['slika'] ?>">
                        <div class="form-field">
                            <label for="title">Naslov vijesti</label>
                            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($article['naslov']) ?>">
                        </div>
                        <div class="form-field">
                            <label for="about">Kratki sadržaj vijesti</label>
                            <textarea id="about" name="about" rows="4" required><?= htmlspecialchars($article['sazetak']) ?></textarea>
                        </div>
                        <div class="form-field">
                            <label for="content">Sadržaj vijesti</label>
                            <textarea id="content" name="content" rows="8" required><?= htmlspecialchars($article['tekst']) ?></textarea>
                        </div>
                        <div class="form-field">
                            <label for="category">Kategorija vijesti</label>
                            <select id="category" name="category" required>
                                <?php foreach($categories_list as $row): ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= htmlspecialchars($row['naziv']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="photo">Slika vijesti</label>
                            <input type="file" id="photo" name="photo" accept="image/*">
                            <div>
                                <p>Trenutna slika: <?= htmlspecialchars($article['slika']) ?></p>
                                <img src="<?= IMAGES . htmlspecialchars($article['slika']) ?>" alt="Trenutna slika" style="max-width: 150px; height: auto; border: 1px solid #ccc;">
                            </div>
                        </div>
                        <div class="form-field checkbox-field">
                            <label for="archive">Spremi u arhivu:</label>
                            <input type="checkbox" id="archive" name="archive" value="1" <?= ($article['arhiva'] == 1) ? 'checked' : '' ?>>
                        </div>
                        <div class="form-buttons">
                            <button type="reset" onclick="window.location.href='administracija.php'">Odustani</button>
                            <button type="submit" name="submit_update">Prihvati izmjenu</button>
                        </div>
                    </form>
                </div>
            <!-- ak ne editira, pokazi sve clanke -->
            <?php else: ?>
                <section class="news-section">
                    <h2 class="section-title grey-details">Administracija članaka</h2>
                    <div class="news-auto-fill">
                        <?php foreach ($news as $row): ?>
                            <div class="admin-card-wrapper">
                                <article class="news-card">
                                    <div class="card-image">
                                        <img src="<?= IMAGES . htmlspecialchars($row['slika']) ?>" alt="<?= htmlspecialchars($row['naslov']) ?>">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-category"><?= htmlspecialchars($row['kategorija_naziv']) ?></span>
                                        <span class="card-date">Datum dodavanja: <?= date('d.m.Y.', strtotime($row['datum'])) ?></span>
                                        <h3 class="card-heading"><?= htmlspecialchars($row['naslov']) ?></h3>
                                    </div>
                                    <div class="card-archive-status">
                                        <span>Arhivirano: </span>
                                        <?php if ($row['arhiva'] == 1): ?>
                                            <span class="red">Da</span>
                                        <?php else: ?>
                                            <span class="green">Ne</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="admin-actions">
                                        <a href="administracija.php?update=<?= $row['id'] ?>">&#9998;</a>
                                        <a href="administracija.php?delete=<?= $row['id'] ?>">&#128465;</a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <!-- ako je obican korisnik -->
        <?php elseif (isset($_SESSION['username']) && $_SESSION['razina'] == 0): ?>
            <div class="regular-container">
                <h2>Bok, <?= htmlspecialchars($_SESSION['ime']) . ' ' . htmlspecialchars($_SESSION['prezime']) ?></h2>
                <p>Nemate prava za pristup administracijskoj stranici.</p>
                <a href="index.php" class="blue">Povratak na početnu stranicu</a>
            </div>
        <!-- zadano stanje za prijavu u sustav -->
        <?php else: ?>
            <div class="login-container">
                <?php if (!empty($message)): ?>
                    <div><?= $message ?></div>
                <?php endif; ?>
                <form action="administracija.php" method="POST">
                    <h1>Prijava u sustav</h1>
                    <div class="form-field">
                        <label for="username">Korisničko ime:</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-field">
                        <label for="lozinka">Lozinka:</label>
                        <input type="password" id="lozinka" name="lozinka" required>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" name="prijava">Prijava</button>
                    </div>
                    <p>Nemate otvoren račun? <a href="registracija.php" class="blue">Registrirajte se ovdje</a></p>
                </form>
                
            </div>
        <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>