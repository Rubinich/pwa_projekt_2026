<?php 
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "portal";

try{
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=cp1250", 
        $user, 
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch (PDOException $e) {
    die("Greška prilikom spajanja na bazu: " . $e->getMessage());
}

// izvlacenje podataka iz forme
$title = isset($_POST["title"]) ? $_POST["title"] : "";
$about = isset($_POST["about"]) ? $_POST["about"] : "";
$content = isset($_POST["content"]) ? $_POST["content"] : "";
$category = isset($_POST["category"]) ? $_POST["category"] : "";
$date = date("Y-m-d H:i:s");
$archive = isset($_POST["archive"]) ? 1 : 0;

$picture = "default.svg";
if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES["photo"]["tmp_name"];
    $fileName = $_FILES["photo"]["name"];

    $fileType = mime_content_type($fileTmpPath);
    if (!str_starts_with($fileType, "image/")) {
        die("Nije dozvoljen ovaj tip datoteke.");
    }

    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $picture = uniqid("img_", true) . "." . $extension;
    $targetFilePath = "images/" . $picture;

    if (!move_uploaded_file($fileTmpPath, $targetFilePath)) {
        die("Greška pri uploadu slike.");
    }
}

if (!empty($title) && !empty($content) && !empty($category)) {
    try {
        $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) 
                VALUES (:datum, :naslov, :sazetak, :tekst, :slika, :kategorija, :arhiva)";
        
        $prep_state = $conn->prepare($query);
        $prep_state->execute([
            ":datum" => $date,
            ":naslov" => $title,
            ":sazetak" => $about,
            ":tekst" => $content,
            ":slika" => $picture,
            ":kategorija" => $category,
            ":arhiva" => $archive
        ]);

        header("Location: unos.php?status=success");
        exit;
    } catch (PDOException $e) {
        die("Greška pri upisu u bazu podataka: " . $e->getMessage());
    }
} else {
    header("Location: unos.php?status=error");
    exit;
}

?>