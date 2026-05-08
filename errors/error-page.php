<?php

$error_text = $_GET["error_text"] ?? "Nastala neznáma chyba.";

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/general.css">

    <title>Chyba</title>
</head>

<body>
    <main>
        <section class="error">
            <p><?= htmlspecialchars($error_text) ?></p>
        </section>

        <section class="link">
            <a href="../admin/craftsmen.php">Späť na úvodnú stranu administrácie</a>
        </section>
    </main>

    <script src="../JS/header.js"></script>
</body>

</html>
