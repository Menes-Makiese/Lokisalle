<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

// Récupération des avis
try {
  $avis = $pdo->query("SELECT
            avis.*,
            membre.nom,
            membre.prenom,
            membre.email,
            salle.titre
        FROM avis
        JOIN membre ON avis.id_membre = membre.id_membre
        JOIN salle ON avis.id_salle = salle.id_salle
        ORDER BY avis.date_enregistrement DESC");

  // Convertir en tableau associatif
  $liste_avis = $avis->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Erreur : " . $e->getMessage();
}
if (isset($_GET['supp']) && $_GET['supp'] == 'supprimer' && isset($_GET['idAvis'])) {
  $idAvis = $_GET['idAvis'];
  $resultat = $pdo->exec("DELETE FROM avis WHERE id_avis = '$idAvis'");
  if ($resultat == 1) {
    echo "<span style='background-color:red;color:white'>avis supprimé avec succès</span>";
  }
}

// Debugging
//debug($liste_avis);
?>

<h2 class="text-center mt-5">Gestion des avis</h2>
<table class="table w-75 mx-auto ">
  <thead>
    <tr>
      <th scope='col'>ID avis</th>
      <th scope='col'>Salle</th>
      <th scope='col'>Client</th>
      <th scope='col'>Commentaire</th>
      <th scope='col'>Note</th>
      <th scope='col'>Date/heure d'achat</th>
      <th scope='col'>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($liste_avis)): ?>
      <?php foreach ($liste_avis as $avis): ?>
        <tr>
          <td><?= htmlspecialchars($avis['id_avis']); ?></td>
          <td><?= htmlspecialchars($avis['titre']); ?></td>
          <td><?= htmlspecialchars($avis['nom'] . ' ' . $avis['prenom'] . ' - ' . $avis['email']); ?></td>
          <td><?= htmlspecialchars($avis['commentaire']); ?></td>
          <td><?= htmlspecialchars($avis['note']); ?></td>
          <td><?= date('d F Y - H:i', strtotime($avis['date_enregistrement'])); ?></td>
          <?php echo "<td><a href='?supp=supprimer&idAvis={$avis['id_avis']}'><img src='./inc/img/effacer.png' width=25 title='Supprimer l'avis'/></a></td>" ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6">Aucune avis trouvée.</td>
      </tr>
    <?php endif; ?>
    <tr>

    </tr>
  </tbody>
</table>

<?php

include("inc/footer.inc.php");
