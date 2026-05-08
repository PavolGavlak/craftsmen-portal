<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/signin.css">

    <title>Prihlásenie</title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main>
        <section class="form">
            <div class="signin-panel">
                <h1>Prihlásenie</h1>
                <form action="admin/login.php" method="POST">
                    <input class="email" type="email" name="login-email" placeholder="E-mail"><br>
                    <input class="password" type="password" name="login-password" placeholder="Heslo"><br>
                    <input class="btn" type="submit" value="Prihlásiť sa">
                </form>
            </div>
        </section>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
</body>

</html>
