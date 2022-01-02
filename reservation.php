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
        Inscription
      </h1>

      <p class="subtitle is-4">
        Veuillez remplir le formulaire afin de vous inscrire.
      </p><br>
      <form method="post" action="reservation_php.php">
      <p class="subtitle is-5">
        Informations générales
      </p>
        <div class="field">
            <label class="label">Nom de famille*</label>
            <div class="control has-icons-left">
                <input class="input" name="nom" type="text" placeholder="DUPOND" required autofocus>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Prénom*</label>
            <div class="control has-icons-left">
                <input class="input" name="prenom" type="text" placeholder="Jean" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Adresse de l'usine de votre écurie*</label>
            <div class="control has-icons-left">
                <input class="input" name="adresse_postale" type="text" placeholder="2 rue des cerises, 75000 Paris" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-map-marked-alt"></i>
                </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Adresse mail de l'équipe*</label>
            <div class="control has-icons-left">
                <input class="input" type="email" name="adresse_mail" pattern="[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+" placeholder="jean.dupond@example.com" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Numéro de téléphone*</label>
            <div class="control has-icons-left">
                <input class="input" type="tel" name="num_tel" size="20" minlength="9" maxlength="14" pattern="0[0-9]{1} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}" placeholder="01 23 45 67 89" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-phone-alt"></i>
                </span>
            </div>
            </div><br>

            <br><p class="subtitle is-5">
              Informations sur l'écurie
            </p>
            <div class="field">
            <label class="label">Catégorie*</label>
            <div class="control has-icons-left">
            <div class="select" required>
              <select required name="type_bungalow">
                <option disabled>Sélectionnez un type d'écurie</option>
                <option value="Oasis">Formule 1</option>
                <option value="Pacifique">Formule 2</option>
              </select>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Nombre de pilote*</label>
            <div class="control has-icons-left">
                <input class="input" type="number" name="nb_occupants" placeholder="1" min="1" max="4" step="1" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-users"></i>
                </span>
            </div>
            <p class="help is-info"><u>Information :</u> Vous ne pouvez employer que deux pilotes pour la course, mais vous n'avez pas de restrictions pour les essais libres.</p>
            </div><br>

            <br><p class="subtitle is-5">
              Durée de votre sejour sur les installations du circuit
            </p>

            <div class="field">
            <label class="label">Date de début de séjour*</label>
            <div class="control has-icons-left">
                <input class="input" name="date_debut_sejour" type="date" value="<?php echo date("YYYY")."-".date("mm")."-".date("dd"); ?>" min="<?php echo date("YYYY")."-".date("mm")."-".date("dd"); ?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-calendar-check"></i>
                </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Date de fin de séjour*</label>
            <div class="control has-icons-left">
                <input class="input" name="date_fin_sejour" type="date" value="<?php echo date("YYYY")."-".date("mm")."-".date("dd"); ?>" min="<?php echo date("YYYY")."-".date("mm")."-".date("dd"); ?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-calendar-times"></i>
                </span>
            </div>
            </div><br>

            <br><p class="subtitle is-5">
              Informations sur le paiement
            </p>
            <div class="field">
            <label class="label">Mode de paiement*</label>
            <div class="control has-icons-left">
            <div class="select" required>
              <select required name="mode_paiement">
                <option disabled>Sélectionnez un mode de paiement</option>
                <option value="Carte bancaire">Carte bancaire</option>
                <option value="Chèque">Chèque</option>
              </select>
              <span class="icon is-small is-left">
                  <i class="fas fa-money-check-alt"></i>
                </span>
            </div>
            </div><br><br>

            <div class="field is-grouped">
            <div class="control">
              <button class="button is-link" type="submit">S'inscrire</button>
            </div>
            <div class="control">
              <a class="button is-link is-light" href="connexion.php">Je me suis déja inscrit</a>
            </div>
          </div>
      </form>  
    </div>
  </section>
</body>

</html>