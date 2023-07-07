<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <?php
    require "css.php";
    ?>
    <title>Accueil - QUIZZEO</title>
</head>

<body>

<?php
    require "headerOffline.php";
    ?>
    <?php
    require "interro.php";
    ?>
    <div class="rolee">
        <h1>QUIZZEO</h1><br>
        <h2>Bienvenue sur QUIZZEO !</h2><br>
    </div>
    <div class="message">
        <p>QUIZZEO est une plateforme de quizz en ligne qui vous permet de créer des quizz personnalisés.<br>
        Cliquer sur Connexion si vous avez déjà un compte, <br>sinon vous pouvez vous inscrire soit en tant qu'utilisateur simple (qui vous simplement de jouer à des quizz) <br>ou soit en tant que quizzer (qui vous permet de créer et jouer à des quizz).<br><br>
        Ce projet a été réalisé dans le cadre d'un projet à l'IPSSI <br>par deux étudiants de la classe BTC 25.2 :<br>
        Jason KINVI<br>
        Jordan RANDRIAMANANTENA</p>
    </div>
    


    <?php
    require "logo.php";
    ?>
   

    <?php
    require "footer.php";
    ?>

</body>

</html>