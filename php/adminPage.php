<<<<<<< HEAD
<?php
require "classes.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Administrateur</title>
</head>

<body>
    <h1>Gérer les membres</h1>

    <?php
    $admin = new Admin();
    $admin->displayUsers();
    ?>

</body>

=======
<?php
require "classes.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Administrateur</title>
</head>

<body>
    <h1>Gérer les membres</h1>

    <?php
    $admin = new Admin();
    $admin->displayUsers();
    ?>

</body>

>>>>>>> 4972b6d96e98a2c84997d99455e343c43cdcf1f0
</html>