<?php

try {
    $bdd = new PDO("mysql:host=localhost;dbname=quizzeo", "root",);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
