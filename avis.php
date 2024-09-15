<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['membre'])) {
  // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
  echo "<script> window.location.href='connexion.php';</script>";
  // Arrête l'exécution du script ici
}

$id_salle = isset($_GET['idSalle']) ? $_GET['idSalle'] : null;

if (empty($id_salle)) {
  echo "<div class='alert alert-danger'>Erreur : L'identifiant de la salle est manquant.</div>";
  exit(); // Arrête l'exécution du script ici
}

$id_membre = $_SESSION['membre']['id_membre'];
$nom_membre = $_SESSION['membre']['nom'];
$email_membre = $_SESSION['membre']['email'];

if (isset($_POST['submit_avis'])) {
  // Récupérer les données du formulaire
  $commentaire = $_POST['commentaire'];
  $note = $_POST['note'];
  $date_enregistrement = date("Y-m-d H:i:s");

  // Vérifier si toutes les informations nécessaires sont présentes
  if (!empty($commentaire) && !empty($note)) {
    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO avis (id_membre, id_salle, commentaire, note, date_enregistrement)
        VALUES (:id_membre, :id_salle, :commentaire, :note, :date_enregistrement)");

    $stmt->bindParam(':id_membre', $id_membre);
    $stmt->bindParam(':id_salle', $id_salle);
    $stmt->bindParam(':commentaire', $commentaire);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':date_enregistrement', $date_enregistrement);

    if ($stmt->execute()) {
      echo "<div class='alert alert-success'>Merci pour votre avis !</div>";
    } else {
      echo "<div class='alert alert-danger'>Erreur lors de la soumission de votre avis.</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Veuillez remplir tous les champs du formulaire.</div>";
  }
}
?>

<!-- Formulaire d'avis -->
<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-lg-center">
      <div class="col-12 col-lg-9">
        <div class="bg-white border rounded shadow-sm overflow-hidden">
          <h4 class="text-center">Donnez-nous votre avis !</h4>
          <form action="avis.php?idSalle=<?= $id_salle; ?>" method="POST">
            <div class="row gy-4 gy-xl-5 p-4 p-xl-5">

              <div class="col-12">
                <p>Connecté en tant que : <strong><?= $nom_membre; ?></strong> (<em><?= $email_membre; ?></em>)</p>
                <input type="hidden" name="nom_membre" value="<?= $nom_membre; ?>">
                <input type="hidden" name="email_membre" value="<?= $email_membre; ?>">
              </div>

              <div class="col-12">
                <label for="commentaire" class="form-label">Votre commentaire <span class="text-danger">*</span></label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="3" required></textarea>
              </div>

              <div class="col-12">
                <label for="note" class="form-label">Note (1 à 5) <span class="text-danger">*</span></label>
                <select class="form-control" id="note" name="note" required>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>

              <div class="col-12">
                <div class="d-grid">
                  <button class="btn btn-primary btn-lg" type="submit" name="submit_avis">Envoyer votre avis</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include("inc/footer.inc.php");
?>