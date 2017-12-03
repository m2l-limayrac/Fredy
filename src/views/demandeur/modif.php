<?php
//
// Vue "Connexion d'un utilisateur"
//
?>

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
	</tbody>
</table>