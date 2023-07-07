<header>
    <!-- <img src="" alt=""> -->
    <img src='../css/quizzeo.png' alt='' style='height: 75px; width: 140px;' >
    <nav class="allNav">
        <ul class="navlinks">
            <li><a href="quizzer.php" class="link">Accueil</a></li>
            <li><a href="allQuizz.php" class="link">Liste des Quizz</a></li>
            <li><a href="allPersonnalQuizz.php" class="link">Liste de mes Quizz</a></li>
            <li><a href="createQuizz.php" class="link">Créer un Quizz</a></li>
            <li><span class="logged"><?php echo "Connecté(e) : " . $pseudo; ?></span></li>
            <li> <a href="disconnect.php" class="link disconnect ">Déconnexion</a></li>
            
        </ul>
    </nav>
    <!-- <span class="logged"><?php echo "Connecté(e) : " . $pseudo; ?></span> -->
   
</header>