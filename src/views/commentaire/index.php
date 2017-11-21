<?php
//
// Vue de commentaire/index
//
echo '<h2>Liste des commentaires</h2>';
foreach ($commentaires as $commentaire) {
  echo '<p>ID commentaire : '.$commentaire->get_id_commentaire().'</p>';
  echo '<p>ID billet : '.$commentaire->get_id_billet().'</p>';
  echo '<p>ID utilisateur : '.$commentaire->get_id_utilisateur().'</p>';
  echo '<p>Contenu : </p>';
  echo '<pre>'.$commentaire->get_contenu().'</pre>';
  echo '<p>Le '.$commentaire->get_lib_date().'</p>';
  
  echo '<p><a href="'.BASEURL.'/commentaire/modifier/'.$commentaire->get_id_commentaire().'">[modifier]</a></p>';
  echo '<p><a href="'.BASEURL.'/commentaire/supprimer/'.$commentaire->get_id_commentaire().'">[supprimer]</a></p>';
  echo '<hr>';
}
