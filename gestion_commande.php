<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

// Récupération des commandes
try {
  $commandes = $pdo->query("SELECT
            commande.*,
            membre.nom,
            membre.prenom,
            membre.email,
            produit.prix,
            produit.date_arrivee,
            produit.date_depart,
            salle.titre
        FROM commande
        JOIN membre ON commande.id_membre = membre.id_membre
        JOIN salle ON commande.id_produit = salle.id_salle
        JOIN produit ON commande.id_produit = produit.id_salle
        ORDER BY commande.date_enregistrement DESC");

  // Convertir en tableau associatif
  $liste_commandes = $commandes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Erreur : " . $e->getMessage();
}
if (isset($_GET['supp']) && $_GET['supp'] == 'supprimer' && isset($_GET['idCommande'])) {
  $idCommande = $_GET['idCommande'];
  $resultat = $pdo->exec("DELETE FROM commande WHERE id_commande = '$idCommande'");
  if ($resultat == 1) {
    echo "<span style='background-color:red;color:white'>Commande supprimé avec succès</span>";
  }
}

// Debugging
//debug($liste_commandes);
?>

<h2 class="text-center mt-5">Gestion des commandes</h2>
<table class="table w-75 mx-auto ">
  <thead>
    <tr>
      <th scope='col'>ID Commande</th>
      <th scope='col'>Client</th>
      <th scope='col'>ID Produit</th>
      <th scope='col'>Prix</th>
      <th scope='col'>Date Evenement</th>
      <th scope='col'>Date/heure d'achat</th>
      <th scope='col'>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($liste_commandes)): ?>
      <?php foreach ($liste_commandes as $commande): ?>
        <tr>
          <td><?= htmlspecialchars($commande['id_commande']); ?></td>
          <td><?= htmlspecialchars($commande['nom'] . ' ' . $commande['prenom'] . ' - ' . $commande['email']); ?></td>
          <td><?= htmlspecialchars($commande['id_produit'] . ' - ' . $commande['titre']); ?></td>
          <td><?= htmlspecialchars($commande['prix']); ?> €</td>
          <td><?= date('d F Y - H:i', strtotime($commande['date_arrivee'])) . '<br>' . date('d F Y - H:i', strtotime($commande['date_depart'])); ?></td>
          <td><?= date('d F Y - H:i', strtotime($commande['date_enregistrement'])); ?></td>
          <?php echo "<td><a href='?supp=supprimer&idCommande={$commande['id_commande']}'><img src='./inc/img/effacer.png' width=25 title='Supprimer la commande'/></a></td>" ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6">Aucune commande trouvée.</td>
      </tr>
    <?php endif; ?>
    <tr>
      <th></th>
      <th></th>
      <th>Total Commande</th>
      <th><?php echo prixTotalCommandes($liste_commandes) . "&euro;"; ?></th>
    </tr>
  </tbody>
</table>

<?php

include("inc/footer.inc.php");
