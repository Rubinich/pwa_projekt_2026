<?php
require_once 'paths.php';
require_once 'database_config/connect.php';

$query = 'SELECT * FROM kategorije ORDER BY naziv';
$stmt = $conn->query($query);
$categories_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    if ($delete_id > 0) {
        $delete_query = 'DELETE FROM vijesti WHERE id = :id';
        $stmt = $conn->prepare($delete_query);
        $stmt->execute([':id' => $delete_id]);
        
        header('Location: administracija.php?status=deleted');
        exit;
    }
}

if (isset($_POST['submit_update'])) {
    $id = (int)$_POST['id'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category_id = (int)$_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    if (!empty($_FILES['photo']['name'])) {
        $picture = $_FILES['photo']['name'];
        move_uploaded_file($_FILES["photo"]["tmp_name"], IMAGES . $picture);
    } else {
        $picture = $_POST['old_photo'];
    }

    if ($id > 0 && !empty($title) && !empty($content)) {
        $update_query = 'UPDATE vijesti SET 
            naslov = :naslov, 
            sazetak = :sazetak, 
            tekst = :tekst, 
            slika = :slika, 
            idKategorije = :idKategorije, 
            arhiva = :arhiva 
            WHERE id = :id';
        
        $stmt = $conn->prepare($update_query);
        $stmt->execute([
            ':naslov' => $title,
            ':sazetak' => $about,
            ':tekst' => $content,
            ':slika' => $picture,
            ':idKategorije' => $category_id,
            ':arhiva' => $archive,
            ':id' => $id
        ]);

        header('Location: administracija.php?status=updated');
        exit;
    }
}

$article = null;
$edit_mode = false;
if (isset($_GET['update'])) {
    $edit_id = (int)$_GET['update'];
    $stmt_article = $conn->prepare("SELECT * FROM vijesti WHERE id = :id");
    $stmt_article->execute([':id' => $edit_id]);
    $article = $stmt_article->fetch(PDO::FETCH_ASSOC);
    
    if ($article) {
        $edit_mode = true;
    }
}


$select_query = 'SELECT v.*, k.naziv as kategorija_naziv 
    FROM vijesti v 
    JOIN kategorije k ON v.idKategorije = k.id 
    ORDER BY v.datum DESC';
$news = $conn->query($select_query)->fetchAll(PDO::FETCH_ASSOC);
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
                        <div style="margin-top: 10px;">
                            <small style="display: block; margin-bottom: 5px;">Trenutna slika: <?= htmlspecialchars($article['slika']) ?></small>
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
                                    <span class="card-category <?= $row ?>">
                                        <?= htmlspecialchars($row['kategorija_naziv']) ?>
                                    </span>
                                    <span class="card-date">
                                        Datum: <?= date('d.m.Y.', strtotime($row['datum'])) ?>
                                    </span>
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
                            </article>

                            <div class="admin-actions">
                                <a href="administracija.php?update=<?= $row['id'] ?>">&#9998;</a>
                                <a href="administracija.php?delete=<?= $row['id'] ?>">&#128465;</a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>