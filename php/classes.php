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

//Classe qui permet de gérer les Quizz
class Quizz extends ConnectionDB
{
    public $date;
    public $idQuizz;
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
}

//Classe qui permet de gérer les Questions
class Question extends ConnectionDB
{
    public $idQuestion;
    public function addQuestion($intituleQuestion, $difficulteQuestion)
    {
        $dateQuestion = date("Y-m-d");
        $query5 = $this->bdd->prepare("INSERT INTO question(intitule_question, difficulte_question, date_creation_question) VALUES (:intituleQuestion, :difficulteQuestion, :dateQuestion)");
        $query5->bindParam(":intituleQuestion", $intituleQuestion);
        $query5->bindParam(":difficulteQuestion", $difficulteQuestion);
        $query5->bindParam(":dateQuestion", $dateQuestion);
        $query5->execute();
    }

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

    public function addQuizzQuestion($idQuizz, $idQuestion)
    {
        $query7 = $this->bdd->prepare("INSERT INTO quizz_question(id_quizz, id_question) VALUES (:idQuizz, :idQuestion)");
        $query7->bindParam(":idQuizz", $idQuizz);
        $query7->bindParam(":idQuestion", $idQuestion);
        $query7->execute();
    }
}

//Classe qui permet de gérer les Choix
class Choix extends ConnectionDB
{
    public $idChoix;
    public function addChoice($reponseChoix, $bonneReponse, $idQuestion)
    {
        $query8 = $this->bdd->prepare("INSERT INTO choix(reponse_choix, bonneReponse_choix, id_question) VALUES (:reponseChoix, :bonneReponse, :idQuestion)");
        $query8->bindParam(":reponseChoix", $reponseChoix);
        $query8->bindParam(":bonneReponse", $bonneReponse);
        $query8->bindParam(":idQuestion", $idQuestion);
        $query8->execute();
    }
}

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

        //Boucle qui permet l'affichage de chaque utilisateur
        foreach ($data3 as $row) {
            if ($row["role_utilisateur"] != 0) {
                $idUser = $row["id_utilisateur"];
                $pseudoUser = $row["pseudo_utilisateur"];
                echo "ID : " . $idUser . " | ";
                echo "Pseudo : " . $pseudoUser . " | ";
                echo "Email : " . $row["email_utilisateur"] . " | <a href='editMember.php?id=$idUser&pseudo=$pseudoUser'>Modifier</a> | <a href='deleteMember.php?id=$idUser'>Supprimer</a>";
                echo "<br>";
            }
        }
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
            $banUser = $this->bdd->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :idUser");
            $banUser->bindParam(":idUser", $idUser);
            $banUser->execute();

            header("Location: adminPage.php");
        } else {
            //Utilisateur inexistant
            echo "Utilisateur inexistant";
        }
    }

    //Fonction qui permet de modifier le mot de passe d'un utilisateur
    public function editPassword($currentPass, $newPass, $confirmPass, $idUser)
    {
        //Vérification de l'existence des données saisies
        if (isset($currentPass) && isset($newPass) && isset($confirmPass)) {
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
}
