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
    $selectPersonne = $bdd->prepare("SELECT c.*, p.nom, p.prenom FROM contact c JOIN personne p ON c.personne_id = p.id WHERE c.id = :contactId AND c.created_by = :userId ");
    $selectPersonne->execute(['contactId' => $_GET['id'], "userId" => $user['id']]);
    $personne = $selectPersonne->fetch();
    // var_dump($personne);
    // die();
    if (isset($_POST['contact']) && isset($_POST['type_contact_id'])){
        $nom = $personne['nom'];
        $prenom = $personne['prenom'];
        $contact = $_POST['contact'];
        $type_contact_id = $_POST['type_contact_id'];
        $created_by = $user['id'];
        $created_at = date('Y-m-d H:i:s');
        $is_deleted = 0;   
        $ajoutcontact = $bdd->prepare("INSERT INTO contact (contact, type_contact_id, created_by, created_at, is_deleted, personne_id) VALUES(?,?,?,?,?,?)");
        $status_ajout = $ajoutcontact->execute(array($contact, $type_contact_id, $created_by, $created_at, $is_deleted, $_GET['id']));
        if($status_ajout == true){
            $_SESSION["message"] = "Ajout de contact de <strong>".$nom." ".$prenom."</strong> réussie";
            $_SESSION["type_message"] = "success";
        }
        else{ 
            $_SESSION["message"] = "Une erreur s'est produite lors de l'ajout de contact de ".$nom." ".$prenom;
            $_SESSION["type_message"] = "danger";
        }
        header("Location:index.php");
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
    <title>Ajout de contact</title>
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
    <h1 style="text-align : center;">Modification du contact <strong style="color: blue;"> <?= $personne['nom'].' '.$personne['prenom'];?> </strong></h1>
    <form action="" method="POST">
        <div class="row m-5">
            <div class="col-md-6">
                <?php 
                    $selectTypeContact = $bdd->prepare("SELECT * FROM type_contact WHERE is_deleted = :is_deleted");
                    $selectTypeContact->execute(array('is_deleted' => false));
                    $types = $selectTypeContact->fetchAll();                       
                ?>
                <label for="typecontact">Type de contacts:</label>
                <select name="type_contact_id" id="typecontact" class="form-control">
                    <option value="">Selectionner le type de contacts</option>
                    <?php  foreach( $types as $type): ?>
                    <option value="<?= $type['id']; ?>" <?php if ($type['id'] == $personne['type_contact_id']):?> selected <?php endif;?>><?= $type['libelle']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                 <label for="contact">Contacts:</label>
                <input type="text" id="contact" name="contact" value="<?= $personne['contact'];?>"  placeholder="Ajouter un contact" required class="form-control">
            </div>
        </div>
        <div class="row">
            <input class="btn btn-primary" type="submit" value="Ajouter">
        </div>   
    </form>
</div>

<script src="jquery/jquery3.5.1.js"></script>  

</body>
</html>