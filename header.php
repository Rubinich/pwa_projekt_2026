<?php
$aktivna_stranica = basename($_SERVER['PHP_SELF']);
?>

<header>
    <a href="index.php">
        <img src="images/logo.svg" alt="B.Z. Portal Logo" class="logo-img">
    </a>
    <nav>
        <ul>
            <li><a href="index.php" class="<?= ($aktivna_stranica == 'index.php') ? 'active' : ''; ?>">Početak</a></li>
            <li><a href="sport.php" class="<?= ($aktivna_stranica == 'sport.php') ? 'active' : ''; ?>">Sport</a></li>
            <li><a href="kultura.php" class="<?= ($aktivna_stranica == 'kultura.php') ? 'active' : ''; ?>">Kultura</a></li>
            <li><a href="registracija.php" class="<?= ($aktivna_stranica == 'registracija.php') ? 'active' : ''; ?>">Registracija</a></li>
            <li><a href="administracija.php" class="<?= ($aktivna_stranica == 'administracija.php') ? 'active' : ''; ?>">Administracija</a></li>
        </ul>
    </nav>
</header>