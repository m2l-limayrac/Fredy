<?php
//
// Vue "Connexion d'un utilisateur"
//
?>
<style type="text/css">
	.Id_ligne{
		width: 44px;
	}
	.Date{
		width: 90px;
	}
	.KM{
		width: 44px;
	}
	.Trajet{
		width: 150px;
	}
	.Motif{
		width: 72px;
	}
	.mdl-data-table th{
		text-align: center;
	}
	.ajust{
		margin-left: -4%;
	}
	.disable-links {
    	pointer-events: none;
	}
</style>
<form action="<?php echo BASEURL.'/'.$action.'/' ?>" method="post">
	<table class="mdl-data-table mdl-js-data-table mdl-data-table mdl-shadow--2dp ajust">
		<thead>
			<tr>
				<th class="mdl-data-table__cell--non-numeric">ligne de frais</th>
				<th>Date</th>
				<th>Km</th>
				<th>Cout du Peage</th>
				<th>Cout du Repas</th>
				<th>Cout de l'hebergement</th>
				<th>Trajet</th>
				<th>Année</th>
				<th>Motif</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		      <tr>

					<td style="text-align: center;">
						<i class="material-icons">input</i>
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield Date">
					    	<input class="mdl-textfield__input" name="Date" type="text" id="datepicker" value="">
					    	<label class="mdl-textfield__label" for="datepicker">Date..</label>
					  	</div>
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield KM">
						    <input class="mdl-textfield__input" name="Km" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="sample2" value="">
						    <label class="mdl-textfield__label" for="sample2">Km..</label>
						    <span class="mdl-textfield__error">Ce n'est pas un chiffre</span>
					  	</div>
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield KM">
						    <input class="mdl-textfield__input" name="CoutPeage" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="sample3" value="">
						    <label class="mdl-textfield__label" for="sample3">Cout Peage..</label>
						    <span class="mdl-textfield__error">Ce n'est pas un chiffre</span>
					  	</div>
			  		      
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield KM">
						    <input class="mdl-textfield__input" name="CoutRepas" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="sample4" value="">
						    <label class="mdl-textfield__label" for="sample4">Cout Repas..</label>
						    <span class="mdl-textfield__error">Ce n'est pas un chiffre</span>
					  	</div>
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield KM">
						    <input class="mdl-textfield__input" name="CoutHebergement" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="sample5" value="">
						    <label class="mdl-textfield__label" for="sample5">Cout Hébergement..</label>
						    <span class="mdl-textfield__error">Ce n'est pas un chiffre</span>
					  	</div>
			  		      
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield Trajet">
					    	<input class="mdl-textfield__input" name="Trajet" type="text" id="sample6" value="">
					    	<label class="mdl-textfield__label" for="sample6">Trajet..</label>
					  	</div>
					</td>
					<td style="text-align: center;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield KM">
					    	<input class="mdl-textfield__input" name="Annee" type="text" id="sample7" value="<?php echo $Annee_actuelle; ?>" readonly>
					    	<label class="mdl-textfield__label" for="sample7">Année..</label>
					  	</div>
					</td>
					<td style="text-align: center;">
				        <div class="mdl-textfield mdl-js-textfield mdl-textfield Motif">
				        	<input type="text" class="mdl-textfield__input" name="Motif" id="sample8" value="" readonly>
				        	<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="sample8">
				        		<?php foreach ($les_motifs as $motif) { ?>
				        		<li class="mdl-menu__item" onclick="onSelect('<?php echo $motif->get_Libelle(); ?>')"><?php echo $motif->get_Libelle(); ?></li>
				        		<?php } ?>
				        	</ul>
				        </div>
					</td>

					<td style="text-align: center;">
			  		    <a class="mdl-list__item-secondary-action" href="#" onclick="avort()">
			  				<div id="tt1" class="icon material-icons">cancel</div>
			  				<div class="mdl-tooltip mdl-tooltip--large" for="tt1">Annuler l'insertion</div>
			  		    </a>
			  		    <span class="disable-links" id="send"><a class="mdl-list__item-secondary-action" href="#" onclick="send()">
			  				<div id="tt2" class="icon material-icons" style="margin-left: 40%;">check</div>
			  				<div class="mdl-tooltip mdl-tooltip--large" for="tt2">
			  				Valider
			  				</div>
			  		    </a></span>
			  		</td>

			  	
			  </tr>
		</tbody>
	</table>
	<input id="submit" type="submit" name="submit" hidden>
</form>


  

<script type="text/javascript">
  $(document).ready(function(){
  	$('#datepicker').datepicker({
  		'dateFormat' : 'yy-mm-dd',
  		'yearRange' : '<?php echo $Annee_actuelle ?>:<?php echo $Annee_actuelle ?>'
  	});
  })
setInterval(function(){
     if(!document.getElementById('datepicker').value || !document.getElementById('sample2').value || !document.getElementById('sample3').value || !document.getElementById('sample4').value || !document.getElementById('sample5').value || !document.getElementById('sample6').value || !document.getElementById('sample8').value){
      document.getElementById('send').setAttribute('class', 'disable-links');
     }else{
      document.getElementById('send').removeAttribute('class');
     }
   }, 200);
function onSelect(value){
	console.log(value);
	document.getElementById('sample8').setAttribute("value", value);
}

function send(){
	document.getElementById('submit').click();
}

function avort(){
	window.location.replace('/Fredy/web/demandeur/details');
}
</script>