
<form action="<?php echo BASEURL.'/'.$action; ?>" method="POST">
  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="sample3" name="Nom" value="<?php echo $adherent->get_Nom(); ?>">
    <label class="mdl-textfield__label" for="sample3">Nom</label>
  </div></p>

  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="sample3" name="Prenom" value="<?php echo $adherent->get_Prenom(); ?>" >
    <label class="mdl-textfield__label" for="sample3">Prenom</label>
  </div></p>

  <p>date de naissance<br/><input type="date" name="DateDeNaissance" value="<?php echo $adherent->get_DateNaissance(); ?>" /></p>

  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="email" id="sample3" name="mail" value="<?php echo $demandeur->get_AdresseMail(); ?>" >
    <label class="mdl-textfield__label" for="sample3">Adresse mail </label>
  </div></p>

  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password" id="sample3" name="mpd" value="<?php echo $demandeur->get_MotDePasse(); ?>" >
    <label class="mdl-textfield__label" for="sample3">Mot de passe</label>
  </div></p>

  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password" id="sample3" name="mpd" value="<?php echo $demandeur->get_MotDePasse(); ?>" >
    <label class="mdl-textfield__label" for="sample3">Confirmation Mot de passe</label>
  </div></p>

  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="sample3" name="club" value="<?php echo $club->get_Nom(); ?>" >
    <label class="mdl-textfield__label" for="sample3">Club</label>
  </div></p>

  <p><?php echo "Ligue d'affiliation"; ?> </p>
  <p>
  <?php
  $i=0;
           		foreach ($ligues as $ligue) {
           				echo '<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-'.$i.'">
	  <input type="radio" id="option-'.$i.'" class="mdl-radio__button" name="ligue" value="'.$ligue->get_Id_Ligue().'">
	  <span class="mdl-radio__label">'.$ligue->get_Nom_ligue().'</span>
	</label>';
	$i++;
	echo "&nbsp &nbsp &nbsp &nbsp &nbsp";
           		}
           ?>
	
</p>

  <p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="sample4" name="licence" value="<?php echo $adherent->get_numLicence(); ?>">
    <label class="mdl-textfield__label" for="sample4">numero de licence</label>
    <span class="mdl-textfield__error">Le numero de licence est composé que de chiffre</span>
  </div></p>

  <p><input type="hidden" name="ID_Demandeur" value="<?php echo $demandeur->get_ID_Demandeur(); ?>"></p>
  <p><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
  Ok
</button></p>
</form>