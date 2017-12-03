<?php

//
// Vue "Détails d'un adherent"
//
/*echo "<pre>";
print_r($demandeur);
echo "</pre>";*/
?>

<!-- List with avatar and controls -->
<style>
.demo-list-control {
  width: 300px;
}

.demo-list-radio {
  display: inline;
}
</style>

<!-- List items with avatar and action -->
<style>
.demo-list-action {
  width: 300px;
}

.MDF{
	width: 72%;
}
</style>
<pre>
	<?php //print_r($demandeur); 
	//print_r(get_defined_vars());?>
</pre>

<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp">
	<thead>
		<tr>
			<th class="mdl-data-table__cell--non-numeric">Note de frais</th>
			<th class="mdl-data-table__cell--non-numeric">Numero</th>
			<th>Annee</th>
			<th>détail de la note</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($demandeur->get_les_notes() as $note) { 
		 		$i = 1;?>
				<tr>
					<div class="demo-list-action mdl-list">
						<td>
						 	<i class="material-icons mdl-list__item-avatar">bookmark</i>
						</td>
						<td>
						      <span><?php echo $note->get_Id_NoteDeFrais() ?></span>
						</td>
						<td>
							<?php echo $note->get_les_lignes()[0]->get_Annee(); ?>
						</td>
						<td>
						    <a class="mdl-list__item-secondary-action show-modal" href="#">
								<div id="tt<?php echo $i ?>" class="icon material-icons">chevron_right</div>
								<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Voir les lignes de frais</div>
						    </a>
						</td>
						  </div>
					  
					</div>
				</tr>
		<?php 
			$i++; } 
		?>
	</tbody>
</table>
<dialog class="mdl-dialog MDF">
					  	<div class="mdl-dialog__title">Note de frais : <?php echo $note->get_Id_NoteDeFrais() ?></div>
					    <div class="mdl-dialog__content">
					    	<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp">
								<thead>
									<tr>
										<th class="mdl-data-table__cell--non-numeric">ligne de frais</th>
										<th>Numero</th>
										<th>Date</th>
										<th>Km</th>
										<th>Cout du Peage</th>
										<th>Cout du Repas</th>
										<th>Cout de l'hebergement</th>
										<th>Trajet</th>
										<th>Motif</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
							      <?php foreach ($note->get_les_lignes() as $ligne) { ?>
								      <tr>

											<td>
												<i class="material-icons mdl-list__item-avatar">bookmark</i>
											</td>
											<td>
									  		      <p><?php echo $ligne->get_Id_ligne() ?></p>
											</td>
											<td>
									  		      <p><?php echo $ligne->get_Date() ?></p>
											</td>
											<td>
									  		      <p><?php echo $ligne->get_Km() ?>Km</p>
											</td>
											<td>
									  		      <p><?php if($ligne->get_CoutPeage() != ""){echo $ligne->get_CoutPeage(); } else{ echo "0";} ?>€</p> 
											</td>
											<td>
									  		    <p><?php if($ligne->get_CoutRepas() != ""){echo $ligne->get_CoutRepas(); } else{ echo "0";} ?>€</p>
											</td>
											<td>
									  		      <p><?php if($ligne->get_CoutHebergement() != ""){echo $ligne->get_CoutHebergement(); } else{ echo "0";} ?>€</p>
											</td>
											<td>
									  		      <p><?php echo $ligne->get_Trajet() ?></p>
											</td>
											<td>
									  		      <p><?php echo $ligne->get_Motif() ?></p>
											</td>
											<td>
									  		    <a class="mdl-list__item-secondary-action" href="#">
									  				<div id="tt<?php echo $i ?>" class="icon material-icons">delete</div>
									  				<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Supprimmer</div>
									  		    </a>
									  		    <a class="mdl-list__item-secondary-action" href="<?php echo BASEURL.'/demandeur/modif/'.$ligne->get_Id_ligne();?>">
									  				<div id="tt<?php echo $i ?>" class="icon material-icons" style="margin-left: 40%;">edit</div>
									  				<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">
									  				Modifier
									  				</div>
									  		    </a>
									  		</td>

									  	
									  </tr>
								  <?php } ?>
								</tbody>
							</table>
					    </div>
					    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
					      <button type="button" class="mdl-button close"><div id="tt<?php echo $i ?>" class="icon material-icons">cancel</div> Revenir aux notes de frais</button>
					    </div>
					  </dialog>
<script>
    var dialog = document.querySelector('dialog');
    var showModalButton = document.querySelector('.show-modal');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    showModalButton.addEventListener('click', function() {

      dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {
      dialog.close();
    });
  </script>








  <!-- List items with avatar and action -->
<style>
.demo-list-action {
  width: 300px;
}
</style>