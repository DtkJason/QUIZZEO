<?php
require "classes.php";

if (empty($_SESSION["id"])) {
  header("Location: login.php");
}

if ($_SESSION["role"] == 2) {
  header("Location: accessDenied.php");
}

if (isset($_POST["submit"])) {
  $quizz = new Quizz();
  $newQuizz = $quizz->addQuizz($_POST["title"], $_POST["quizz-difficulty"], $_SESSION["id"]);
  $idQuizz = $quizz->getIdQuizz($_POST["title"], $_POST["quizz-difficulty"], $_SESSION["id"]);

  $question = new Question();
  $choix = new Choix();
  $a = 1;
  do {
    if (isset($_POST["Question" . $a]) && isset($_POST["diff" . $a])) {
      $newQuestion = $question->addQuestion($_POST["Question" . $a], $_POST["diff" . $a]);
      $idQuestion = $question->getIdQuestion($_POST["Question" . $a], $_POST["diff" . $a]);
      if (isset($_POST["BRepons" . $a])) {
        $goodAnswer = $choix->addChoice($_POST["BRepons" . $a], true, $idQuestion);
      }
      for ($i = 1; $i <= 3; $i++) {
        $newChoix = $choix->addChoice($_POST["MRepons" . $i . "-" . $a], false, $idQuestion);
      }
      $question->addQuizzQuestion($idQuizz, $idQuestion);
    }
    $a++;
  } while (isset($_POST["Question" . $a]));

  echo '<script type="text/javascript">';
  echo 'alert("Quizz créé !")';
  echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <title>Créer Quizz</title>
</head>



<body>
  <?php
  if ($_SESSION["role"] == 0) {
    require "headerAdmin.php";
  }
  if ($_SESSION["role"] == 1) {
    require "headerQuizzer.php";
  }
  ?>

  <h2>Création de votre Quizz</h2><br>

  <!-- Button trigger modal -->

  <div class="cardo card w-50">
    <div class="card-body">
      <h5 class="card-title">Quizz</h5>
      <p class="card-text">Créer et personnaliser votre Quizz</p>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Créer
      </button><br>
    </div>
  </div>

  <!-- Modal -->
  <div class="modo modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modoh modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Nouveau Quizz</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modob modal-body">
          <div class="">
            <form method="POST">
              <div id="field">
                <label>Titre</label>
                <input type="text" name="title" required="">
                <br>
                <label>Difficulté du Quizz : </label>
                <br>
                <select name="quizz-difficulty">
                  <option value=""></option>
                  <option value="1">Facile</option>
                  <option value="2">Intermédiaire</option>
                  <option value="3">Difficile</option>
                </select><br>

                <!-- <label>Question</label><br>
                <input type="text" name="question-n1" required=""> <br>
                <label>Reponse</label><br>
                <input id="rep" type="text" name="text" class="text" placeholder="entrer une reponse"><br>
              </div>
              <br>
              <span>autre question</span> -->
                <div id="nformi">
                </div>
                <input type="submit" name="submit" id="" value="Valider"><br>
                <!-- <input id="demo" type="text" name="demo">1</input> <span id="demo" name="counter"  value= 1 ></span> -->

            </form>

            <div id="nformu">
            </div>
          </div>
          <div>
            <br>
            <div class="controlss">
              <button class="ajout" onclick="ajout()">Ajouter une question</button>
              <button class="suppr" onclick="suppr()">Supprimer une question</button>
            </div>

          </div>
        </div>
        <div class="modof modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div><br><br>

  <!-- <div class="divoq divoq1">
        <form>
            <div id="field">
                <label>Title</label>
                <input type="text" name="title" required=""> <br><br>
                <label>Question</label><br>
                <input type="text" name="question n°1" required=""> <br>
                <label>Reponse</label><br>
                <input id="rep" type="text" name="text" class="text"  placeholder="entrer une reponse"><br>
                <input type="radio" name="bad" required="" placeholder="entrer une mauvaise reponse"> <br>
            </div>
        </form>
        <div id="nformu">
        </div>
    </div>
    <div>
        <div class="controls">
            <button class="add"  onclick="add()">Ajoute une reponse</button>
            <button class="remove" onclick="remove()">suppr une reponse</button>
            <button class="addquest" id="addo" onclick="addquest()">add question</button>   aez²&rté"'()'
          </div><br><br>
          <span>autre question</span>
          <div id="nformi">
          </div>
          <div class="controlss">
            <button class="ajout"  onclick="ajout()">Ajout une question</button>
            <button class="suppr" onclick="suppr()">suppr les question</button>
          </div>
          <p>il y a  : <span id="demo"> </span>  question</p>
    </div> -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

  <script src="quiz1.js"></script>

  <?php
  require "footer.php";
  ?>
</body>

</html>