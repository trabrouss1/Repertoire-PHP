<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=test_repertoire', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "Erreur lors de la connexion de la base de donnee :" . $e->getMessage(). '<br>';
    die();
}