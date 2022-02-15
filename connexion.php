<?php 
    session_start();
    require 'connect.inc.php';
    $message = $_SESSION['message'];
    if(isset($_POST["connexion"])){
        $password = $_POST["password"];
        // $password = md5($password);
        $username = $_POST["username"];
        $insertuser = $bdd->prepare("SELECT * FROM  user WHERE username = :username AND password = :password");
        $insertuser->execute(array("username" => $username, "password" => $password));
        $user = $insertuser->fetch();
        if (!empty($user)){
            $_SESSION['user'] = $user;
            header('Location:index.php');
        }
        else{
            $message = "Username ou mot de passe incorrect";
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
    <title>Page de Connexion</title>
</head>
<body>
    <h1 style="text-align: center;
        padding-top: 10px;
        color: blue;
        margin-left: 30%;
        width: 470px;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;">Formulaire de connexion<span class="orange">.</span>
    </h1>
    <?php include("menu.php");?>
    
    <div class="container">
        <?php 
            if (isset($message) && $message != null){
                echo '<div class="alert alert-danger">'.$message.'</div>'; 
                $_SESSION['message'] = null;        
            }
        ?>
        <form action="" method="POST">
            <div class="row mt-5">
                <div class="col-md-6">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Votre Nom d'utilisateur" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" placeholder="Votre mot de passe" required class="form-control">
                </div>
            </div>
            <div class="row mt-5">
                <a href="#">Mot de passe oublié ?</a>
                <a href="inscription.php">S'inscrire</a>       
            </div>
            <div class="row">
                <div class="col-md-6 mt-4 mb-5">
                    <input class="btn btn-primary" style="text-align: center;" type="submit" name="connexion" value="Connexion">
                </div>
            </div>
        </form>
    </div>
<?php
    include("footer.php");
?>
</body>
</html>