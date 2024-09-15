<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

if (!empty($_POST)) {
  $pseudo = htmlentities(addslashes($_POST['pseudo']));
  $mdp = md5(htmlentities(addslashes($_POST['mdp'])));
  $nom = htmlentities(addslashes($_POST['nom']));
  $prenom = htmlentities(addslashes($_POST['prenom']));
  $email = htmlentities(addslashes($_POST['email']));
  $civilite = htmlentities(addslashes($_POST['civilite']));
  $statut = htmlentities(addslashes($_POST['statut']));

  // MODIFIER UN MEMBRE
  if (isset($_GET['action']) and $_GET['action'] == 'modifier' and isset($_GET['idMembre'])) {
    $resultat = $pdo->exec("UPDATE membre SET pseudo='$pseudo', mdp='$mdp', nom='$nom', prenom='$prenom', email='$email', civilite='$civilite', statut='$statut', date_enregistrement=NOW() WHERE id_membre='$_GET[idMembre]'");
    if ($resultat == 1) {
      echo "<span style='background-color:green;color:white'>Membre modifié avec succès</span>";
    }
  }
  // AJOUTER UN MEMBRE
  else {
    $resultat = $pdo->exec("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement) VALUES('$pseudo', '$mdp', '$nom', '$prenom', '$email', '$civilite', '$statut', NOW())");
    if ($resultat == 1) {
      echo "<span style='background-color:green;color:white'>Membre ajouté avec succès</span>";
    }
  }
}
//SUPPRIMER UN MEMBRE
if (isset($_GET['supp']) && $_GET['supp'] == 'supprimer' && isset($_GET['idMembre'])) {
  $idMembre = $_GET['idMembre'];
  $resultat = $pdo->exec("DELETE FROM membre WHERE id_membre = '$idMembre'");
  if ($resultat == 1) {
    echo "<span style='background-color:red;color:white'>Membre supprimé avec succès</span>";
  }
}

// AFFICHAGE DE LA TABLE DIRECTEMENT
$membres = $pdo->query("SELECT * FROM membre");
echo "<h3 class='text-center mt-5'>Gestion des membres</h3>";
echo "<table class='table mx-auto w-75 mb-5'>";
echo "<thead><tr><th scope='col'>Pseudo</th><th scope='col'>Mot de Passe</th><th scope='col'>Nom</th><th scope='col'>Prenom</th><th scope='col'>Email</th><th scope='col'>Civilite</th><th scope='col'>Statut</th><th scope='col'>Date d'enregistrement</th><th scope='col'>Actions</th></tr></thead>";

while ($donnees = $membres->fetch(PDO::FETCH_ASSOC)) {
  echo "<tr><td>{$donnees['pseudo']}</td><td>{$donnees['mdp']}</td><td>{$donnees['nom']}</td><td>{$donnees['prenom']}</td><td>{$donnees['email']}</td><td>{$donnees['civilite']}</td><td>{$donnees['statut']}</td><td>{$donnees['date_enregistrement']}</td>";
  echo "<td><a href='?supp=supprimer&idMembre={$donnees['id_membre']}'><img src='./inc/img/effacer.png' width=25 title='Supprimer le membre'/></a> ";
  echo "<a href='?action=modifier&idMembre={$donnees['id_membre']}'><img src='./inc/img/modifier.png' width=18 title='modifier le membre'/></a></td></tr>";
}
echo "</table>";

// AFFICHAGE DU FORMULAIRE D'AJOUT DIRECTEMENT
if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['idMembre'])) {
  // Récupération des informations du membre à modifier
  $resultat = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[idMembre]'");
  $donnees = $resultat->fetch(PDO::FETCH_ASSOC); // On récupère les données du membre à modifier
}

?>
<form action="" method="post" enctype="multipart/form-data">
  <table class="table w-50 mx-auto ">
    <tr>
      <td><label for="pseudo">Pseudo</label></td>
      <td><input type="text" name="pseudo" autocomplete="username" value="<?= $donnees['pseudo'] ?? '' ?>" /></td>
    </tr>
    <tr>
      <td><label for="mdp">Mot de passe</label></td>
      <td><input type="text" name="mdp" autocomplete="password" value="<?= $donnees['mdp'] ?? '' ?>" /></td>
    </tr>
    <tr>
      <td><label for="prenom">Prenom</label></td>
      <td><input type="text" name="prenom" value="<?= $donnees['prenom'] ?? '' ?>" /></td>
    </tr>
    <tr>
      <td><label for="nom">Nom</label></td>
      <td><input type="text" name="nom" value="<?= $donnees['nom'] ?? '' ?>" /></td>
    </tr>
    <tr>
      <td><label for="email">Email</label></td>
      <td><input type="email" name="email" value="<?= $donnees['email'] ?? '' ?>" /></td>
    </tr>
    <tr>
      <td><label for="civilite">Civilité</label></td>
      <td><select name="civilite">
          <option value="m" <?= (isset($donnees['civilite']) && $donnees['civilite'] == 'm') ? 'selected' : '' ?>>Masculin</option>
          <option value="f" <?= (isset($donnees['civilite']) && $donnees['civilite'] == 'f') ? 'selected' : '' ?>>Féminin</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="statut">Statut</label></td>
      <td><select name="statut">
          <option value="admin" <?= (isset($donnees['statut']) && $donnees['statut'] == 'admin') ? 'selected' : '' ?>>Admin</option>
          <option value="membre" <?= (isset($donnees['statut']) && $donnees['statut'] == 'membre') ? 'selected' : '' ?>>Membre</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><input type="submit" class="btn btn-outline-success" value="<?= isset($_GET['action']) && $_GET['action'] == 'modifier' ? 'Modifier le membre' : 'Ajouter un membre' ?>" />
        <?php if (isset($_GET['action']) && $_GET['action'] == 'modifier'): ?>
      <td>
        <a href="gestion_membre.php" class="btn btn-outline-danger">Annuler</a>
      </td>
    <?php endif; ?></td>
    </tr>
  </table>
</form>

<?php
include("inc/footer.inc.php");
?>