<?php
session_start();

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

class Register extends ConnectionDB
{
    public function registration($pseudo, $email, $password, $confirmpassword, $role)
    {
        $query1 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE pseudo_utilisateur = :pseudo OR email_utilisateur = :email");
        $query1->bindParam(":pseudo", $pseudo);
        $query1->bindParam(":email", $email);
        $query1->execute();

        if ($query1->rowCount() > 0) {
            return 10;
        } else {
            if ($password == $confirmpassword) {
                $insertUser = $this->bdd->prepare("INSERT INTO utilisateur WHERE pseudo_utilisateur = :pseudo AND email_utilisateur = :email AND mdp_utilisateur = :mdp AND role_utilisateur = :roles");
                $insertUser->bindParam(":pseudo", $pseudo);
                $insertUser->bindParam(":email", $email);
                $insertUser->bindParam(":mdp", $password);
                $insertUser->bindParam(":roles", $role);
                return 1;
            } else {
                return 100;
            }
        }
    }
}

class Login extends ConnectionDB
{
    public $id;
    public $role;
    public function login($email, $password)
    {
        $query2 = $this->bdd->prepare("SELECT * FROM utilisateur WHERE email_utilisateur = :email");
        $query2->bindParam(":email", $email);
        $query2->execute();
        $row = $query2->fetch(PDO::FETCH_ASSOC);

        if (count($row) > 0) {
            if ($password == $row["mdp_utilisateur"]) {
                $this->id = $row["id_utilisateur"];
                $this->role = $row["role_utilisateur"];
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function idUser()
    {
        return $this->id;
    }

    public function roleUser()
    {
        return $this->role;
    }
}
