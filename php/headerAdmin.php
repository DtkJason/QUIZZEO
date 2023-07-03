<header>
    <p class="logo">QUIZZEO</p>
    <nav class="allNav">
        <ul class="navlinks">
            <li><a href="admin.php" class="link">Accueil</a></li>
            <li><a href="adminPage.php" class="link">Gérer Membres</a></li>
            <li><a href="allQuizzAdmin.php" class="link">Liste Quizz</a></li>
            <li><a href="createQuizz.php" class="link">Créer Quizz</a></li>
        </ul>
    </nav>
    <span class="logged"><?php echo "Connecté(e) : " . $pseudo; ?></span>
    <a href="disconnect.php" class="disconnect link">Déconnexion</a>
</header>