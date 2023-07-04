<header>
    <p>QUIZZEO</p>
    <nav>
        <ul>
            <li><a href="admin.php">Accueil</a></li>
            <li><a href="adminPage.php">Gérer Membres</a></li>
            <li><a href="allQuizzAdmin.php">Liste Quizz</a></li>
            <li><a href="createQuizz.php">Créer Quizz</a></li>
        </ul>
    </nav>
    <span><?php echo "Connecté(e) : " . $pseudo; ?></span>
    <a href="disconnect.php" class="disconnect link">Déconnexion</a>
</header>