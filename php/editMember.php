<?php
require "classes.php";

if (empty($_GET["id"]) || empty($_GET["pseudo"])) {
    header("Location: adminPage.php");
}

if (isset($_POST["newpassword"]) && isset($_POST["password"])) {
    $editPassword = new Admin();
    $editPassword->editPassword($_POST["newpassword"], $_POST["confirmnewpassword"], $_GET["id"]);
}

if (isset($_POST["newpseudo"])) {
    $editPseudo = new Admin();
    $editPseudo->editPseudo($_POST["newpseudo"], $_GET["id"]);
}

if (isset($_POST["newemail"])) {
    $editEmail = new Admin();
    $editEmail->editEmail($_POST["newemail"], $_GET["id"]);
}

if (!isset($_POST["newpseudo"])) {
    if (isset($_GET["pseudo"])) {
        $pseudo = $_GET["pseudo"];
    }
} else {
    $pseudo = $_POST["newpseudo"];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require "css.php";
    ?>
    <title>Modifier utilisateur</title>
</head>

<body>
    <?php
    require "headerAdmin.php";
    ?>
    *    <?php
    require "interro.php";
    ?>


    <h2>Modifier utilisateur : <?php echo $pseudo; ?></h2>
    <br>
    <div class="card">
            <div class="container vertical-scrollable">
                <div class="row text-center">
    <form method="POST"><b>Modifier mot de passe :</b>
        <br><br>
        <label>Nouveau mot de passe : </label>
        <br>
        <input type="password" name="newpassword" placeholder="Nouveau mot de passe">
        <br><br>
        <label>Confirmer nouveau mot de passe : </label>
        <br>
        <input type="password" name="confirmnewpassword" placeholder="Confirmer nouveau mot de passe">
        <br><br>
        <input type="submit" name="submitpassword" value="Valider">
    </form>
    <br><br>
    <form method="POST"><b>Modifier pseudo : </b>
        <br><br>
        <label>Nouveau pseudo : </label>
        <br>
        <input type="text" name="newpseudo" placeholder="Nouveau pseudo">
        <br><br>
        <input type="submit" name="submitpseudo" value="Valider">
    </form>
    <br><br>
    <form method="POST"><b>Modifier email : </b>
        <br><br>
        <label>Nouvel email : </label>
        <br>
        <input type="text" name="newemail" placeholder="Nouvel email">
        <br><br>
        <input type="submit" name="submitemail" value="Valider">
    </form>
    </div>

</div>
</div>
    <?php
    require "logo.php";
    ?>
   
    <?php
    require "footer.php";
    ?>
</body>

</html>