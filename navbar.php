<?php
if (!isset($_SESSION["no_client"])){
?>
<nav class="navbar is-transparent is-black" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://samsam.go.yo.fr">
      <img src="https://samsam.go.yo.fr/avatar.ico">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="index.php">
      <span class="icon">
            <i class="fas fa-home"></i>
          </span>
          <span>
          Accueil
          </span>    
      </a>
    </div>
  </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-link" href="reservation.php">
          <span class="icon">
            <i class="fas fa-map-pin"></i>
          </span>
          <span>
          <strong>Réservation</strong>
          </span> 
          </a>
          <a class="button is-light" href="connexion.php">
          <span class="icon">
            <i class="fas fa-sign-in-alt"></i>
          </span>
          <span>
          Connexion
          </span>    
            
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
<?php }else{ ?>
  <nav class="navbar is-transparent is-black" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://samsam.go.yo.fr">
      <img src="https://samsam.go.yo.fr/avatar.ico">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="index.php">
      <span class="icon">
            <i class="fas fa-home"></i>
          </span>
          <span>
          Accueil
          </span>    
        
      </a>
      <a class="navbar-item" href="espace_client.php">
        Mon espace client
      </a>
    </div>
  </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
        <a class="button is-white is-light is-static" href="">
        <span class="icon">
            <i class="fas fa-user-circle"></i>
          </span>
          <span>
          Connecté en tant que&nbsp;<strong><?= $_SESSION["prenom"] ?> <?= $_SESSION["nom"] ?></strong>
          </span>    
          </a>
          <a class="button is-danger" href="deconnexion.php">
          <span class="icon">
            <i class="fas fa-sign-out-alt"></i>
          </span>
          <span>
          Déconnexion
          </span>    
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
<?php } ?>