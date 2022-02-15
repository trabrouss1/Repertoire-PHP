<?php
    session_start();
    require 'connect.inc.php';
    if (isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    else{
        $_SESSION['message'] = "Desole vous n'est pas connecté !";
        header("Location:index.php");
    }
    $suprimerPersonne = $bdd->prepare("SELECT * FROM personne WHERE id = :personneId AND created_by = :userId");
    $suprimerPersonne->execute(['personneId' => $_GET['id'], "userId" => $user['id']]);
    $personne = $suprimerPersonne->fetch();
    if (isset($_POST['Supprimer'])){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $deleted_by = $user['id'];
        $deleted_at = date('Y-m-d H:i:s');
        $is_deleted = true;
        $supprimerPersonne= $bdd->prepare("UPDATE personne SET is_deleted = ?, deleted_at = ?, deleted_by = ? WHERE id = ?");
        // $insertpersonne = $bdd->prepare("UPDATE personne SET nom = :nom, prenom = , sexe, updated_by, updated_at) VALUES(?,?,?,?,?,?)");
        $status = $supprimerPersonne->execute(array($is_deleted, $deleted_at, $deleted_by, $_GET['id']));
        if($status == true){
            $_SESSION["message"] = "Suppression de <strong>".$nom." ".$prenom."</strong> réussie";
            $_SESSION["type_message"] = "success";
        }
        else{
            $_SESSION["message"] = "Une erreur s'est produite lors de la suppression de ".$nom." ".$prenom;
            $_SESSION["type_message"] = "danger";
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
    <title>supprimerPersonne</title>
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
    <h1 style="text-align : center;">Suppression  de <?= $personne['nom'], ' '.$personne['prenom'];?> </h1>
    <form action="" method="POST">
        <div class="row m-5">
            <div class="col-md-4">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value=" <?= $personne['nom'];?>" placeholder="Votre Nom" required="required" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom" name="prenom"  value="<?= $personne['prenom'];?>" placeholder="Votre Prénom" required="required" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="sexe">Sexe:</label>
                <select name="sexe" id="sexe" class="form-control">
                    <option value="0"> Selectionner un èlèment</option>
                    <option value="1" <?php if ($personne['sexe'] == 1) :?> selected <?php endif;?>>Homme</option>
                    <option value="2" <?php if ($personne['sexe'] == 2):?> selected <?php endif;?>>Femme</option>
                </select>
            </div>
        </div>
        <div class="row">
            <input class="btn btn-primary" type="submit"  name="Supprimer" value="Supprimer">
        </div>   
        <!-- <div class="row mt-2 mb-5"> 
            <input class="btn btn-info mb-5 " type="reset" value="Réinitialiser">
        </div> -->
    </form>
</div>

<?php
include("footer.php");
?>

<script src="jquery/jquery3.5.1.js"></script>  

</body>
</html>