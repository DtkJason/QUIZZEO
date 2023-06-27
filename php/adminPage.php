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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Administrateur</title>
</head>

<?php
require "headerAdmin.php";
?>

<body>
    <h2>Gérer les membres</h2>

    <?php
    $display = new Admin();
    $display->displayUsers();
    ?>

</body>

</html>