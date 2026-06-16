<?php
session_start();
require_once 'paths.php';
require_once 'database_config/connect.php';

$screen_message = '';
if (isset($_SESSION['username'])) {
    header('Location: administracija.php');
    exit;
}

if (isset($_POST['registracija'])) {
    $ime = trim($_POST['ime']);
    $prezime = trim($_POST['prezime']);
    $username = trim($_POST['username']);
    $lozinka_1 = $_POST['lozinka_1'];
    $lozinka_2 = $_POST['lozinka_2'];

    if (!empty($ime) && !empty($prezime) && !empty($username) && !empty($lozinka_1) && !empty($lozinka_2)) {
        if ($lozinka_1 !== $lozinka_2) {
            $screen_message = 'Lozinke se ne podudaraju! Molimo pokušajte ponovno.';
        } else {
            $stmt = $conn->prepare("SELECT id FROM korisnici WHERE korisnicko_ime = :username");
            $stmt->execute([':username' => $username]);
            if ($stmt->rowCount() > 0) {
                $screen_message = "Korisničko ime '$username' je već zauzeto!";
            } else {
                $hashed_password = password_hash($lozinka_1, CRYPT_BLOWFISH);
                $razina = 0;

                $stmt_insert = $conn->prepare(
                    "INSERT INTO korisnici (ime, prezime, korisnicko_ime, lozinka, razina) 
                    VALUES (:ime, :prezime, :username, :lozinka_1, :razina)"
                );
                
                $stmt_insert->execute([
                    ':ime' => $ime,
                    ':prezime' => $prezime,
                    ':username' => $username,
                    ':lozinka_1' => $hashed_password,
                    ':razina' => $razina
                ]);
                // mozda
                $_SESSION['flash_message'] = 'Registracija uspješna! Sada se možete prijaviti.';

                header('Location: administracija.php');
                exit;
            }
        }
    } else {
        $screen_message = 'Sva polja su obavezna za unos!';
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.Z. Registracija</title>
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
        <div>
            <form action="registracija.php" method="POST">
                <h1>Registracija korisnika</h1>

                <?php if (!empty($screen_message)): ?>
                    <div class="message-container" style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb; text-align: center;">
                        <?= htmlspecialchars($screen_message) ?>
                    </div>
                <?php endif; ?>
                
                <div class="form-field">
                    <label for="ime">Ime</label>
                    <input type="text" id="ime" name="ime" required maxlenght="64" placeholder="Unesite vaše ime" maxlength="32" value="<?= isset($_POST['ime']) ? htmlspecialchars($_POST['ime']) : '' ?>">
                </div>
                    
                <div class="form-field">
                    <label for="prezime">Prezime</label>
                    <input type="text" id="prezime" name="prezime" required maxlenght="64" placeholder="Unesite vaše prezime" maxlength="32" value="<?= isset($_POST['prezime']) ? htmlspecialchars($_POST['prezime']) : '' ?>">
                </div>
                    
                <div class="form-field">
                    <label for="username">Korisničko ime</label>
                    <input type="text" id="username" name="username" required maxlenght="64" placeholder="Odaberite korisničko ime" maxlength="32" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>
                    
                <div class="form-field">
                    <label for="lozinka_1">Lozinka</label>
                    <input type="password" id="lozinka_1" name="lozinka_1" required placeholder="Unesite lozinku">
                </div>

                <div class="form-field">
                    <label for="lozinka_2">Ponovite lozinku</label>
                    <input type="password" id="lozinka_2" name="lozinka_2" required placeholder="Ponovno unesite lozinku">
                </div>
                    
                <div class="form-buttons">
                    <button type="reset" onclick="window.location.href='administracija.php'">Odustani</button>
                    <button type="submit" name="registracija">Registrirajte se</button>
                </div>

                <p>Već imate otvoren račun? <a href="administracija.php">Prijavite se ovdje</a></p>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>