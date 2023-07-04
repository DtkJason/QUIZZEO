<?php
//Démarrage de la session
session_start();

//Classe qui permet de se connecter à la base de données
class ConnectionDB
{
    public $host = "localhost";
    public $user = "root";
    public $name = "quizzeo";
    public $bdd;

    public function __construct()
    {
        $this->bdd = new PDO("mysql:host=$this->host;dbname=$this->name", $this->user);
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

//Classe qui permet de gérer l'inscription et la connexion
class Authentification extends ConnectionDB
{
    public $idUser;
    public $role;

    //Fonction qui permet la vérification de l'existence de l'utilisateur saisi, et de son insertion dans le cas contraire
    public function registration($pseudo, $email, $password, $confirmpassword, $role)
    {
        if (!empty($pseudo) && !empty($email) && !empty($password) && !empty($confirmpassword) && !empty($role)) {
            //Requête qui permet vérifier si le nouvel utilisateur existe dans la base de données
            $query1 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE pseudo_utilisateur = :pseudo OR email_utilisateur = :email");
            $query1->bindParam(":pseudo", $pseudo);
            $query1->bindParam(":email", $email);
            $query1->execute();

            //Condition qui permet de vérifier si l'utilisateur choisi existe
            if ($query1->rowCount() > 0) {
                //Utilisateur déjà existant
                echo '<script type="text/javascript">';
                echo 'alert("Pseudo ou email est déjà utilisé")';
                echo '</script>';
            } else {
                //Vérification des mots de passe
                if ($password == $confirmpassword) {
                    //Requête qui permet d'insérer les informations du nouvel utilisateur
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $query2 = $this->bdd->prepare("INSERT INTO utilisateur(pseudo_utilisateur, email_utilisateur, mdp_utilisateur, role_utilisateur) VALUES (:pseudo, :email, :mdp, :roles)");
                    $query2->bindParam(":pseudo", $pseudo);
                    $query2->bindParam(":email", $email);
                    $query2->bindParam(":mdp", $passwordHash);
                    $query2->bindParam(":roles", $role);
                    $query2->execute();

                    header("Location: login.php?reg=1");
                } else {
                    //Les mots de passe ne sont pas identiques
                    echo '<script type="text/javascript">';
                    echo 'alert("Les mots de passe ne correspondent pas")';
                    echo '</script>';
                }
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Veuillez compléter tous les champs !")';
            echo '</script>';
        }
    }

    //Fonction qui permet la vérification de l'existence de l'utilisateur et de le connecter s'il existe
    public function login($email, $password)
    {
        //Requête qui permet de vérifier si l'email existe dans la base de données
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE email_utilisateur = :email");
        $query1->bindParam(":email", $email);
        $query1->execute();
        $row = $query1->fetch(PDO::FETCH_ASSOC);

        //Email existant
        if ($row == true) {
            if (password_verify($password, $row["mdp_utilisateur"]) == true) {
                $this->idUser = $row["id_utilisateur"];
                $this->role = $row["role_utilisateur"];

                if ($this->role == 0) {
                    header("Location: admin.php");
                } elseif ($this->role == 1) {
                    header("Location: quizzer.php");
                } else {
                    header("Location: user.php");
                }
            } else {
                //Mot de passe incorrect
                echo '<script type="text/javascript">';
                echo 'alert("Mot de passe incorrect")';
                echo '</script>';
            }
        } else {
            //Utilisateur inexistant
            echo '<script type="text/javascript">';
            echo 'alert("Utilisateur inexistant")';
            echo '</script>';
        }
    }

    //Fonction qui permet de récupérer l'id de l'utilisateur concerné
    public function getIdUser()
    {
        return $this->idUser;
    }

    //Fonction qui permet de récupérer le rôle de l'utilisateur concerné
    public function getRoleUser()
    {
        return $this->role;
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

//Classe qui permet de gérer les Quizz
class Quizz extends ConnectionDB
{
    public $date;
    public $idQuizz;

    //Fonction qui permet d'insérer les informations d'un Quizz dans la base de données
    public function addQuizz($titleQuizz, $difficulteQuizz, $idUserQuizz)
    {
        $dateQuizz = date("Y-m-d");
        $query1 = $this->bdd->prepare("INSERT INTO quizz(titre_quizz, difficulte_quizz, date_creation_quizz, id_utilisateur) VALUES (:titleQuizz, :difficulteQuizz, :dateQuizz, :idUserQuizz)");
        $query1->bindParam(":titleQuizz", $titleQuizz);
        $query1->bindParam(":difficulteQuizz", $difficulteQuizz);
        $query1->bindParam("dateQuizz", $dateQuizz);
        $query1->bindParam(":idUserQuizz", $idUserQuizz);
        $query1->execute();
    }

    //Fonction qui permet de récupérer l'ID d'un Quizz
    public function getIdQuizz($titleQuizz, $difficulteQuizz, $idUserQuizz)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz WHERE titre_quizz = :titleQuizz AND difficulte_quizz = :difficulteQuizz AND id_utilisateur = :idUserQuizz");
        $query1->bindParam(":titleQuizz", $titleQuizz);
        $query1->bindParam(":difficulteQuizz", $difficulteQuizz);
        $query1->bindParam(":idUserQuizz", $idUserQuizz);
        $query1->execute();

        $data1 = $query1->fetch(PDO::FETCH_ASSOC);

        $this->idQuizz = $data1["id_quizz"];
        return $this->idQuizz;
    }

    //Fonction qui permet d'afficher la liste des Quizz
    public function displayAllQuizz()
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz");
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom du Quizz</td>";
        echo "<td>Difficulté Quizz</td>";
        echo "<td>Date de création</td>";
        echo "<td>Créateur</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data1 as $row) {
            $idUserQuizz = $row["id_utilisateur"];
            $query2 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
            $query2->bindParam(":idUser", $idUserQuizz);
            $query2->execute();
            $data2 = $query2->fetch(PDO::FETCH_ASSOC);

            $userPseudo = $data2["pseudo_utilisateur"];
            $idQuizz = $row["id_quizz"];

            echo "<tr>";
            echo "<td>" . $row["titre_quizz"] . "</td>";
            if ($row["difficulte_quizz"] == 1) {
                echo "<td>Facile</td>";
            } elseif ($row["difficulte_quizz"] == 2) {
                echo "<td>Intermédiaire</td>";
            } else {
                echo "<td>Difficile</td>";
            }
            echo "<td>" . $row["date_creation_quizz"] . "</td>";
            echo "<td>" . $userPseudo . "</td>";
            echo "<td><a href='playQuizzDisplay.php?idQuizz=$idQuizz'>Jouer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    //Fonction qui permet d'afficher la liste des Quizz en fonction du Quizzer
    public function displayPersonnalQuizz($idUserQuizz)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_utilisateur = :idUser");
        $query1->bindParam(":idUser", $idUserQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);


        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom du Quizz</td>";
        echo "<td>Difficulté Quizz</td>";
        echo "<td>Date de création</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data1 as $row) {
            echo "<tr>";
            echo "<td>" . $row["titre_quizz"] . "</td>";
            if ($row["difficulte_quizz"] == 1) {
                echo "<td>Facile</td>";
            } elseif ($row["difficulte_quizz"] == 2) {
                echo "<td>Intermédiaire</td>";
            } else {
                echo "<td>Difficile</td>";
            }

            $idQuizz = $row["id_quizz"];

            echo "<td>" . $row["date_creation_quizz"] . "</td>";
            echo "<td><a href='playQuizzDisplay.php?idQuizz=$idQuizz'>Jouer</a></td>";
            echo "<td><a href='modifQuizzQuizzer.php?idQuizz=$idQuizz&idUser=$idUserQuizz'>Modifier</a></td>";
            echo "<td><a href='deleteQuizz.php?idQuizz=$idQuizz'>Supprimer</a></td>";
            echo "</tr>";
        }
    }

    public function displayQuizzForm($idQuizz)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_quizz = :idQuizz");
        $query1->bindParam("idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetch(PDO::FETCH_ASSOC);

        $titreQuizz = $data1["titre_quizz"];

        $query2 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query2->bindParam("idQuizz", $idQuizz);
        $query2->execute();
        $data2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>$titreQuizz</h1>";
        echo "<form method='POST'>";

        $i = 1;

        foreach ($data2 as $row) {
            $idQuestion = $row["id_question"];
            $query3 = $this->bdd->prepare("SELECT * FROM question WHERE id_question = :idQuestion");
            $query3->bindParam(":idQuestion", $idQuestion);
            $query3->execute();
            $data3 = $query3->fetch(PDO::FETCH_ASSOC);

            $intituleQuestion = $data3['intitule_question'];
            $idQuestion = $data3["id_question"];

            echo "<p>Question $i : $intituleQuestion  </p><br>";

            $bool = true;

            $query4 = $this->bdd->prepare("SELECT * FROM choix WHERE id_question = :idQuestion AND bonneReponse_choix = :goodAnswer");
            $query4->bindParam(":idQuestion", $idQuestion);
            $query4->bindParam(":goodAnswer", $bool);
            $query4->execute();
            $data4 = $query4->fetch(PDO::FETCH_ASSOC);

            $goodAnswer = $data4["reponse_choix"];
            $goodAnswerId = $data4["id_choix"];

            $badAnswerId1 = $goodAnswerId + 1;
            $badAnswerId2 = $goodAnswerId + 2;
            $badAnswerId3 = $goodAnswerId + 3;

            $query5 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query5->bindParam(":idChoix", $badAnswerId1);
            $query5->execute();
            $data5 = $query5->fetch(PDO::FETCH_ASSOC);

            $query6 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query6->bindParam(":idChoix", $badAnswerId2);
            $query6->execute();
            $data6 = $query6->fetch(PDO::FETCH_ASSOC);

            $query7 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query7->bindParam(":idChoix", $badAnswerId3);
            $query7->execute();
            $data7 = $query7->fetch(PDO::FETCH_ASSOC);

            $badAnswer1 = $data5["reponse_choix"];
            $badAnswer2 = $data6["reponse_choix"];
            $badAnswer3 = $data7["reponse_choix"];

            $tab = array(
                $goodAnswer,
                $badAnswer1,
                $badAnswer2,
                $badAnswer3
            );

            $keys = array_keys($tab);
            shuffle($keys);

            $answer1 = $tab[$keys[0]];
            $answer2 = $tab[$keys[1]];
            $answer3 = $tab[$keys[2]];
            $answer4 = $tab[$keys[3]];

            echo "<input type='radio' name='reponse$i' value='$answer1'>";
            echo "<label> Réponse $i ($answer1) : </label><br>";

            echo "<input type='radio' name='reponse$i' value='$answer2'>";
            echo "<label> Réponse $i-1 ($answer2) : </label><br>";

            echo "<input type='radio' name='reponse$i' value='$answer3'>";
            echo "<label>Réponse $i-2 ($answer3) : </label><br>";

            echo "<input type='radio' name='reponse$i' value='$answer4'>";
            echo "<label> Réponse $i-3 ($answer4) : </label><br><br>";
            $i++;
        }
        echo "<input type='submit' name='submit'>";
        echo "</form>";
    }

    //Fonction qui permet de récupérer le score
    public function recupLastScore($idUser)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur_quizz WHERE id_utilisateur = :idUser");
        $query1->bindParam(":idUser", $idUser);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data1 as $row) {
            $score = $row["score"];
            $idQuizz = $row["id_quizz"];
        }

        $query2 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_quizz = :idQuizz");
        $query2->bindParam(":idQuizz", $idQuizz);
        $query2->execute();
        $data2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data2 as $row) {
            $nomQuizz = $row["titre_quizz"];
        }

        if (isset($nomQuizz)) {
            echo "<p>Votre dernière partie -> $nomQuizz | Score : $score</p>";
        }
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

//Classe qui permet de gérer les Questions
class Question extends ConnectionDB
{
    public $idQuestion;

    //Fonction qui permet d'insérer les informations d'une Question dans la base de données
    public function addQuestion($intituleQuestion, $difficulteQuestion)
    {
        $dateQuestion = date("Y-m-d");
        $query1 = $this->bdd->prepare("INSERT INTO question(intitule_question, difficulte_question, date_creation_question) VALUES (:intituleQuestion, :difficulteQuestion, :dateQuestion)");
        $query1->bindParam(":intituleQuestion", $intituleQuestion);
        $query1->bindParam(":difficulteQuestion", $difficulteQuestion);
        $query1->bindParam(":dateQuestion", $dateQuestion);
        $query1->execute();
    }

    //Fonction qui permet de récupérer l'ID d'une Question
    public function getIdQuestion($intituleQuestion, $difficulteQuestion)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM question WHERE intitule_question = :intituleQuestion AND difficulte_question = :difficulteQuestion");
        $query1->bindParam(":intituleQuestion", $intituleQuestion);
        $query1->bindParam(":difficulteQuestion", $difficulteQuestion);
        $query1->execute();

        $data1 = $query1->fetch(PDO::FETCH_ASSOC);

        $this->idQuestion = $data1["id_question"];
        return $this->idQuestion;
    }

    //Fonction qui permet d'associer un Quizz à une Question dans la base de données
    public function addQuizzQuestion($idQuizz, $idQuestion)
    {
        $query1 = $this->bdd->prepare("INSERT INTO quizz_question(id_quizz, id_question) VALUES (:idQuizz, :idQuestion)");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->bindParam(":idQuestion", $idQuestion);
        $query1->execute();
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

//Classe qui permet de gérer les Choix
class Choix extends ConnectionDB
{
    public $idChoix;

    //Fonction qui permet d'insérer les informations d'un Choix dans la base de données
    public function addChoice($reponseChoix, $bonneReponse, $idQuestion)
    {
        $query1 = $this->bdd->prepare("INSERT INTO choix(reponse_choix, bonneReponse_choix, id_question) VALUES (:reponseChoix, :bonneReponse, :idQuestion)");
        $query1->bindParam(":reponseChoix", $reponseChoix);
        $query1->bindParam(":bonneReponse", $bonneReponse);
        $query1->bindParam(":idQuestion", $idQuestion);
        $query1->execute();
    }

    //Fonction qui permet de récupérer la bonne réponse d'une Question
    public function getGoodAnswer($idQuizz, $i)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $j = 1;
        foreach ($data1 as $row) {
            ${"idQuestion" . $j} = $row["id_question"];
            $array[] = ${"idQuestion" . $j};
        }

        $questionPos = $i - 1;
        $bool = true;

        $query2 = $this->bdd->prepare("SELECT * FROM choix WHERE id_question = :idQuestion AND bonneReponse_choix = :bool");
        $query2->bindParam(":idQuestion", $array[$questionPos]);
        $query2->bindParam(":bool", $bool);
        $query2->execute();
        $data2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data2 as $row) {
            $goodAnswer = $row["reponse_choix"];
        }
        return $goodAnswer;
    }
}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

//Classe qui permet de gérer la partie Administration
class Admin extends ConnectionDB
{
    //Fonction qui permet d'afficher tous les membres
    public function displayUsers()
    {
        //Requête qui permet de sélectionner tous les utilisateurs dans la table utilisateur
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur");
        $query1->execute();

        //Stockage des informations récupérées dans un tableau associatif
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>ID</td>";
        echo "<td>Pseudo</td>";
        echo "<td>Email</td>";
        echo "<td>Type de compte</td>";
        echo "</tr>";
        echo "</thead>";

        //Boucle qui permet l'affichage de chaque utilisateur
        foreach ($data1 as $row) {
            if ($row["role_utilisateur"] != 0) {
                $idUser = $row["id_utilisateur"];
                $pseudoUser = $row["pseudo_utilisateur"];

                echo "<tr>";
                echo "<td>" . $idUser . "</td>";
                echo "<td>" . $pseudoUser . "</td>";
                echo "<td>" . $row["email_utilisateur"] . "</td>";
                if ($row["role_utilisateur"] == 1) {
                    echo "<td>Quizzer</td>";
                } else {
                    echo "<td>Utilisateur</td>";
                }
                echo "<td><a href='editMember.php?id=$idUser&pseudo=$pseudoUser'>Modifier</a></td>";
                echo "<td><a href='deleteMember.php?id=$idUser'>Supprimer</a></td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    //Fonction qui permet de modifier le propriétaire d'un quizz
    public function updateOwnerQuizz($idUser)
    {
        if (isset($idUser) && !empty($idUser)) {
            $newId = 1;
            //Requête qui permet de mettre à jour le propriétaire d'un quizz en modifiant l'id associé
            $query1 = $this->bdd->prepare("UPDATE quizz SET id_utilisateur = :newId WHERE id_utilisateur = :idUser");
            $query1->bindParam(":newId", $newId);
            $query1->bindParam(":idUser", $idUser);
            $query1->execute();
        } else {
            echo "Erreur ID";
        }
    }

    //Fonction qui permet la suppression d'un membre
    public function deleteMember($idUser)
    {
        //Requête qui permet de vérifier si l'utilisateur choisi existe dans la base de données
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
        $query1->bindParam(":idUser", $idUser);
        $query1->execute();

        //Si l'utilisateur existe
        if ($query1->rowCount() > 0) {
            //Requête qui permet de supprimer l'utilisateur choisi
            $query2 = $this->bdd->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :idUser");
            $query2->bindParam(":idUser", $idUser);
            $query2->execute();

            header("Location: adminPage.php");
        } else {
            //Utilisateur inexistant
            echo "Utilisateur inexistant";
        }
    }

    //Fonction qui permet de récupérer l'ID d'un utilisateur
    public function getUserPseudo($idUser)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
        $query1->bindParam(":idUser", $idUser);
        $query1->execute();
        $data1 = $query1->fetch(PDO::FETCH_ASSOC);

        $pseudoUser = $data1["pseudo_utilisateur"];
        return $pseudoUser;
    }

    //Fonction qui permet de modifier le mot de passe d'un utilisateur
    public function editPassword($newPass, $confirmPass, $idUser)
    {
        //Vérification de l'existence des données saisies
        if (isset($newPass) && isset($confirmPass)) {
            //Vérification des mots de passe
            if ($newPass == $confirmPass) {
                //Requête qui permet de modifier le mot de passe de l'utilisateur choisi
                $query1 = $this->bdd->prepare("UPDATE utilisateur SET mdp_utilisateur = :newpassword WHERE id_utilisateur = $idUser");
                $query1->bindParam(":newpassword", $newPass);
                $query1->execute();
                echo '<script type="text/javascript">';
                echo 'alert("Mot de passe modifié")';
                echo '</script>';
            } else {
                //Les mots de passe ne sont pas identiques
                echo "Les mots de passe ne correspondent pas";
            }
        } else {
            //Absence d'une saisie de donnée
            echo "Veuillez compléter tous les champs !";
        }
    }

    //Fonction qui permet de modifier le pseudo d'un utilisateur
    public function editPseudo($newpseudo, $idUser)
    {
        if (isset($newpseudo)) {
            //Requête qui permet de modifier le pseudo de l'utilisateur choisi
            $query1 = $this->bdd->prepare("UPDATE utilisateur SET pseudo_utilisateur = :newpseudo WHERE id_utilisateur = $idUser");
            $query1->bindParam(":newpseudo", $newpseudo);
            $query1->execute();
            echo '<script type="text/javascript">';
            echo 'alert("Pseudo modifié")';
            echo '</script>';
        } else {
            //Absence de saisie de donnée
            echo "Veuillez compléter tous les champs !";
        }
    }

    //Fonction qui permet de modifier l'email d'un utilisateur
    public function editEmail($newemail, $idUser)
    {
        if (isset($newemail)) {
            //Requête qui permet de modifier l'email de l'utilisateur choisi
            $query1 = $this->bdd->prepare("UPDATE utilisateur SET email_utilisateur = :newemail WHERE id_utilisateur = $idUser");
            $query1->bindParam(":newemail", $newemail);
            $query1->execute();
            echo '<script type="text/javascript">';
            echo 'alert("Email modifié")';
            echo '</script>';
        } else {
            //Absence de saisie de donnée
            echo "Veuillez compléter tous les champs !";
        }
    }

    //Fonction qui permet d'afficher la liste de Quizz pour les administrateurs avec les boutons modifier/supprimer
    public function listQuizzAdmin()
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz");
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom Quizz</td>";
        echo "<td>Difficulté Quizz</td>";
        echo "<td>Date de création</td>";
        echo "<td>Créateur</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data1 as $row) {
            $idUserQuizz = $row["id_utilisateur"];
            $query2 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
            $query2->bindParam(":idUser", $idUserQuizz);
            $query2->execute();
            $data2 = $query2->fetch(PDO::FETCH_ASSOC);

            $userPseudo = $data2["pseudo_utilisateur"];

            $query3 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_utilisateur = :idUser AND titre_quizz = :titreQuizz");
            $query3->bindParam(":idUser", $idUserQuizz);
            $query3->bindParam(":titreQuizz", $row["titre_quizz"]);
            $query3->execute();
            $data3 = $query3->fetch(PDO::FETCH_ASSOC);

            $idQuizz = $data3["id_quizz"];

            $query4 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
            $query4->bindParam(":idQuizz", $idQuizz);
            $query4->execute();
            $data4 = $query4->fetchAll(PDO::FETCH_ASSOC);

            $nbrQuestion = count($data4);

            echo "<tr>";
            echo "<td>" . $row["titre_quizz"] . "</td>";
            if ($row["difficulte_quizz"] == 1) {
                echo "<td>Facile</td>";
            } elseif ($row["difficulte_quizz"] == 2) {
                echo "<td>Intermédiaire</td>";
            } else {
                echo "<td>Difficile</td>";
            }
            echo "<td>" . $row["date_creation_quizz"] . "</td>";
            echo "<td>" . $userPseudo . "</td>";
            echo "<td><a href='playQuizzDisplay.php?idQuizz=$idQuizz'>Jouer</a></td>";
            echo "<td><a href='modifQuizz.php?idQuizz=$idQuizz&nbrQuestion=$nbrQuestion'>Modifier</a></td>";
            echo "<td><a href='deleteQuizz.php?idQuizz=$idQuizz'>Supprimer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    //Fonction qui permet de créer le formulaire qui va permettre de modifier un Quizz
    public function editQuizzForm($idQuizz)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_quizz = :idQuizz");
        $query1->bindParam("idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetch(PDO::FETCH_ASSOC);

        $titreQuizz = $data1["titre_quizz"];

        if ($data1["difficulte_quizz"] == 1) {
            $diffQuizz = "Facile";
        } elseif ($data1["difficulte_quizz"] == 2) {
            $diffQuizz = "Intermédiaire";
        } else {
            $diffQuizz = "Difficile";
        }

        $query2 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query2->bindParam("idQuizz", $idQuizz);
        $query2->execute();
        $data2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Modifier Quizz</h1>";
        echo "<form method='POST'>";
        echo "<label>Modifier Nom Quizz ($titreQuizz) : </label><br>";
        echo "<input type='text' name='nomQuizz' placeholder='Nouveau nom'><br><br>";
        echo "<label>Modifier Difficulté Quizz ($diffQuizz) : </label><br>";
        echo "<select name='diffQuizz'>";
        echo "<option value=''></option>";
        echo "<option value='1'>Facile</option>";
        echo "<option value='2'>Intermédiaire</option>";
        echo "<option value='3'>Difficile</option>";
        echo "</select><br><br><br>";

        $i = 1;

        foreach ($data2 as $row) {
            $idQuestion = $row["id_question"];
            $query3 = $this->bdd->prepare("SELECT * FROM question WHERE id_question = :idQuestion");
            $query3->bindParam(":idQuestion", $idQuestion);
            $query3->execute();
            $data3 = $query3->fetch(PDO::FETCH_ASSOC);

            $intituleQuestion = $data3['intitule_question'];
            $idQuestion = $data3["id_question"];

            if ($data3["difficulte_question"] == 1) {
                $diffQuestion = "Facile";
            } elseif ($data3["difficulte_question"] == 2) {
                $diffQuestion = "Intermédiaire";
            } else {
                $diffQuestion = "Difficile";
            }

            echo "<label>Modifier Question $i ($intituleQuestion) : </label><br>";
            echo "<input type='text' name='question$i' placeholder='Nouvelle question'><br><br>";

            echo "<label>Modifier Difficulté Question $i ($diffQuestion) : </label><br>";
            echo "<select name='diffQuestion$i'>";
            echo "<option value=''></option>";
            echo "<option value='1'>Facile</option>";
            echo "<option value='2'>Intermédiaire</option>";
            echo "<option value='3'>Difficile</option>";
            echo "</select><br><br>";

            $bool = true;

            $query4 = $this->bdd->prepare("SELECT * FROM choix WHERE id_question = :idQuestion AND bonneReponse_choix = :goodAnswer");
            $query4->bindParam(":idQuestion", $idQuestion);
            $query4->bindParam(":goodAnswer", $bool);
            $query4->execute();
            $data4 = $query4->fetch(PDO::FETCH_ASSOC);

            $goodAnswer = $data4["reponse_choix"];
            $goodAnswerId = $data4["id_choix"];

            $badAnswerId1 = $goodAnswerId + 1;
            $badAnswerId2 = $goodAnswerId + 2;
            $badAnswerId3 = $goodAnswerId + 3;

            $query5 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query5->bindParam(":idChoix", $badAnswerId1);
            $query5->execute();
            $data5 = $query5->fetch(PDO::FETCH_ASSOC);

            $query6 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query6->bindParam(":idChoix", $badAnswerId2);
            $query6->execute();
            $data6 = $query6->fetch(PDO::FETCH_ASSOC);

            $query7 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query7->bindParam(":idChoix", $badAnswerId3);
            $query7->execute();
            $data7 = $query7->fetch(PDO::FETCH_ASSOC);

            $badAnswer1 = $data5["reponse_choix"];
            $badAnswer2 = $data6["reponse_choix"];
            $badAnswer3 = $data7["reponse_choix"];

            echo "<label>Modifier Bonne Réponse $i ($goodAnswer) : </label><br>";
            echo "<input type='text' name='bonnereponse$i' placeholder='Nouvelle réponse'><br><br>";


            echo "<label>Modifier Mauvaise Réponse $i-1 ($badAnswer1) : </label><br>";
            echo "<input type='text' name='mauvaisereponse$i-1' placeholder='Nouvelle réponse'><br><br>";


            echo "<label>Modifier Mauvaise Réponse $i-2 ($badAnswer2) : </label><br>";
            echo "<input type='text' name='mauvaisereponse$i-2' placeholder='Nouvelle réponse'><br><br>";

            echo "<label>Modifier Mauvaise Réponse $i-3 ($badAnswer3) : </label><br>";
            echo "<input type='text' name='mauvaisereponse$i-3' placeholder='Nouvelle réponse'><br><br><br>";
            $i++;
        }

        echo "<input type='submit' name='submit'>";
        echo "</form>";
    }

    //Fonction qui permet de modifier le nom d'un Quizz
    public function editQuizzName($idQuizz, $newTitreQuizz)
    {
        $query1 = $this->bdd->prepare("UPDATE quizz SET titre_quizz = :newTitle WHERE id_quizz = :idQuizz");
        $query1->bindParam(":newTitle", $newTitreQuizz);
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
    }

    //Fonction qui permet de modifier la difficulté d'un Quizz
    public function editQuizzDiff($idQuizz, $newDiffQuizz)
    {
        $query1 = $this->bdd->prepare("UPDATE quizz SET difficulte_quizz = :newDiffQuizz WHERE id_quizz = :idQuizz");
        $query1->bindParam(":newDiffQuizz", $newDiffQuizz);
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
    }

    //Fonction qui permet de modifier le nom d'une Question
    public function editQuestionName($idQuizz, $newQuestionName, $a)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data1[$position]["id_question"];

        $query2 = $this->bdd->prepare("UPDATE question SET intitule_question = :newQuestionName WHERE id_question = :idQuestion");
        $query2->bindParam(":newQuestionName", $newQuestionName);
        $query2->bindParam(":idQuestion", $idQuestion);
        $query2->execute();
    }

    //Fonction qui permet de modifier la difficulté d'une Question
    public function editQuestionDiff($idQuizz, $newQuestionDiff, $a)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data1[$position]["id_question"];

        $query2 = $this->bdd->prepare("UPDATE question SET difficulte_question = :newQuestionDiff WHERE id_question = :idQuestion");
        $query2->bindParam(":newQuestionDiff", $newQuestionDiff);
        $query2->bindParam(":idQuestion", $idQuestion);
        $query2->execute();
    }

    //Fonction qui permet de modifier une bonne réponse
    public function editGoodAnswer($idQuizz, $newGoodAnswer, $a)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data1[$position]["id_question"];

        $bool = true;

        $query2 = $this->bdd->prepare("UPDATE choix SET reponse_choix = :newGoodAnswer WHERE bonneReponse_choix = :bool AND id_question = :idQuestion");
        $query2->bindParam(":newGoodAnswer", $newGoodAnswer);
        $query2->bindParam(":bool", $bool);
        $query2->bindParam(":idQuestion", $idQuestion);
        $query2->execute();
    }

    //Fonction qui permet de modifier une mauvaise réponse
    public function editBadAnswer($idQuizz, $newBadAnswer, $a)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data1[$position]["id_question"];
        $bool = false;

        $query2 = $this->bdd->prepare("SELECT * FROM choix WHERE bonneReponse_choix = :bool AND id_question = :idQuestion");
        $query2->bindParam(":bool", $bool);
        $query2->bindParam(":idQuestion", $idQuestion);
        $query2->execute();
        $data2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        $idChoix = $data2[$position]["id_choix"];

        $query3 = $this->bdd->prepare("UPDATE choix SET reponse_choix = :newBadAnswer WHERE id_choix = :idChoix");
        $query3->bindParam(":newBadAnswer", $newBadAnswer);
        $query3->bindParam(":idChoix", $idChoix);
        $query3->execute();
    }

    //Fonction qui permet de supprimer un Quizz
    public function deleteQuizz($idQuizz)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $query2 = $this->bdd->prepare("DELETE FROM quizz WHERE id_quizz = :idQuizz");
        $query2->bindParam(":idQuizz", $idQuizz);
        $query2->execute();

        foreach ($data1 as $row) {
            $query3 = $this->bdd->prepare("DELETE FROM question WHERE id_question = :idQuestion");
            $query3->bindParam(":idQuestion", $row["id_question"]);
            $query3->execute();
        }
    }

    //Fonction qui permet de récupérer le nombre de Question d'un Quizz
    public function getNumberQuestion($idQuizz)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        $nbrQuestion = count($data1);
        return $nbrQuestion;
    }

    //Fonction qui permet d'insérer le score d'un utilisateur dans la base de données
    public function insertScore($idUser, $idQuizz, $score)
    {
        $query1 = $this->bdd->prepare("INSERT INTO utilisateur_quizz(id_utilisateur, id_quizz, score) VALUES (:idUser, :idQuizz, :score)");
        $query1->bindParam(":idUser", $idUser);
        $query1->bindParam(":idQuizz", $idQuizz);
        $query1->bindParam(":score", $score);
        $query1->execute();
    }

    public function displayScores($idUser)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur_quizz WHERE id_utilisateur = :idUser");
        $query1->bindParam(":idUser", $idUser);
        $query1->execute();
        $data1 = $query1->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Vos parties</h3>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom Quizz</td>";
        echo "<td>Votre score</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data1 as $row) {
            $idQuizz = $row["id_quizz"];
            $query2 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_quizz = :idQuizz");
            $query2->bindParam(":idQuizz", $idQuizz);
            $query2->execute();
            $data2 = $query2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data2 as $row2) {
                $nameQuizz = $row2["titre_quizz"];
            }
            $score = $row["score"];

            echo "<tr>";
            echo "<td>$nameQuizz</td>";
            echo "<td>$score</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
