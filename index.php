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
                <article class="news-card">
                    <div class="card-image">
                        <img src="images/slika1.jpg" alt="Vijest 1">
                    </div>
                    <div class="card-content">
                        <span class="card-category">Abschied aus Berlin</span>
                        <h3 class="card-heading">Klinsmann Junior (22) verlässt Hertha – aber wohin gehter</h3>
                    </div>
                </article>

                <article class="news-card">
                    <div class="card-image">
                        <img src="images/slika2.jpg" alt="Vijest 2">
                    </div>
                    <div class="card-content">
                        <span class="card-category">Vorm Saisonfinale</span>
                        <h3 class="card-heading">Paderborn-Coach Baumgart verrät Startelf für Dresden-Spiel</h3>
                    </div>
                </article>

                <article class="news-card">
                    <div class="card-image">
                        <img src="images/slika3.jpg" alt="Vijest 3">
                    </div>
                    <div class="card-content">
                        <span class="card-category">Vor Playoffs gegen Ulm</span>
                        <h3 class="card-heading">Alba-Coach: Deutsche dürfen Platz nicht wegen Passes bekommen</h3>
                    </div>
                </article>
            </div>
        </section>

        <section class="news-section red-details">
            <h2 class="section-title">
                <a href="">Kultura <span class="arrow">&gt;</span></a>
            </h2>

            <div class="news-auto-fill">
                <article class="news-card">
                    <div class="card-image">
                        <img src="images/slika1.jpg" alt="Vijest 1">
                    </div>
                    <div class="card-content">
                        <span class="card-category">Abschied aus Berlin</span>
                        <h3 class="card-heading">Klinsmann Junior (22) verlässt Hertha – aber wohin gehter</h3>
                    </div>
                </article>

                <article class="news-card">
                    <div class="card-image">
                        <img src="images/slika2.jpg" alt="Vijest 2">
                    </div>
                    <div class="card-content">
                        <span class="card-category">Vorm Saisonfinale</span>
                        <h3 class="card-heading">Paderborn-Coach Baumgart verrät Startelf für Dresden-Spiel</h3>
                    </div>
                </article>

                <article class="news-card">
                    <div class="card-image">
                        <img src="images/slika3.jpg" alt="Vijest 3">
                    </div>
                    <div class="card-content">
                        <span class="card-category">Vor Playoffs gegen Ulm</span>
                        <h3 class="card-heading">Alba-Coach: Deutsche dürfen Platz nicht wegen Passes bekommen</h3>
                    </div>
                </article>
            </div>
        </section>
    </main>
    <!-- FOOTER -->
    <?php include "footer.php"; ?>
</body>
</html>