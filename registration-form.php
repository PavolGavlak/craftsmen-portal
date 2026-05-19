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
    <link rel="stylesheet" href="./css/registration-form.css">
    <title>Registrácia</title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main>
        <section class="registration-form">
            <div class="registration-panel">
                <h1>Registrácia</h1>
                <form action="admin/after-registration.php" method="POST">
                    <input class="reg-input" type="text" name="first_name" placeholder="Krstné meno" required><br>
                    <input class="reg-input" type="text" name="second_name" placeholder="Priezvisko" required><br>
                    <input class="reg-input" type="email" name="email" placeholder="E-mail" required><br>
                    <input class="reg-input" type="text" name="business_name" placeholder="Obchodný názov" required><br>
                    <input class="reg-input" type="text" name="craft_name" placeholder="Názov remesla" required><br>
                    <input class="reg-input" type="text" name="city" placeholder="Mesto alebo obec" required><br>
                    <input class="reg-input" type="text" name="phone" placeholder="Telefón"><br>
                    <input class="reg-input" type="text" name="facebook" placeholder="Facebook profil alebo odkaz"><br>
                    <textarea class="reg-input" name="description" placeholder="Popis vašej tvorby alebo remesla"></textarea><br>
                    <input class="reg-input pass1" type="password" name="password" placeholder="Heslo" minlength="6" required><br>
                    <input class="reg-input pass2" type="password" name="password-again" placeholder="Heslo znova" minlength="6" required><br>
                    <p class="result-text"></p>
                    <input class="btn" type="submit" value="Zaregistrovať">
                </form>
            </div>
        </section>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
    <script src="./JS/passcheck.js"></script>
</body>

</html>
