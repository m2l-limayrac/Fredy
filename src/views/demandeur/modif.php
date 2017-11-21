<?php
//
// Vue "Connexion d'un utilisateur"
//
echo "<h2>Modification</h2>";
if($demandeur->get_isRepresentant()){
	require_once SRC.DS.'Forms'.DS.'modifAdherentForm.php';
}else{
	require_once SRC.DS.'Forms'.DS.'modifRepresentantForm.php';
}
echo '<hr>';
/*echo '<p>Revenir à la <a href="' . BASEURL . '/adherent/index">liste</a> des adherent</p>';