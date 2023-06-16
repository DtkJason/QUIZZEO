<?php

try {
    $bdd = new PDO("mysql:host=localhost;dbname=test", "root",);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
