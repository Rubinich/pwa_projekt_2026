<?php
$active_page = basename($_SERVER['SCRIPT_NAME']);
?>

<header>
    <a href="index.php">
        <img src="<?= IMAGES ?>logo.svg" alt="B.Z. Portal Logo" class="logo-img">
    </a>
    <nav>
        <button class="nav-toggle" aria-label="Otvori meni">&#9776;</button>
        <ul>
            <li><a href="index.php" class="<?= ($active_page == 'index.php') ? 'active' : ''; ?>">Početak</a></li>
            <li><a href="kategorija.php?kategorija=Sport" class="<?= ($active_page == 'sport.php') ? 'active' : ''; ?>">Sport</a></li>
            <li><a href="kategorija.php?kategorija=Kultura" class="<?= ($active_page == 'kultura.php') ? 'active' : ''; ?>">Kultura</a></li>
            <li><a href="unos.php" class="<?= ($active_page == 'unos.php') ? 'active' : ''; ?>">Unos</a></li>
            <li><a href="administracija.php" class="<?= ($active_page == 'administracija.php') ? 'active' : ''; ?>">Administracija</a></li>
        </ul>
    </nav>
</header>