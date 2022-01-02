<?php 

require_once("connect_database.php");
require_once("functions.php");

if (!isset($_SESSION["no_client"])){
	header("location: connexion.php");
}

include_once("header.php");
?>

<body>
  <?php include_once("navbar.php") ?>
  <section class="section">
    <div class="container">
      <h1 class="title is-spaced is-2">
        Espace d'ajout de réservation
      </h1>

      <p class="subtitle is-4">
        Pour ajouter une nouvelle réservation, veuillez remplir le <strong>formulaire de réservation simplifié</strong>.
      </p><br>
      <form method="post" action="new_reservation_php.php">
        <p class="subtitle is-5">
              Informations sur l'hébergement
            </p>
            <div class="field">
            <label class="label">Type de bungalow*</label>
            <div class="control has-icons-left">
            <div class="select" required>
              <select required name="type_bungalow">
                <option disabled>Sélectionnez un type de bungalow</option>
                <option value="Oasis">Oasis</option>
                <option value="Pacifique">Pacifique</option>
              </select>
              <span class="icon is-small is-left">
                  <i class="fas fa-caravan"></i>
              </span>
            </div>
            </div><br>

            <div class="field">
            <label class="label">Nombre d'occupants* (de plus de 13 ans)</label>
            <div class="control has-icons-left">
                <input class="input" type="number" name="nb_occupants" placeholder="1" min="1" max="4" step="1" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-users"></i>
                </span>
            </div>
            <p class="help is-info"><u>Information :</u> au delà de 2 occupants, un supplément est appliqué à hauteur de 50€ par occupant supplémentaire dans la limite de 4 occupants maximum.</p>
            </div><br>

            <br><p class="subtitle is-5">
              Informations sur le séjour
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
              <button class="button is-link" type="submit">Ajouter une réservation</button>
            </div>
            <div class="control">
              <a class="button is-link is-light" href="espace_client.php">Retour</a>
            </div>
          </div>
      </form>  
    </div>
  </section>
</body>

</html>