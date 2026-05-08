<?php require_once "assets/articles-data.php"; ?>
<?php $articles = getArticlesData(); ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./css/articles.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>
    <title>Články</title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main class="articles-page">
        <section class="articles-hero">
            <div class="articles-shell">
                <span class="articles-kicker">Príbehy, reportáže a rozhovory</span>
                <h1>Články</h1>
                <p>
                    Nájdete tu výber reportáží, rozhovorov a súťažných prehľadov zo sveta
                    tradičnej aj súčasnej remeselnej tvorby.
                </p>
            </div>
        </section>

        <section class="articles-list-section">
            <div class="articles-shell">
                <div class="articles-list-grid">
                    <?php foreach ($articles as $article): ?>
                        <article class="article-preview-card">
                            <div class="article-preview-visual">
                                <img src="<?= htmlspecialchars($article["card_image"]) ?>" alt="<?= htmlspecialchars($article["title"]) ?>">
                            </div>

                            <div class="article-preview-body">
                                <span class="article-preview-tag"><?= htmlspecialchars($article["category"]) ?></span>
                                <a class="article-preview-text-link" href="./one-article.php?slug=<?= urlencode($article["slug"]) ?>">
                                    <h2><?= htmlspecialchars($article["title"]) ?></h2>
                                    <p><?= htmlspecialchars($article["excerpt"]) ?></p>
                                </a>
                                <a class="article-preview-link" href="./one-article.php?slug=<?= urlencode($article["slug"]) ?>">
                                    Čítať viac <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
</body>

</html>
