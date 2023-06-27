<?php
if (isset($_SESSION["id"])) {
    if ($_SESSION["role"] == 0) {
        header("Location: admin.php");
    } elseif ($_SESSION["role"] == 1) {
        header("Location: quizzer.php");
    } else {
        header("Location: user.php");
    }
} else {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur</title>
</head>

<body>
    <p>Vous n'avez pas accès à cette page</p>
</body>

</html>