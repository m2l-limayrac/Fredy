<form action="<?php echo BASEURL.'/'.$action; ?>" method="POST">
  <p>Nom<br/><input type="text" name="Nom" value="<?php echo $adherent->get_Nom(); ?>"/></p>
  <p>Prenom<br/><input type="text" name="Prenom" value="<?php echo $adherent->get_Prenom(); ?>" /></p>
  <p>Date de naissance<br/><input type="text" name="DateDeNaissance" value="<?php echo $adherent->get_DateNaissance(); ?>" /></p>
  <p>Adresse Mail<br/><input type="text" name="AdresseMail" value="<?php echo $demandeur->get_AdresseMail(); ?>" /></p>
  <p>Ancien Mot De Passe<br/><input type="text" name="MotDePasse" value="<?php echo $demandeur->get_MotDePasse(); ?>" /></p>
  <p>Nouveau Mot De Passe<br/><input type="text" name="MotDePasse" value="<?php echo $demandeur->get_MotDePasse(); ?>" /></p>
  <p><input type="hidden" name="num_licence" value="<?php echo $adherent->get_numLicence(); ?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>