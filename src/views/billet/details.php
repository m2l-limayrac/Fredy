<?php

//
// Vue "Détails d'un billet"
//
echo '<h2>Détails du billet ' . $billet->get_id_billet() . '</h2>';
echo '<hr>';
echo '<h3>Titre : ' . $billet->get_titre() . '</h3>';
echo '<p>ID : ' . $billet->get_id_billet() . '</p>';
echo '<p>Titre : ' . $billet->get_titre() . '</p>';
echo '<pre>Contenu : ' . $billet->get_contenu() . '</pre>';
echo '<p>Date : ' . $billet->get_lib_date() . '</p>';
echo '<hr>';
if (count($billet->get_commentaires()) == 0) {
  echo '<p>Pas de commentaire</p>';
} else {
  foreach ($billet->get_commentaires() as $commentaire) {
    echo '<pre>' . $commentaire->get_contenu() . '</pre>';
    echo '<p>Le ' . $commentaire->get_lib_date() . ' par ' . $utilisateur->get_login() . '</p>';
  }
}
echo '<hr>';
echo '<p><a href="' . BASEURL . '/billet/modifier/'.$billet->get_id_billet().'">Modifier</a> le billet</p>';
echo '<p><a href="' . BASEURL . '/billet/commenter/'.$billet->get_id_billet().'">Ajouter</a> un commentaire</p>';
echo '<p>Revenir à la <a href="' . BASEURL . '/billet/index">liste</a> des billets</p>';
