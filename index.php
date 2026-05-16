<?php require_once "assets/contact-form-handler.php"; ?>
<?php require_once "assets/articles-data.php"; ?>
<?php $homeArticles = array_slice(getArticlesData(), 0, 3); ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/contact-section.css">
    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>
    <title>Domov</title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main class="home-main">
        <section class="hero-section">
            <div class="main-heading">
                <img src="./img/cech-logo.webp" alt="Logo cechu remeselníkov">

                <div class="main-heading-copy">
                    <h1>Remeselníci a tvorcovia zo Žilinského kraja</h1>

                    <p>
                        Spájame ľudí, ktorí s láskou a poctivosťou tvoria, vyrábajú a zachovávajú
                        remeslo v Žilinskom kraji.
                        <br>
                        Naším cieľom je podporiť lokálnych tvorcov, ukázať hodnotu ručnej práce
                        a uľahčiť verejnosti nájsť remeselníkov, ktorým môže dôverovať.
                    </p>
                </div>
            </div>
        </section>

        <section id="aktuality" class="news-section">
            <div class="section-shell">
                <div class="section-intro">
                    <span class="section-kicker">Kalendár podujatí</span>
                    <h2>Aktuality</h2>
                    <p>
                        Pozrite si najbližšie podujatia, workshopy a komunitné stretnutia, ktoré
                        spájajú remeselníkov, návštevníkov a lokálnych tvorcov.
                    </p>
                </div>

                <div class="news-layout">
                    <article class="news-featured-card">
                        <img src="./img/jarmok.webp" alt="Hlavný leták podujatia">
                        <div class="news-featured-overlay">
                            <span class="news-badge">Hlavné podujatie</span>
                            <h3>Jarný remeselný jarmok 2026</h3>
                            <p class="news-meta">17. máj 2026 | Námestie Andreja Hlinku, Žilina</p>
                            <p class="news-description">
                                Deň plný ukážok tradičných techník, predaja autorských výrobkov a
                                rozhovorov s tvorcami priamo v centre mesta.
                            </p>
                        </div>
                    </article>

                    <div class="news-side-stack">
                        <article class="news-side-card">
                            <img src="./img/workshop.webp" alt="Workshop výroby">
                            <div class="news-side-overlay">
                                <span class="news-badge small">Workshop</span>
                                <h3>Škola košikárstva</h3>
                                <p>24. apríl 2026 | Kysucké múzeum</p>
                            </div>
                        </article>

                        <article class="news-side-card">
                            <img src="./img/vystava.webp" alt="Výstava remeselnej tvorby">
                            <div class="news-side-overlay">
                                <span class="news-badge small">Výstava</span>
                                <h3>Hlina a drevo</h3>
                                <p>7. jún 2026 | Dom remesiel, Martin</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="clanky" class="articles-section">
            <div class="section-shell">
                <div class="section-intro">
                    <span class="section-kicker">Príbehy a reportáže</span>
                    <h2>Články</h2>
                    <p>
                        Objavte rozhovory, reportáže a zaujímavosti zo sveta poctivej ručnej práce,
                        ktoré približujú ľudí aj príbehy za každým výrobkom.
                    </p>
                </div>

                <div class="articles-grid">
                    <?php foreach ($homeArticles as $article): ?>
                        <article class="article-card">
                            <div class="article-card-visual">
                                <img src="<?= htmlspecialchars($article["card_image"]) ?>" alt="<?= htmlspecialchars($article["title"]) ?>">
                            </div>
                            <div class="article-card-body">
                                <span class="article-tag"><?= htmlspecialchars($article["category"]) ?></span>
                                <a class="article-text-link" href="./one-article.php?slug=<?= urlencode($article["slug"]) ?>">
                                    <h3><?= htmlspecialchars($article["title"]) ?></h3>
                                    <p><?= htmlspecialchars($article["excerpt"]) ?></p>
                                </a>
                                <a class="article-link" href="./one-article.php?slug=<?= urlencode($article["slug"]) ?>">
                                    Čítať viac <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="articles-cta">
                    <a class="articles-cta-link" href="./articles.php">Všetky články</a>
                </div>
            </div>
        </section>

        <?php
        $contact_section_id = "kontakt";
        $contact_section_class = "contact-section";
        $contact_form_action = "index.php#kontakt";

        require "assets/contact-form-section.php";
        ?>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
</body>

</html>
