<header>
<img src='../css/quizzeo.png' alt='' style='height: 75px; width: 140px;' >
    <nav class="allNav">
        <ul class="navlinks">
            <li><a href="user.php" class="link">Accueil</a></li>
            <li><a href="allQuizz.php" class="link">Liste des Quizz</a></li>
        </ul>
    </nav>
    <span class="logged"><?php echo "Connecté(e) : " . $pseudo; ?></span>
    <a href="disconnect.php" class="disconnect link">Déconnexion</a>
</header>