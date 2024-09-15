<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

// Si une action de suppression est déclenchée
if (isset($_GET['supp']) && $_GET['supp'] == 'supprimer') {
    $resultat = $pdo->exec("DELETE FROM salle WHERE id_salle = '$_GET[idSalle]' ");
    if ($resultat == 1) {
        echo "<span style='background-color: red; color:white'>Suppression effectuée avec succès</span>";
    }
    echo "<script> window.location.href='gestion_salle.php';</script>"; // On reste sur la même page après suppression
}

// Traitement du formulaire d'ajout ou de modification
if (!empty($_POST)) {
    if (!empty($_FILES['photo']['name'])) {
        $unique = time();
        $nom_photo = $unique . '_' . $_FILES['photo']['name'];
        $db = RACINE_SITE . 'photo/' . $nom_photo;
        $chemin = $_SERVER['DOCUMENT_ROOT'] . $db;
        copy($_FILES['photo']['tmp_name'], $chemin);
    }

    $titre = $_POST['titre'];
    $description = addslashes($_POST['description']);
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $cp = $_POST['cp'];
    $capacite = $_POST['capacite'];
    $categorie = $_POST['categorie'];

    if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['idSalle'])) {
        if (empty($_FILES['photo']['name'])) {
            $resultat = $pdo->exec("UPDATE salle SET titre='$titre', description='$description', pays='$pays', ville='$ville', adresse='$adresse', cp='$cp', capacite='$capacite', categorie='$categorie' WHERE id_salle='$_GET[idSalle]'");
        } else {
            $resultat = $pdo->exec("UPDATE salle SET titre='$titre', description='$description', photo='$db', pays='$pays', ville='$ville', adresse='$adresse', cp='$cp', capacite='$capacite', categorie='$categorie' WHERE id_salle='$_GET[idSalle]'");
        }
        if ($resultat == 1) {
            echo "<span style='background-color:green;color:white'>La salle a été modifiée avec succès</span>";
        }
    } elseif (isset($_GET['action']) && $_GET['action'] == "ajouter") {
        $resultat = $pdo->exec("INSERT INTO salle(titre,description,photo,pays,ville,adresse,cp,capacite,categorie) VALUES('$titre','$description','$db','$pays','$ville','$adresse','$cp','$capacite','$categorie')");
        if ($resultat == 1) {
            echo "<span style='background-color:green;color:white'>La salle a été ajoutée avec succès</span>";
        }
    }
}


// Affichage des salles
$salles = $pdo->query("SELECT * FROM salle");
echo "<h3 class='text-center mt-5'>Gestion des salles</h3>";
echo "<table class='table mx-auto w-75 mb-5'>";
echo "<thead><tr><th scope='col'>Titre</th><th scope='col'>Description</th><th scope='col'>Photo</th><th scope='col'>Pays</th><th scope='col'>Ville</th><th scope='col'>Adresse</th><th scope='col'>Code Postal</th><th scope='col'>Capacité</th><th scope='col'>Categorie</th><th scope='col'>Actions</th></tr></thead>";
while ($donnees = $salles->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td>{$donnees['titre']}</td><td>{$donnees['description']}</td><td><img src='{$donnees['photo']}' alt='' width='70' /></td><td>{$donnees['pays']}</td><td>{$donnees['ville']}</td><td>{$donnees['adresse']}</td><td>{$donnees['cp']}</td><td>{$donnees['capacite']}</td><td>{$donnees['categorie']}</td><td><a href='?supp=supprimer&idSalle={$donnees['id_salle']}'><img src='./inc/img/effacer.png' width=25 title='Supprimer la salle'/></a></td><td><a href='?action=modifier&idSalle={$donnees['id_salle']}'><img src='./inc/img/modifier.png' width=18 title='Modifier la salle'/></a></td></tr>";
}
echo "</table>";

// Affichage du formulaire d'ajout/modification de salle
if (isset($_GET['idSalle'])) {
    $salles = $pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[idSalle]' ");
    $donnees = $salles->fetch(PDO::FETCH_ASSOC);
}

?>
<form action="" method="post" enctype="multipart/form-data">
    <table class="table w-50 mx-auto">
        <tr>
            <td><label for="titre">Titre</label></td>
            <td><input type="text" name="titre" value="<?= $donnees['titre'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="description">Description</label></td>
            <td><input type="text" name="description" value="<?= $donnees['description'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="pays">Pays</label></td>
            <td><input type="text" name="pays" value="<?= $donnees['pays'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="ville">Ville</label></td>
            <td><input type="text" name="ville" value="<?= $donnees['ville'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="photo">Photo</label></td>
            <td><input type="file" name="photo" /></td>
            <td><?php if (isset($donnees['photo'])) { ?><img src="<?= $donnees['photo'] ?>" width="70" /><?php } ?></td>
        </tr>
        <tr>
            <td><label for="adresse">Adresse</label></td>
            <td><input type="text" name="adresse" value="<?= $donnees['adresse'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="cp">Code Postal</label></td>
            <td><input type="number" name="cp" value="<?= $donnees['cp'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="capacite">Capacité</label></td>
            <td><input type="number" name="capacite" value="<?= $donnees['capacite'] ?? '' ?>" /></td>
        </tr>
        <tr>
            <td><label for="categorie">Catégorie</label></td>
            <td><select name="categorie">
                    <option value="reunion" <?= isset($donnees['categorie']) && $donnees['categorie'] == 'reunion' ? 'selected' : '' ?>>Réunion</option>
                    <option value="bureau" <?= isset($donnees['categorie']) && $donnees['categorie'] == 'bureau' ? 'selected' : '' ?>>Bureau</option>
                    <option value="formation" <?= isset($donnees['categorie']) && $donnees['categorie'] == 'formation' ? 'selected' : '' ?>>Formation</option>
                </select></td>
        </tr>
        <tr>
            <td><input type="submit" value="<?= isset($_GET['idSalle']) ? 'Modifier la salle' : 'Ajouter la salle' ?>" class="btn btn-outline-success" />
                <?php if (isset($_GET['action']) && $_GET['action'] == 'modifier'): ?>
            <td>
                <a href="gestion_salle.php" class="btn btn-outline-danger">Annuler</a>
            </td>
        <?php endif; ?></td>
        </tr>
    </table>
</form>

<?php
include("inc/footer.inc.php");
?>