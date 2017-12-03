<?php
//
// Vue de Utilisateur/index
//
?>
<h2>Liste des demandeurs</h2>
<p><a href="<?php echo BASEURL . '/demandeur/register'; ?>">[Ajouter]</a> un demandeur</p>
<ul>
  <?php
  foreach ($demandeurs as $demandeur) {
    ?>
    <li><?php echo $demandeur->get_AdresseMail(); ?> <a href="<?php echo BASEURL . '/demandeur/details/' . $demandeur->get_id_demandeur(); ?> ">[détails]</a></li>
  <?php } ?>
</ul>

