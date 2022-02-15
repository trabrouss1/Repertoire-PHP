<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
session_start();
require 'connect.inc.php';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    $_SESSION['message'] = "Désolé vous n'est pas connecté !";
    header("Location:index.php");
}
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];

    $image = null;

    // Cas de la modification d'une personne en y ajoutant une image
    if (strlen($_FILES['photo']['name']) > 0) {
        $image  = $_FILES['photo']['name'];
        $traget = "images/" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $traget);
    }

    $created_by = $user['id'];
    $created_at = date('Y-m-d H:i:s');
    $is_deleted = false;
    $insertpersonne = $bdd->prepare("INSERT INTO personne (nom, prenom, sexe, `image`, created_by, created_at, is_deleted) VALUES(?,?,?,?,?,?,?)");
    $status = $insertpersonne->execute(array($nom, $prenom, $sexe, $image, $created_by, $created_at, $is_deleted));
    if ($status == true) {
        $_SESSION["message"] = "Enregistrement de <strong>" . $nom . " " . $prenom . "</strong> réussi";
        $_SESSION["type_message"] = "success";
    } else {
        $_SESSION["message"] = "Une erreur s'est produite lors de l'enregistrement de " . $nom . " " . $prenom;
    }
    header('Location:index.php');
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
    <title>Personne</title>
</head>

<body>
    <h1 style="text-align: center;
    padding-top: 10px;
    color: blue;
    margin-left: 30%;
    width: 470px;
    border-bottom: 1px solid #000;
    padding-bottom: 5px;">Mon Super Repertoire<span class="orange">.</span>
    </h1>

    <?php
    include("menu.php");
    ?>

    <div class="container">
        <form action="" method="POST" name="formAdd" class="formulaire" enctype="multipart/form-data">
            <div class="row m-5">
                <div class="col-md-6">
                    <label for="nom">Nom:</label>
                    <input type="text" id="" name="nom" placeholder="Votre Nom" required="required"
                        class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="prenom">Prenom:</label>
                    <input type="text" id="" name="prenom" placeholder="Votre Prénom" required="required"
                        class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="sexe">Sexe:</label>
                    <select name="sexe" id="sexe" class="form-control">
                        <option value="0"> Selectionner un èlèment</option>
                        <option value="1">Homme</option>
                        <option value="2">Femme</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="text">Image:</label>
                    <input type="file" name="photo" class="form-control" placeholder="Choisir une Image">
                </div>
            </div>
            <div class="row mt-3">
                <input class="btn btn-primary" name="addphoto" type="submit" value="Enregister">
            </div>
            <div class="row mt-2 mb-5">
                <input class="btn btn-info mb-5" type="reset" value="Réinitialiser">
            </div>
        </form>
    </div>

    <?php
    include("footer.php");
    ?>

    <script src="jquery/jquery3.5.1.js"></script>

</body>

</html>