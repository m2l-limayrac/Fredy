<?php
//
// Vue de Billet/index
//
echo '<h2>Liste des billets</h2>';
echo '<p><a href="'.BASEURL.'/billet/ajouter">[Ajouter]</a> un billet</p>';
foreach ($billets as $billet) {
  echo '<h3>'.$billet->get_titre().'</h3>';
  echo '<p>Le '.$billet->get_lib_date().'</p>';
  echo '<p>'.count($billet->get_commentaires()).' commentaire(s)</p>';
  echo '<p><a href="'.BASEURL.'/billet/details/'.$billet->get_id_billet().'">[détails]</a></p>';
  echo '<hr>';
}
