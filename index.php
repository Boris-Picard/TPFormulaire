<?php
    require('./controllers/signUp-ctrl.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('./views/head.php') ?>
    <title>Formulaire</title>
</head>
<body>
    <header>
        <?php include('./views/header.php')?>
    </header>
    <main class="main">
        <?php include('./views/signUp.php')?>
    </main>
    <footer>
        <?php include('./views/footer.php') ?>
    </footer>
    <script src="./public/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>