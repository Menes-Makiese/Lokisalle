<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

$pdo = new PDO('mysql:host=localhost;dbname=lokisalle', 'root', '');

$message ="";
$inscrit ="";


if (!empty($_POST)) {

  $pseudo = $_POST['pseudo'];
  $mdp = md5($_POST['mdp']);
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $civilite = $_POST['civilite'];
  //$statut = $_POST['statut'];


  $verifactionMembre = $pdo->query("SELECT * FROM membre WHERE pseudo = '$pseudo' OR email = '$email'");
 



  if ($verifactionMembre->rowCount() >= 1) {
    $message = "Ce membre existe deja <br>";
  } else {
    $resultat =  $pdo->exec("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement) 
 VALUES('$pseudo','$mdp','$nom','$prenom','$email','$civilite', 'membre', NOW() )");
if ($resultat == 1) {
      $inscrit = "<span style='background-color:green; color:white'>membre ajouté avec succès</span>";
    } else {
      $inscrit = "<span style='background-color:red; color:white'>échec sur l'insertion</span>";
    }
    echo "<script> window.location.href='connexion.php';</script>";
  
}
}


?>

<form class="form-signin w-25 mx-auto mt-4 border p-4 rounded h-full m-0" action="#" method="POST">
      <div class="text-center mb-4">
        <img class="mb-4" src="./inc/img/bd3f8963e5364dd4a35cd288498acc46-free.png" alt="" width="72" height="72">
        <h2>Inscrivez-Vous</h2>
        <?php
        // Affichage du message d'inscription si nécessaire
        echo $message;
        echo $inscrit;
      ?>  
      </div>

      <div class="form-label-group">
        <label for="inputPseudo">Pseudo</label>
        <input type="text" id="inputPseudo" name ="pseudo" class="form-control" placeholder="Choisir un pseudo" required autofocus autocomplete="username"><br>
      </div>

      <div class="form-label-group"> 
        <label for="inputPassword">Mot de Passe</label>
        <input type="password" id="inputPassword" name="mdp" class="form-control" placeholder="Choisir un mot de passe" required autocomplete="new-password"><br>
      </div>

      <div class="form-label-group"> 
        <label for="inputName">Nom</label>
        <input type="text" id="inputName" name="nom" class="form-control" placeholder="Votre nom" required autocomplete="family-name"><br>
      </div>

      <div class="form-label-group"> 
        <label for="inputPrenom">Prenom</label>
        <input type="text" id="inputPrenom" name="prenom" class="form-control" placeholder="Votre prenom" required autocomplete="given-name"><br>
      </div>

      <div class="form-label-group"> 
        <label for="inputEmail">Adresse Email</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Votre adresse email" required autocomplete="email"><br>
      </div>
      <div class="form-label-group"> 
        <label for="civilite">Civilite</label>
      <select name="civilite" class="form-control" id="civilite">
    <option value="m">Homme</option>
    <option value="f">Femme</option>
  </select><br>
      </div>

      <div class="d-flex justify-content-between align-items-center">
      <input class="btn btn-lg btn-primary" type="submit" value="Valider l'inscription">
    </div>
      <p class="mt-5 text-muted text-center">&copy; 2023-2024</p>
    </form>




<!-- <form action="#" method="post">
  <p>INSCRIPTION</p>
  <input type="text" name="pseudo" placeholder="Choisir un pseudo" /><br><br>
  <input type="password" name="mdp" placeholder="Choisir un mdp" /><br><br>
  <input type="text" name="nom" placeholder="Votre nom" /><br><br>
  <input type="text" name="prenom" placeholder="Votre prenom" /><br><br>
  <input type="email" name="email" placeholder="Votre email" /><br><br>
  <select name="civilite">
    <option value="m">Homme</option>
    <option value="f">Femme</option>
  </select><br><br>
  <input type="number" name="statut" placeholder="Votre statut" /><br><br>
  <input type="submit" value="Envoyer le formulaire" /><br><br>

</form> -->

<?php

include("inc/footer.inc.php");
