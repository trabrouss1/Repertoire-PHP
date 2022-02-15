<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'connect.inc.php';
if (isset($_POST["valide"])){
    $password = $_POST["password"];
    $Cpassword = $_POST["Cpassword"];
    $longueur_password = strlen($password);
    $message = null;
    $erreur = false;
    $droit = "visiteur";
    // $is_deleted = 0;
    $etat = true;
    $password = md5($password);
    $Cpassword = md5($Cpassword);

    if (!empty($_POST["nom"])) {
        $nom = $_POST["nom"];
    } else {
        $message = "Le nom ne doit pas etre vide !";
        $erreur = true;
    }
    if (!empty($_POST["prenom"])) {
        $prenom = $_POST["prenom"];
    } else {
        $message = "Le prenom ne doit pas etre vide !";
        $erreur = true;
    }
    if (!empty($_POST["sexe"])) {
        $sexe = $_POST["sexe"];
    } else {
        $message = "Le sexe ne doit pas etre vide !";
        $erreur = true;
    }
    if (!empty($_POST["username"])) {
        $username = $_POST["username"];
    } else {
        $message = "Le username ne doit pas etre vide !";
        $erreur = true;
    }
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
    } else {
        $message = "L'email ne doit pas etre vide !";
        $erreur = true;
    }

    if ($longueur_password  < 8) {
        $message = " Erreur de saisir veillez entrer un mot de passe de plus de 8 chiffres";
        $erreur = true;
    }
    if (md5($password) !=  md5($Cpassword)) {
        $message = "Mots de passe différents";
        $erreur = true;
        return null;
    }

    if ($erreur == false) {
        $created_at = date('d-m-Y H:i:s');
        $is_deleted = false;
        $insertuser = $bdd->prepare("INSERT INTO user (nom, prenom, sexe, email, username, `password`, droit, etat, created_at, is_deleted) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $insertuser->execute(array($nom, $prenom, $sexe, $email, $username, $password, $droit, $etat, $created_at, $is_deleted));
        $_SESSION['message'] = "inscription reussir!";
        header('Location:connexion.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Page d'inscription</title>
</head>

<body>
    <h1 style="text-align: center;
        padding-top: 10px;
        color: blue;
        margin-left: 30%;
        width: 470px;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;">Formulaire d'inscription<span class="orange">.</span>
    </h1>
    <?php
    include("menu.php");
    ?>

    <div class="container">

        <?php
        if (isset($message) && $message != null) {
            echo '<div class="alert alert-danger">' . $message . '</div>';
        }
        ?>
        <form action="" method="POST">
            <div class="mt-3">
                <div class="row pt-5">
                    <div class="col-md-4">
                        <label for="nom">Nom:</label>
                        <input type="text"
                            value="<?php if (isset($_POST["nom"])) echo (htmlspecialchars($_POST['nom'])) ?>" id="nom"
                            name="nom" placeholder="Votre Nom" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="prenom">Prenom:</label>
                        <input type="text" id="prenom"
                            value="<?php if (isset($_POST["prenom"])) echo (htmlspecialchars($_POST['prenom'])) ?>"
                            name=" prenom" placeholder="Votre Prenom" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="sexe">Sexe:</label>
                        <select name="sexe" id="sexe" class="form-control">
                            <option value="0"> Selectionner votre sexe</option>
                            <option value="1">Homme</option>
                            <option value="2">Femme</option>
                        </select>
                    </div>
                </div>
                <div class="row pt-4 ">
                    <div class="col-md-6">
                        <label for="username">Username:</label>
                        <input type="text" id="username"
                            value="<?php if (isset($_POST["username"])) echo (htmlspecialchars($_POST['username'])) ?>"
                            name="username" placeholder="Votre Nom d'utilisateur" required class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" id="email"
                            value="<?php if (isset($_POST["email"])) echo (htmlspecialchars($_POST['email'])) ?>"
                            name="email" placeholder="Votre Email" required class="form-control">
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-5">
                        <label for="password">Mot de passe:</label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required
                            class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label for="Cpassword">Confirmer le mot de passe:</label>
                        <input type="password" id="Cpassword" name="Cpassword"
                            placeholder="confirmer votre mot de passe" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-5 mb-5">
                        <input class="btn btn-primary" style="text-align: center;" type="submit" name="valide"
                            value="Envoyer">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
    include("footer.php");
    ?>

</body>

</html>
