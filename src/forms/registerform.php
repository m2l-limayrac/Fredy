<?php

//
// Formulaire d'un demandeur
//
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="POST">
  <p>AdresseMail<br/><input type="text" name="AdresseMail" value="<?php echo $demandeur->get_AdresseMail(); ?>"/></p>
  <p>MotDePasse<br/><input type="text" name="MotDePasse" value="<?php echo $demandeur->get_MotDePasse(); ?>" /></p>
  <p><input type="hidden" name="ID_Demandeur" value="<?php echo $demandeur->get_ID_Demandeur(); ?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>