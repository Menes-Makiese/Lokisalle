<!Doctype html>
<html>

<head>
  <title>Lokisalle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" href="inc/img/bd3f8963e5364dd4a35cd288498acc46-free.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Darker+Grotesque:wght@500&family=Lavishly+Yours&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/comments-forms/comment-form-1/assets/css/comment-form-1.css">
  <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/style.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-2">
      <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="accueil.php" style="min-width:180px">
          <img style="height:64px" src="inc/img/bd3f8963e5364dd4a35cd288498acc46-free.png" alt="new logo" />
        </a>

        <!-- Navbar Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <!-- Navigation Links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link mx-2" aria-current="page" href="accueil.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-2" href="<?php echo RACINE_SITE; ?>location.php">Locations</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-2" href="<?php echo RACINE_SITE; ?>qui_sommes_nous.php">Qui sommes nous ?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-2" href="<?php echo RACINE_SITE; ?>contact.php">Contact</a>
            </li>

            <!-- Gestion Dropdown for Admin Only -->
            <?php if (isConnectedAndAdmin()) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Gestion
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="<?php echo RACINE_SITE; ?>gestion_membre.php">Membre</a></li>
                  <li><a class="dropdown-item" href="<?php echo RACINE_SITE; ?>gestion_produit.php">Produit</a></li>
                  <li><a class="dropdown-item" href="<?php echo RACINE_SITE; ?>gestion_avis.php">Avis</a></li>
                  <li><a class="dropdown-item" href="<?php echo RACINE_SITE; ?>gestion_commande.php">Commande</a></li>
                  <li><a class="dropdown-item" href="<?php echo RACINE_SITE; ?>gestion_salle.php">Salle</a></li>
                </ul>
              </li>
            <?php } ?>
          </ul>

          <!-- Right Side (Cart, Profile/Login, etc.) -->
          <ul class="navbar-nav ms-auto d-inline-flex justify-content-between align-content-center">
            <?php if (isConnected() || isConnectedAndAdmin()) { ?>
              <li class="nav-item position-relative mx-2">
                <a class="nav-link" href='<?php echo RACINE_SITE; ?>panier.php'>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                  </svg>
                  <span class="ms-1 align-middle">Panier</span>
                  <span id="cart-count" class="badge bg-sucess">0</span> <!-- Pastille pour afficher le nombre -->
                </a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="<?php echo RACINE_SITE; ?>profil.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                  </svg>
                  <span class="ms-1 align-text-top">Mon Profil</span>
                </a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="<?php echo RACINE_SITE; ?>deconnexion.php">
                  <span>Déconnexion</span>
                </a>
              </li><?php } else {
                    ?>
              <li class="nav-item position-relative mx-2">
                <a class="nav-link" href="<?php echo RACINE_SITE; ?>panier.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                  </svg>
                  <span class="ms-1 align-middle">Panier</span>
                  <span id="cart-count" class="badge bg-sucess">0</span>
                </a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="<?php echo RACINE_SITE; ?>connexion.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                  </svg>
                  <span class="ms-1 align-text-top">Connexion</span>
                </a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="<?php echo RACINE_SITE; ?>inscription.php">
                  <span>Inscription</span>
                </a>
              </li><?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <section>
    <div>