<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

// Récupération des salles existantes dans la base de données
$salles = $pdo->query("SELECT id_salle, titre FROM salle");

// Vérifie si l'action est 'modifier' et un idProduit est présent dans l'URL
$produit = null; // Définit $produit par défaut à null
if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['idProduit']) && is_numeric($_GET['idProduit'])) {
  // Récupérer les informations du produit à partir de l'idProduit
  $resultat = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[idProduit]'");

  if ($resultat !== false) {
    $produit = $resultat->fetch(PDO::FETCH_ASSOC);
  } else {
    echo "<span style='background-color:red;color:white'>Erreur dans la requête SQL</span>";
  }
}

// Traitement du formulaire (ajout ou modification)
if (!empty($_POST)) {
  $date_arrivee = $_POST['date_arrivee'];
  $date_depart = $_POST['date_depart'];
  $prix = $_POST['prix'];
  $id_salle = $_POST['id_salle'];
  $etat = $_POST['etat'];

  if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['idProduit']) && is_numeric($_GET['idProduit'])) {
    // Requête de modification (UPDATE)
    $resultat = $pdo->prepare("UPDATE produit SET date_arrivee = :date_arrivee, date_depart = :date_depart, prix = :prix, id_salle = :id_salle, etat = :etat WHERE id_produit = :id_produit");
    $resultat->execute([
      ':date_arrivee' => $date_arrivee,
      ':date_depart' => $date_depart,
      ':prix' => $prix,
      ':id_salle' => $id_salle,
      ':etat' => $etat,
      ':id_produit' => $_GET['idProduit']
    ]);

    if ($resultat) {
      echo "<span style='background-color:green;color:white'>Produit modifié avec succès</span>";
    } else {
      echo "<span style='background-color:red;color:white'>Erreur lors de la modification</span>";
    }
  } else {
    // Requête d'insertion (INSERT)
    $resultat = $pdo->prepare("INSERT INTO produit (date_arrivee, date_depart, prix, id_salle, etat) 
                                VALUES (:date_arrivee, :date_depart, :prix, :id_salle, :etat)");
    $resultat->execute([
      ':date_arrivee' => $date_arrivee,
      ':date_depart' => $date_depart,
      ':prix' => $prix,
      ':id_salle' => $id_salle,
      ':etat' => $etat
    ]);

    if ($resultat) {
      echo "<span style='background-color:green;color:white'>Produit ajouté avec succès</span>";
    } else {
      echo "<span style='background-color:red;color:white'>Erreur lors de l'ajout</span>";
    }
  }
}
?>

<h3 class="text-center mt-5 mb-4">Gestion des produits</h3>

<table class="table mx-auto w-75 mb-5">
  <thead>
    <tr>
      <th scope='col'>ID du produit</th>
      <th scope='col'>Salle</th>
      <th scope='col'>Date d'arrivée</th>
      <th scope='col'>Date de départ</th>
      <th scope='col'>Prix</th>
      <th scope='col'>État</th>
      <th scope='col'>Actions</th>
    </tr>
  </thead>

  <?php
  // Récupération des produits dans la base de données
  $produits = $pdo->query("SELECT p.*, s.titre AS salle_titre, s.photo AS salle_photo 
                           FROM produit p 
                           JOIN salle s ON p.id_salle = s.id_salle");

  // Boucle pour afficher chaque produit
  while ($produit_table = $produits->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $produit_table['id_produit'] . "</td>";
    echo "<td>";
    echo $produit_table['id_salle'] . " - <br>";
    echo $produit_table['salle_titre'] . "<br>";
    echo "<img src='" . $produit_table['salle_photo'] . "' width='50' />";
    echo "</td>";
    echo "<td>" . $produit_table['date_arrivee'] . "</td>";
    echo "<td>" . $produit_table['date_depart'] . "</td>";
    echo "<td>" . $produit_table['prix'] . " &euro;" . "</td>";
    echo "<td>" . $produit_table['etat'] . "</td>";
    echo "<td>
               <a href='?action=modifier&idProduit={$produit_table['id_produit']}'><img src='./inc/img/modifier.png' width=18 title='Modifier le produit'/></a>
            </td>";
    echo "</tr>";
  }
  ?>
</table>

<!-- Formulaire d'ajout / modification des produits -->
<form method="post" action="">
  <table class="table w-50 mx-auto">
    <tr>
      <td><label for="date_arrivee">Date d'arrivée :</label></td>
      <td><input type="datetime-local" name="date_arrivee" value="<?= isset($produit) ? $produit['date_arrivee'] : '' ?>" required></td>
    </tr>
    <tr>
      <td><label for="date_depart">Date de départ :</label></td>
      <td><input type="datetime-local" name="date_depart" value="<?= isset($produit) ? $produit['date_depart'] : '' ?>" required></td>
    </tr>
    <tr>
      <td><label for="prix">Prix :</label></td>
      <td><input type="number" step="0.01" name="prix" value="<?= isset($produit) ? $produit['prix'] : '' ?>" required></td>
    </tr>
    <tr>
      <td><label for="id_salle">Sélectionnez une salle :</label></td>
      <td>
        <select name="id_salle" required>
          <?php while ($salle = $salles->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?= $salle['id_salle'] ?>" <?= (isset($produit) && $produit['id_salle'] == $salle['id_salle']) ? 'selected' : '' ?>><?= $salle['titre'] ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="etat">État :</label></td>
      <td>
        <select name="etat" required>
          <option value="libre" <?= (isset($produit) && $produit['etat'] == 'libre') ? 'selected' : '' ?>>Libre</option>
          <option value="reserver" <?= (isset($produit) && $produit['etat'] == 'reserver') ? 'selected' : '' ?>>Reserver</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><input type="submit" class="btn btn-outline-success" value="<?= isset($_GET['action']) && $_GET['action'] == 'modifier' ? 'Modifier le produit' : 'Ajouter le produit' ?>">
        <?php if (isset($_GET['action']) && $_GET['action'] == 'modifier'): ?>
      <td>
        <a href="gestion_produit.php" class="btn btn-outline-danger">Annuler</a>
      </td>
    <?php endif; ?></td>
    </tr>
  </table>
</form>

<?php
include("inc/footer.inc.php");
?>