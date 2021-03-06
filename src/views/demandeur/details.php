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
.first {
	margin-left: 25%;
}
</style>

<!-- List items with avatar and action -->
<style>

.demo-list-action {width: 300px;}
.MDF{width: 86%;}
.mdl-data-table th{text-align: center;}
.ajouter{margin-top: 2%;}

</style>
<pre>
	<?//php print_r($demandeur); 
	//print_r(get_defined_vars());
	?>
	<?php $note = null; $i = 1; $modal = 1; $notes = $demandeur->get_les_notes(); ?>
</pre>
<?php if($notes != null){ ?>
<div class="global">
<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp first">
	<thead>
		<tr>
			<th class="mdl-data-table__cell--non-numeric">Note de frais</th>
			<th class="mdl-data-table__cell--non-numeric">Numero</th>
			<th>Annee</th>
			<th>détail de la note</th>
			<th>Generer PDF</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($demandeur->get_les_notes() as $note) { ?>
		<tr >
			<div class="demo-list-action mdl-list">
				<td>
					<i class="material-icons">toc</i>
				</td>
				<td>
					<span><?php echo $note->get_Id_NoteDeFrais() ?></span>
				</td>
				<td>
					<?php echo $note->get_les_lignes()[0]->get_Annee(); ?>
				</td>
				<td class="show-modal<?php echo $modal; ?>">
					<a class="mdl-list__item-secondary-action show-modal" href="#">
						<div id="tt<?php echo $i ?>" class="icon material-icons">chevron_right</div>
						<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Voir les lignes de frais</div>
					</a>
				</td>
				<td>
					<a class="mdl-list__item-secondary-action show-modal" target="_blank" href="<?php echo BASEURL.'/Demandeur/ndf_pdf/'.$demandeur->get_Id_demandeur().'/'.$note->get_Id_NoteDeFrais();?>">
						<div id="tt<?php echo $i ?>" class="icon material-icons">picture_as_pdf</div>
						<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Generer votre PDF</div>
				    </a>							
				</td>
			</div>
		</tr>
		<?php 
		$i++; $modal++; } $modal = 1;
		?>
	</tbody>
</table>

<?php foreach ($demandeur->get_les_notes() as $note) { ?>
<dialog id="dialog<?php echo $modal ?>" class="mdl-dialog MDF">
	<div class="mdl-dialog__title">Note de frais de <?php echo $note->get_les_lignes()[0]->get_Annee(); ?></div>
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
					<?php if(!$note->get_boolIsValidate()) { ?> <th>Actions</th> <?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($note->get_les_lignes() as $ligne) { ?>
				<tr>
					<div class="demo-list-action mdl-list">

						<td style="text-align: center;">
							<i class="material-icons">input</i>
						</td>
						<td style="text-align: center;">
							<p><?php echo $ligne->get_Id_ligne() ?></p>
						</td>
						<td style="text-align: center;">
							<p><?php echo $ligne->get_Date() ?></p>
						</td>
						<td style="text-align: center;">
							<p><?php echo $ligne->get_Km() ?>Km</p>
						</td>
						<td style="text-align: center;">
							<p><?php if($ligne->get_CoutPeage() != ""){echo $ligne->get_CoutPeage(); } else{ echo "0";} ?>€</p> 
						</td>
						<td style="text-align: center;">
							<p><?php if($ligne->get_CoutRepas() != ""){echo $ligne->get_CoutRepas(); } else{ echo "0";} ?>€</p>
						</td>
						<td style="text-align: center;">
							<p><?php if($ligne->get_CoutHebergement() != ""){echo $ligne->get_CoutHebergement(); } else{ echo "0";} ?>€</p>
						</td>

						<td style="text-align: center;">
							<p><?php echo $ligne->get_Trajet() ?></p>
						</td>
						<td style="text-align: center;">
							<p><?php echo $ligne->get_Motif() ?></p>
						</td>
						<?php if(!$note->get_boolIsValidate()) { ?>
							<td style="text-align: center;">
								<a class="mdl-list__item-secondary-action" href="#" onclick="confirme(<?php echo $ligne->get_Id_ligne(); ?>)">
									<div id="tt<?php echo $i ?>" class="icon material-icons">delete</div>
									<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Supprimmer</div>
								</a>
							
								<a class="mdl-list__item-secondary-action" href="<?php echo BASEURL.'/Demandeur/modif/'.$ligne->get_Id_ligne();?>">
									<div id="tt<?php echo $i ?>" class="icon material-icons" style="margin-left: 40%;">edit</div>
									<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">
										Modifier
									</div>
								</a>
							</td>
						<?php } ?>
					</div>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php if(!$note->get_boolIsValidate()) { ?>
			<a class="mdl-list__item-secondary-action" href="<?php echo BASEURL.'/Demandeur/add/'.$note->get_Id_NoteDeFrais(); ?>">
				<button id="tt<?php echo $i ?>" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored ajouter">
					<i class="material-icons">add</i>
				</button>
				<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Ajouter une ligne de frais</div>
			</a>
			<a class="mdl-list__item-secondary-action" href="<?php echo BASEURL.'/Demandeur/validate/'.$note->get_Id_NoteDeFrais(); ?>">
				<button id="tt<?php echo $i ?>" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored ajouter">
					<i class="material-icons">check_circle</i>
				</button>
				<div class="mdl-tooltip mdl-tooltip--large" for="tt<?php echo $i; $i++; ?>">Valider la note de frais</div>
			</a>
		<?php } ?>
	</div>
	<div class="mdl-dialog__actions mdl-dialog__actions--full-width">
		<button type="button" class="mdl-button close"><div id="tt<?php echo $i ?>" class="icon material-icons">cancel</div> Revenir aux notes de frais</button>
	</div>
</dialog>
<?php $modal++; } $modal = 1; ?>
<?php }else{ ?>
<p>Aucune note de frais en cours</p>
<?php } ?>
</div>
<script>

	<?php foreach ($demandeur->get_les_notes() as $note) { ?>

		var dialog<?php echo $modal ?> = document.getElementById('dialog<?php echo $modal ?>');

		var showModalButton<?php echo $modal; ?> = document.querySelector('.show-modal<?php echo $modal; ?>');
		if (! dialog<?php echo $modal ?>.showModal) {
			dialogPolyfill.registerDialog(dialog<?php echo $modal ?>);
		}
		showModalButton<?php echo $modal; ?>.addEventListener('click', function() {

			dialog<?php echo $modal ?>.showModal();
		});
		dialog<?php echo $modal ?>.querySelector('.close').addEventListener('click', function() {
			dialog<?php echo $modal ?>.close();
		});

		<?php $modal++; } $modal = 1; ?>

		function confirme($id_ligne){
			var test = confirm("Etes vous sur de vouloir supprimmer la ligne de frais N° : "+$id_ligne+" ?");
			if(test == true){
				window.location.replace('<?php echo BASEURL ?>/Demandeur/drop_line/'+$id_ligne);
			}
		}
	</script>

	<style>
	.demo-list-action {
		width: 300px;
	}
</style>
