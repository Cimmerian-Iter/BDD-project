<?php 

require_once("connect_database.php");
require_once("functions.php");

if (isset($_SESSION["no_client"])){
	header("location: espace_client.php");
}

include_once("header.php");
?>

<body>
  <?php include_once("navbar.php") ?>
  <section class="section">
    <div class="container">
      <h1 class="title is-spaced is-2">
        Espace de connexion
      </h1>

      <p class="subtitle is-4">
        Pour accéder à vos réservations, veuillez remplir le <strong>formulaire de connexion</strong>.
      </p><br>
    
      <form method="post" action="connexion_php.php">
        <div class="field">
            <label class="label">Numéro de client*</label>
            <div class="control has-icons-left">
                <input class="input" name="no_client" type="text" placeholder="0123456" required autofocus>
                <span class="icon is-small is-left">
                  <i class="fas fa-id-badge"></i>
                </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Adresse mail*</label>
            <div class="control has-icons-left">
                <input class="input" type="email" name="adresse_mail" pattern="[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+" placeholder="jean.dupond@example.com" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
            </div>
            </div><br>

            <div class="field is-grouped">
            <div class="control">
              <button class="button is-link" type="submit">Se connecter</button>
            </div>
            <div class="control">
              <a class="button is-link is-light" href="reservation.php">Je n'ai pas de compte</a>
            </div>
          </div>
      </form>  
 
  </section>
</body>

</html>