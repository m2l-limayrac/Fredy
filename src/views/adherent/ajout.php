<?php
$i=1;
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
<div id="isAdherent">
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="numLicence" type="text" id="Asample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">numLicence</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Nom" type="text" id="Asample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">Nom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Prenom" type="text" id="Asample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">Prenom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input class="mdl-textfield__input" name="DateNaissance" type="text" id="datepicker" value="">
    <label class="mdl-textfield__label" for="datepicker">DateNaissance..</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="AdresseAdh" type="text" id="Asample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">AdresseAdh</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="CP" type="text" id="Asample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">CP</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Ville" type="text" id="Asample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">Ville</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input type="text" class="mdl-textfield__input" name="Sexe" id="Asample<?php echo $i; ?>" value="" readonly >
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="Asample<?php echo $i; ?>">
      <li class="mdl-menu__item" onclick="onSelect('M', '<?php echo 'Asample'.$i; ?>')">M</li>
      <li class="mdl-menu__item" onclick="onSelect('F', '<?php echo 'Asample'.$i; ?>')">F</li>
    </ul>
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">Sexe</label>

  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input type="text" class="mdl-textfield__input" name="Id_Club" id="Asample<?php echo $i; ?>" value="" readonly >
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="Asample<?php echo $i; ?>">
      <?php foreach ($Clubs as $club) { ?>
      <li class="mdl-menu__item" onclick="onSelect('<?php echo $club->get_Nom() ?>', '<?php echo 'Asample'.$i; ?>')"><?php echo $club->get_Nom() ?></li>
      <?php } ?>
    </ul>
    <label class="mdl-textfield__label" for="Asample<?php echo $i; $i++; ?>">Club</label>
  </div>
  <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
    <input type="checkbox" id="switch-1" name="otherInsert" class="mdl-switch__input" checked>
    <span class="mdl-switch__label">Je veux inserer un autre Adherent</span>
  </label>
</div>
<br>
<button type="submit" name="submit" id="sub" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" disabled>
  valider
</button>

</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('#datepicker').datepicker({
      'dateFormat' : 'yy-mm-dd',
      'changeYear': true,
      'yearRange' : '-18:+0'
    });
    
    var divRepresentant = document.getElementById('isRepresentant');
    var divAdherent = document.getElementById('isAdherent');

    setInterval(function(){
      if(!document.getElementById('Asample1').value || !document.getElementById('Asample2').value || !document.getElementById('Asample3').value || !document.getElementById('datepicker').value || !document.getElementById('Asample4').value || !document.getElementById('Asample5').value || !document.getElementById('Asample6').value || !document.getElementById('Asample7').value){

        document.getElementById('sub').setAttribute('disabled', 'disabled');
       }else{
        document.getElementById('sub').removeAttribute('disabled');
       }
   }, 200);

  });

  function onSelect(value, sample){
    console.log(sample);
    document.getElementById(sample).setAttribute("value", value);
  }
</script>
