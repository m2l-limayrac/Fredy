<?php

//
// Formulaire d'un billet
//
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  <p>Titre<br/><input type="text" name="titre" value="<?php echo $billet->get_titre(); ?>"></p>
  <p>Contenu<br/><textarea name="contenu" rows="10" cols="50"><?php echo $billet->get_contenu(); ?></textarea></p>
  <p><input type="hidden" name="id_billet" value="<?php echo $billet->get_id_billet(); ?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>

