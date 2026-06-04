<?php
$active_page = basename($_SERVER['PHP_SELF']);
?>

<header>
    <a href="index.php">
        <img src="images/logo.svg" alt="B.Z. Portal Logo" class="logo-img">
    </a>
    <nav>
        <button class="nav-toggle" aria-label="Otvori meni">&#9776;</button>
        <ul>
            <li><a href="index.php" class="<?= ($active_page == 'index.php') ? 'active' : ''; ?>">Početak</a></li>
            <li><a href="sport.php" class="<?= ($active_page == 'sport.php') ? 'active' : ''; ?>">Sport</a></li>
            <li><a href="kultura.php" class="<?= ($active_page == 'kultura.php') ? 'active' : ''; ?>">Kultura</a></li>
            <li><a href="registracija.php" class="<?= ($active_page == 'registracija.php') ? 'active' : ''; ?>">Registracija</a></li>
            <li><a href="administracija.php" class="<?= ($active_page == 'administracija.php') ? 'active' : ''; ?>">Administracija</a></li>
        </ul>
    </nav>
</header>
<script src="script.js" defer></script>