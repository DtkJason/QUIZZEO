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
                    $insertUser = $this->bdd->prepare("INSERT INTO utilisateur(pseudo_utilisateur, email_utilisateur, mdp_utilisateur, role_utilisateur) VALUES (:pseudo, :email, :mdp, :roles)");
                    $insertUser->bindParam(":pseudo", $pseudo);
                    $insertUser->bindParam(":email", $email);
                    $insertUser->bindParam(":mdp", $password);
                    $insertUser->bindParam(":roles", $role);
                    $insertUser->execute();

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
        $query2 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE email_utilisateur = :email");
        $query2->bindParam(":email", $email);
        $query2->execute();
        $row = $query2->fetch(PDO::FETCH_ASSOC);

        //Email existant
        if ($row == true) {
            if ($password == $row["mdp_utilisateur"]) {
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
        $query3 = $this->bdd->prepare("INSERT INTO quizz(titre_quizz, difficulte_quizz, date_creation_quizz, id_utilisateur) VALUES (:titleQuizz, :difficulteQuizz, :dateQuizz, :idUserQuizz)");
        $query3->bindParam(":titleQuizz", $titleQuizz);
        $query3->bindParam(":difficulteQuizz", $difficulteQuizz);
        $query3->bindParam("dateQuizz", $dateQuizz);
        $query3->bindParam(":idUserQuizz", $idUserQuizz);
        $query3->execute();
    }

    //Fonction qui permet de récupérer l'ID d'un Quizz
    public function getIdQuizz($titleQuizz, $difficulteQuizz, $idUserQuizz)
    {
        $query4 = $this->bdd->prepare("SELECT * FROM quizz WHERE titre_quizz = :titleQuizz AND difficulte_quizz = :difficulteQuizz AND id_utilisateur = :idUserQuizz");
        $query4->bindParam(":titleQuizz", $titleQuizz);
        $query4->bindParam(":difficulteQuizz", $difficulteQuizz);
        $query4->bindParam(":idUserQuizz", $idUserQuizz);
        $query4->execute();

        $data1 = $query4->fetch(PDO::FETCH_ASSOC);

        $this->idQuizz = $data1["id_quizz"];
        return $this->idQuizz;
    }

    //Fonction qui permet d'afficher la liste des Quizz
    public function displayAllQuizz()
    {
        $query13 = $this->bdd->prepare("SELECT * FROM quizz");
        $query13->execute();
        $data4 = $query13->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom du Quizz</td>";
        echo "<td>Difficulté Quizz</td>";
        echo "<td>Date de création</td>";
        echo "<td>Créateur</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data4 as $row) {
            $idUserQuizz = $row["id_utilisateur"];
            $query14 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
            $query14->bindParam(":idUser", $idUserQuizz);
            $query14->execute();
            $data5 = $query14->fetch(PDO::FETCH_ASSOC);

            $userPseudo = $data5["pseudo_utilisateur"];

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
            echo "<td><a href='.php'>Jouer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    //Fonction qui permet d'afficher la liste des Quizz en fonction du Quizzer
    public function displayPersonnalQuizz($idUserQuizz)
    {
        $query15 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_utilisateur = :idUser");
        $query15->bindParam(":idUser", $idUserQuizz);
        $query15->execute();
        $data6 = $query15->fetchAll(PDO::FETCH_ASSOC);

        $query30 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query30->bindParam(":idQuizz", $idQuizz);
        $query30->execute();
        $data18 = $query30->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom du Quizz</td>";
        echo "<td>Difficulté Quizz</td>";
        echo "<td>Date de création</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data6 as $row) {
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
            echo "<td><a href='.php'>Jouer</a></td>";
            echo "<td><a href='modifQuizzQuizzer.php?idQuizz=$idQuizz&idUser=$idUserQuizz'>Modifier</a></td>";
            echo "<td><a href='deleteQuizz.php?idQuizz=$idQuizz'>Supprimer</a></td>";
            echo "</tr>";
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
        $query5 = $this->bdd->prepare("INSERT INTO question(intitule_question, difficulte_question, date_creation_question) VALUES (:intituleQuestion, :difficulteQuestion, :dateQuestion)");
        $query5->bindParam(":intituleQuestion", $intituleQuestion);
        $query5->bindParam(":difficulteQuestion", $difficulteQuestion);
        $query5->bindParam(":dateQuestion", $dateQuestion);
        $query5->execute();
    }

    //Fonction qui permet de récupérer l'ID d'une Question
    public function getIdQuestion($intituleQuestion, $difficulteQuestion)
    {
        $query6 = $this->bdd->prepare("SELECT * FROM question WHERE intitule_question = :intituleQuestion AND difficulte_question = :difficulteQuestion");
        $query6->bindParam(":intituleQuestion", $intituleQuestion);
        $query6->bindParam(":difficulteQuestion", $difficulteQuestion);
        $query6->execute();

        $data2 = $query6->fetch(PDO::FETCH_ASSOC);

        $this->idQuestion = $data2["id_question"];
        return $this->idQuestion;
    }

    //Fonction qui permet d'associer un Quizz à une Question dans la base de données
    public function addQuizzQuestion($idQuizz, $idQuestion)
    {
        $query7 = $this->bdd->prepare("INSERT INTO quizz_question(id_quizz, id_question) VALUES (:idQuizz, :idQuestion)");
        $query7->bindParam(":idQuizz", $idQuizz);
        $query7->bindParam(":idQuestion", $idQuestion);
        $query7->execute();
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
        $query8 = $this->bdd->prepare("INSERT INTO choix(reponse_choix, bonneReponse_choix, id_question) VALUES (:reponseChoix, :bonneReponse, :idQuestion)");
        $query8->bindParam(":reponseChoix", $reponseChoix);
        $query8->bindParam(":bonneReponse", $bonneReponse);
        $query8->bindParam(":idQuestion", $idQuestion);
        $query8->execute();
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
        $query9 = $this->bdd->prepare("SELECT * FROM utilisateur");
        $query9->execute();

        //Stockage des informations récupérées dans un tableau associatif
        $data3 = $query9->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>ID</td>";
        echo "<td>Pseudo</td>";
        echo "<td>Email</td>";
        echo "<td>Mot de passe</td>";
        echo "<td>Type de compte</td>";
        echo "</tr>";
        echo "</thead>";

        //Boucle qui permet l'affichage de chaque utilisateur
        foreach ($data3 as $row) {
            if ($row["role_utilisateur"] != 0) {
                $idUser = $row["id_utilisateur"];
                $pseudoUser = $row["pseudo_utilisateur"];

                echo "<tr>";
                echo "<td>" . $idUser . "</td>";
                echo "<td>" . $pseudoUser . "</td>";
                echo "<td>" . $row["email_utilisateur"] . "</td>";
                echo "<td>" . $row["mdp_utilisateur"] . "</td>";
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
            $modifyIdUserQuizz = $this->bdd->prepare("UPDATE quizz SET id_utilisateur = :newId WHERE id_utilisateur = :idUser");
            $modifyIdUserQuizz->bindParam(":newId", $newId);
            $modifyIdUserQuizz->bindParam(":idUser", $idUser);
            $modifyIdUserQuizz->execute();
        } else {
            echo "Erreur ID";
        }
    }

    //Fonction qui permet la suppression d'un membre
    public function deleteMember($idUser)
    {
        //Requête qui permet de vérifier si l'utilisateur choisi existe dans la base de données
        $recupUser = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
        $recupUser->bindParam(":idUser", $idUser);
        $recupUser->execute();

        //Si l'utilisateur existe
        if ($recupUser->rowCount() > 0) {
            //Requête qui permet de supprimer l'utilisateur choisi
            $deleteUser = $this->bdd->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :idUser");
            $deleteUser->bindParam(":idUser", $idUser);
            $deleteUser->execute();

            header("Location: adminPage.php");
        } else {
            //Utilisateur inexistant
            echo "Utilisateur inexistant";
        }
    }

    public function getUserPseudo($idUser)
    {
        $query = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
        $query->bindParam(":idUser", $idUser);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);

        $pseudoUser = $data["pseudo_utilisateur"];
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
                $query10 = $this->bdd->prepare("UPDATE utilisateur SET mdp_utilisateur = :newpassword WHERE id_utilisateur = $idUser");
                $query10->bindParam(":newpassword", $newPass);
                $query10->execute();
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
            $query11 = $this->bdd->prepare("UPDATE utilisateur SET pseudo_utilisateur = :newpseudo WHERE id_utilisateur = $idUser");
            $query11->bindParam(":newpseudo", $newpseudo);
            $query11->execute();
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
            $query12 = $this->bdd->prepare("UPDATE utilisateur SET email_utilisateur = :newemail WHERE id_utilisateur = $idUser");
            $query12->bindParam(":newemail", $newemail);
            $query12->execute();
            echo '<script type="text/javascript">';
            echo 'alert("Email modifié")';
            echo '</script>';
        } else {
            //Absence de saisie de donnée
            echo "Veuillez compléter tous les champs !";
        }
    }

    public function listQuizzAdmin()
    {
        $query16 = $this->bdd->prepare("SELECT * FROM quizz");
        $query16->execute();
        $data7 = $query16->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Nom du Quizz</td>";
        echo "<td>Difficulté Quizz</td>";
        echo "<td>Date de création</td>";
        echo "<td>Créateur</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data7 as $row) {
            $idUserQuizz = $row["id_utilisateur"];
            $query17 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :idUser");
            $query17->bindParam(":idUser", $idUserQuizz);
            $query17->execute();
            $data8 = $query17->fetch(PDO::FETCH_ASSOC);

            $userPseudo = $data8["pseudo_utilisateur"];

            $query18 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_utilisateur = :idUser AND titre_quizz = :titreQuizz");
            $query18->bindParam(":idUser", $idUserQuizz);
            $query18->bindParam(":titreQuizz", $row["titre_quizz"]);
            $query18->execute();
            $data9 = $query18->fetch(PDO::FETCH_ASSOC);

            $idQuizz = $data9["id_quizz"];

            $query30 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
            $query30->bindParam(":idQuizz", $idQuizz);
            $query30->execute();
            $data18 = $query30->fetchAll(PDO::FETCH_ASSOC);

            $nbrQuestion = count($data18);

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
            echo "<td><a href='.php'>Jouer</a></td>";
            echo "<td><a href='modifQuizz.php?idQuizz=$idQuizz&nbrQuestion=$nbrQuestion'>Modifier</a></td>";
            echo "<td><a href='deleteQuizz.php?idQuizz=$idQuizz'>Supprimer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function editQuizzForm($idQuizz)
    {
        $query19 = $this->bdd->prepare("SELECT * FROM quizz WHERE id_quizz = :idQuizz");
        $query19->bindParam("idQuizz", $idQuizz);
        $query19->execute();
        $data10 = $query19->fetch(PDO::FETCH_ASSOC);

        $titreQuizz = $data10["titre_quizz"];

        if ($data10["difficulte_quizz"] == 1) {
            $diffQuizz = "Facile";
        } elseif ($data10["difficulte_quizz"] == 2) {
            $diffQuizz = "Intermédiaire";
        } else {
            $diffQuizz = "Difficile";
        }

        $query20 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query20->bindParam("idQuizz", $idQuizz);
        $query20->execute();
        $data11 = $query20->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Modifier Quizz</h1>";
        echo "<form method='POST'>";
        echo "<label>Modifier Nom Quizz ($titreQuizz) : </label><br>";
        echo "<input type='text' name='nomQuizz'><br><br>";
        echo "<label>Modifier Difficulté Quizz ($diffQuizz) : </label><br>";
        echo "<select name='diffQuizz'>";
        echo "<option value=''></option>";
        echo "<option value='1'>Facile</option>";
        echo "<option value='2'>Intermédiaire</option>";
        echo "<option value='3'>Difficile</option>";
        echo "</select><br><br><br>";

        $i = 1;

        foreach ($data11 as $row) {
            $idQuestion = $row["id_question"];
            $query21 = $this->bdd->prepare("SELECT * FROM question WHERE id_question = :idQuestion");
            $query21->bindParam(":idQuestion", $idQuestion);
            $query21->execute();
            $data12 = $query21->fetch(PDO::FETCH_ASSOC);

            $intituleQuestion = $data12['intitule_question'];
            $idQuestion = $data12["id_question"];

            if ($data12["difficulte_question"] == 1) {
                $diffQuestion = "Facile";
            } elseif ($data12["difficulte_question"] == 2) {
                $diffQuestion = "Intermédiaire";
            } else {
                $diffQuestion = "Difficile";
            }

            echo "<label>Modifier Question $i ($intituleQuestion) : </label><br>";
            echo "<input type='text' name='question$i'><br><br>";

            echo "<label>Modifier Difficulté Question $i ($diffQuestion) : </label><br>";
            echo "<select name='diffQuestion$i'>";
            echo "<option value=''></option>";
            echo "<option value='1'>Facile</option>";
            echo "<option value='2'>Intermédiaire</option>";
            echo "<option value='3'>Difficile</option>";
            echo "</select><br><br>";

            $bool = true;

            $query22 = $this->bdd->prepare("SELECT * FROM choix WHERE id_question = :idQuestion AND bonneReponse_choix = :goodAnswer");
            $query22->bindParam(":idQuestion", $idQuestion);
            $query22->bindParam(":goodAnswer", $bool);
            $query22->execute();
            $data13 = $query22->fetch(PDO::FETCH_ASSOC);

            $goodAnswer = $data13["reponse_choix"];
            $goodAnswerId = $data13["id_choix"];

            $badAnswerId1 = $goodAnswerId + 1;
            $badAnswerId2 = $goodAnswerId + 2;
            $badAnswerId3 = $goodAnswerId + 3;

            $query23 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query23->bindParam(":idChoix", $badAnswerId1);
            $query23->execute();
            $data14 = $query23->fetch(PDO::FETCH_ASSOC);

            $query24 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query24->bindParam(":idChoix", $badAnswerId2);
            $query24->execute();
            $data15 = $query24->fetch(PDO::FETCH_ASSOC);

            $query25 = $this->bdd->prepare("SELECT * FROM choix WHERE id_choix = :idChoix");
            $query25->bindParam(":idChoix", $badAnswerId3);
            $query25->execute();
            $data16 = $query25->fetch(PDO::FETCH_ASSOC);

            $badAnswer1 = $data14["reponse_choix"];
            $badAnswer2 = $data15["reponse_choix"];
            $badAnswer3 = $data16["reponse_choix"];

            echo "<label>Modifier Bonne Réponse $i ($goodAnswer) : </label><br>";
            echo "<input type='text' name='bonnereponse$i'><br><br>";


            echo "<label>Modifier Mauvaise Réponse $i-1 ($badAnswer1) : </label><br>";
            echo "<input type='text' name='mauvaisereponse$i-1'><br><br>";


            echo "<label>Modifier Mauvaise Réponse $i-2 ($badAnswer2) : </label><br>";
            echo "<input type='text' name='mauvaisereponse$i-2'><br><br>";

            echo "<label>Modifier Mauvaise Réponse $i-3 ($badAnswer3) : </label><br>";
            echo "<input type='text' name='mauvaisereponse$i-3'><br><br><br>";
            $i++;
        }

        echo "<input type='submit' name='submit'>";
        echo "</form>";
    }

    public function editQuizzName($idQuizz, $newTitreQuizz)
    {
        $query26 = $this->bdd->prepare("UPDATE quizz SET titre_quizz = :newTitle WHERE id_quizz = :idQuizz");
        $query26->bindParam(":newTitle", $newTitreQuizz);
        $query26->bindParam(":idQuizz", $idQuizz);
        $query26->execute();
    }

    public function editQuizzDiff($idQuizz, $newDiffQuizz)
    {
        $query27 = $this->bdd->prepare("UPDATE quizz SET difficulte_quizz = :newDiffQuizz WHERE id_quizz = :idQuizz");
        $query27->bindParam(":newDiffQuizz", $newDiffQuizz);
        $query27->bindParam(":idQuizz", $idQuizz);
        $query27->execute();
    }

    public function editQuestionName($idQuizz, $newQuestionName, $a)
    {
        $query28 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query28->bindParam(":idQuizz", $idQuizz);
        $query28->execute();
        $data17 = $query28->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data17[$position]["id_question"];

        $query29 = $this->bdd->prepare("UPDATE question SET intitule_question = :newQuestionName WHERE id_question = :idQuestion");
        $query29->bindParam(":newQuestionName", $newQuestionName);
        $query29->bindParam(":idQuestion", $idQuestion);
        $query29->execute();
    }

    public function editQuestionDiff($idQuizz, $newQuestionDiff, $a)
    {
        $query31 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query31->bindParam(":idQuizz", $idQuizz);
        $query31->execute();
        $data18 = $query31->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data18[$position]["id_question"];

        $query32 = $this->bdd->prepare("UPDATE question SET difficulte_question = :newQuestionDiff WHERE id_question = :idQuestion");
        $query32->bindParam(":newQuestionDiff", $newQuestionDiff);
        $query32->bindParam(":idQuestion", $idQuestion);
        $query32->execute();
    }

    public function editGoodAnswer($idQuizz, $newGoodAnswer, $a)
    {
        $query33 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query33->bindParam(":idQuizz", $idQuizz);
        $query33->execute();
        $data19 = $query33->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data19[$position]["id_question"];

        $bool = true;

        $query34 = $this->bdd->prepare("UPDATE choix SET reponse_choix = :newGoodAnswer WHERE bonneReponse_choix = :bool AND id_question = :idQuestion");
        $query34->bindParam(":newGoodAnswer", $newGoodAnswer);
        $query34->bindParam(":bool", $bool);
        $query34->bindParam(":idQuestion", $idQuestion);
        $query34->execute();
    }

    public function editBadAnswer($idQuizz, $newBadAnswer, $a)
    {
        $query35 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query35->bindParam(":idQuizz", $idQuizz);
        $query35->execute();
        $data20 = $query35->fetchAll(PDO::FETCH_ASSOC);

        $position = $a - 1;
        $idQuestion = $data20[$position]["id_question"];
        $bool = false;

        $query36 = $this->bdd->prepare("SELECT * FROM choix WHERE bonneReponse_choix = :bool AND id_question = :idQuestion");
        $query36->bindParam(":bool", $bool);
        $query36->bindParam(":idQuestion", $idQuestion);
        $query36->execute();
        $data21 = $query36->fetchAll(PDO::FETCH_ASSOC);

        $idChoix = $data21[$position]["id_choix"];

        $query37 = $this->bdd->prepare("UPDATE choix SET reponse_choix = :newBadAnswer WHERE id_choix = :idChoix");
        $query37->bindParam(":newBadAnswer", $newBadAnswer);
        $query37->bindParam(":idChoix", $idChoix);
        $query37->execute();
    }

    public function deleteQuizz($idQuizz)
    {
        $query38 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query38->bindParam(":idQuizz", $idQuizz);
        $query38->execute();
        $data22 = $query38->fetchAll(PDO::FETCH_ASSOC);

        $query39 = $this->bdd->prepare("DELETE FROM quizz WHERE id_quizz = :idQuizz");
        $query39->bindParam(":idQuizz", $idQuizz);
        $query39->execute();

        foreach ($data22 as $row) {
            $query40 = $this->bdd->prepare("DELETE FROM question WHERE id_question = :idQuestion");
            $query40->bindParam(":idQuestion", $row["id_question"]);
            $query40->execute();
        }
    }

    public function getNumberQuestion($idQuizz)
    {
        $query30 = $this->bdd->prepare("SELECT * FROM quizz_question WHERE id_quizz = :idQuizz");
        $query30->bindParam(":idQuizz", $idQuizz);
        $query30->execute();
        $data18 = $query30->fetchAll(PDO::FETCH_ASSOC);

        $nbrQuestion = count($data18);
        return $nbrQuestion;
    }
}
