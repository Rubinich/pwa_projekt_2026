<?php
$active_page = basename($_SERVER['SCRIPT_NAME']);

$query_header = 'SELECT * FROM kategorije ORDER BY naziv';
$header_stmt = $conn->query($query_header);
$category_header = $header_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<header>
    <a href="index.php">
        <img src="<?= IMAGES ?>logo.svg" alt="B.Z. Portal Logo" class="logo-img">
    </a>
    <nav>
        <button class="nav-toggle" aria-label="Otvori meni">&#9776;</button>
        <ul>
            <li><a href="index.php" class="<?= ($active_page == 'index.php') ? 'active' : ''; ?>">Početak</a></li>
            
            <?php foreach($category_header as $row): ?>
                <li>
                    <a href="kategorija.php?id=<?= $row['id'] ?>" 
                        class="<?= (isset($_GET['id']) && $_GET['id'] == $row['id']) ? 'active' : ''; ?>">
                        <?= htmlspecialchars($row['naziv']) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <li><a href="unos.php" class="<?= ($active_page == 'unos.php') ? 'active' : ''; ?>">Unos</a></li>
            <li><a href="administracija.php" class="<?= ($active_page == 'administracija.php') ? 'active' : ''; ?>">Administracija</a></li>
        </ul>
    </nav>
</header>