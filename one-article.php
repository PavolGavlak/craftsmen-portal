<?php require_once "assets/articles-data.php"; ?>
<?php

$slug = $_GET["slug"] ?? "";
$article = getArticleBySlug($slug);

if ($article === null) {
    http_response_code(404);
}

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./css/one-article.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>
    <title><?= $article ? htmlspecialchars($article["title"]) : "Článok nenájdený" ?></title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main class="article-detail-page">
        <div class="article-detail-shell">
            <?php if ($article === null): ?>
                <section class="article-not-found">
                    <h1>Článok sa nepodarilo nájsť</h1>
                    <p>Skúste sa vrátiť na zoznam článkov a vybrať si iný príspevok.</p>
                    <a class="article-back-link" href="./articles.php">Späť na články</a>
                </section>
            <?php else: ?>
                <article class="article-detail">
                    <a class="article-back-link" href="./articles.php">&larr; Späť na články</a>

                    <div class="article-detail-header">
                        <span class="article-detail-tag"><?= htmlspecialchars($article["category"]) ?></span>
                        <h1><?= htmlspecialchars($article["title"]) ?></h1>
                        <p class="article-detail-lead"><?= htmlspecialchars($article["lead"]) ?></p>
                    </div>

                    <div class="article-detail-hero">
                        <img src="<?= htmlspecialchars($article["detail_images"][0]) ?>" alt="<?= htmlspecialchars($article["title"]) ?>">
                    </div>

                    <div class="article-detail-content">
                        <?php foreach ($article["body"] as $paragraph): ?>
                            <p><?= htmlspecialchars($paragraph) ?></p>
                        <?php endforeach; ?>
                    </div>

                    <div class="article-detail-gallery">
                        <?php foreach ($article["detail_images"] as $image): ?>
                            <div class="article-detail-gallery-item">
                                <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($article["title"]) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
</body>

</html>
