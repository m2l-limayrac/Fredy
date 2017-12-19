<?php $i = 1; ?>

<style>

.first {
	margin-left: 25%;
}
.lien {
	text-decoration: none;
}
<style>

.demo-list-action {width: 300px;}
.mdl-data-table th{text-align: center;}

</style>

<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp first">
  <thead>
    <tr>
      <th class="mdl-data-table__cell--non-numeric">Adherent</th>
      <th class="mdl-data-table__cell--non-numeric">Nom Prenom</th>
      <th>Modification adherent</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($demandeur->get_Representant()->get_les_adherents() as $adherent) { ?>
    <tr>
      <div class="demo-list-action mdl-list">
        <td>
          <i class="material-icons">face</i>
        </td>
        <td>
          <span><?php echo $adherent->get_Nom() ?> <?php echo $adherent->get_Prenom() ?></span>
        </td>
        <td>
          <a class="mdl-list__item-secondary-action lien" href="<?php echo BASEURL.'/Adherent/settings/'.$adherent->get_id_adherent() ?>">
            <div id="tt<?php echo $i ?>" class="icon material-icons">edit</div>
            <div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Modifier l'adherent</div>
          </a>
          
          <a class="mdl-list__item-secondary-action lien" href="<?php echo BASEURL.'/Adherent/delete/'.$adherent->get_id_adherent() ?>">
            <div id="tt<?php echo $i ?>" class="icon material-icons">delete</div>
            <div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Supprimmer l'adherent</div>
          </a>
        </td>
      </div>
    </tr>
    <?php } ?>
  </tbody>
</table>