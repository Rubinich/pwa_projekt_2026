<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.svg" type="image/svg+xml">
    <title>B.Z. Portal Vijesti</title>
    <link rel="stylesheet" href="style.css">

    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> -->
</head>
<body>
    <!-- HEADER -->
    <?php include 'header.php'; ?>
    
    <!-- GLAVNI DIO -->
    <main>
    <div class="form-container">
        <h1>Unos nove vijesti</h1>
        
        <form action="skripta.php" method="POST" enctype="multipart/form-data">
            <div class="form-field">
                <label for="title">Naslov vijesti</label><br>
                <input type="text" id="title" name="title" required placeholder="Unesite naslov vijesti" maxlength="128">
            </div>
            
            <div class="form-field">
                <label for="about">Kratki sadržaj vijesti</label><br>
                <textarea id="about" name="about" rows="4" required placeholder="Kratki opis..."></textarea>
            </div>
            
            <div class="form-field">
                <label for="content">Sadržaj vijesti</label><br>
                <textarea id="content" name="content" rows="8" required placeholder="Glavni tekst vijesti..."></textarea>
            </div>
            
            <div class="form-field">
                <label for="category">Kategorija vijesti</label><br>
                <select id="category" name="category" required>
                    <option value="" disabled selected>Odaberite kategoriju</option>
                    <option value="Sport">Sport</option>
                    <option value="Kultura">Kultura</option>
                </select>
            </div>
            
            <div class="form-field">
                <label for="photo">Slika vijesti</label><br>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>
            
            <div class="form-field checkbox-field">
                <label for="archive">Spremi u arhivu:</label>
                <input type="checkbox" id="archive" name="archive">
            </div>
            
            <div class="form-buttons">
                <button type="reset" class="btn-reset">Poništi</button>
                <button type="submit" class="btn-submit">Prihvati</button>
            </div>
        </form>
    </div>
</main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>