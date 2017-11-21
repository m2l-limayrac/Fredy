<?php

//
// Formulaire d'un commentaire
//
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  <p>Contenu<br/><textarea name="contenu" rows="10" cols="50"><?php echo $commentaire->get_contenu(); ?></textarea></p>
  <p><input type="hidden" name="id_billet" value="<?php echo $commentaire->get_id_billet(); ?>"></p>
  <p><input type="hidden" name="id_commentaire" value="<?php echo $commentaire->get_id_commentaire(); ?>"></p>
  <p><input type="hidden" name="id_utilisateur" value="<?php echo $commentaire->get_id_utilisateur(); ?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>