<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] != 0) {
    header("Location: accessDenied.php");
}

if (!empty($_GET["delete"]) && !empty($_GET["pseudoDelete"])) {
    $pseudoDelete = $_GET["pseudoDelete"];
    echo '<script type="text/javascript">';
    echo 'alert("Utilisateur supprimé : ' . $pseudoDelete . '")';
    echo '</script>';
}

$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <?php
    require "css.php";
    ?>
    <title>Gérer Membres - Administrateur</title>
</head>


<body>
    <?php
    require "headerAdmin.php";
    ?>
    <?php
    require "interro.php";
    ?>
    <div class="rolee">
        <h2>Gérer les membres</h2>
    </div>
    

    <?php
    $display = new Admin();
    $display->displayUsers();
    ?>
    <?php
    require "logo.php";
    ?>
    <?php
    require "footer.php";
    ?>
</body>


</html>