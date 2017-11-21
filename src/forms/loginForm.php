<?php

//
// Formulaire pour les connexions
//
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  <p>AdresseMail<br/><input type="text" name="AdresseMail" value="<?php echo $demandeur->get_AdresseMail(); ?>"/></p>
  <p>MotDePasse<br/><input type="text" name="MotDePasse" value="<?php echo $demandeur->get_MotDePasse(); ?>" /></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>