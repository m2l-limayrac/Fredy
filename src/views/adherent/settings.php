<?php
$i=1;
?>




<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="numLicence" type="text" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_numLicence(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">numLicence</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Nom" type="text" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_Nom(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Nom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Prenom" type="text" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_Prenom(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Prenom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input class="mdl-textfield__input" name="DateNaissance" type="text" id="datepicker" value="<?php echo $adherent->get_DateNaissance(); ?>">
    <label class="mdl-textfield__label" for="datepicker">DateNaissance..</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="AdresseAdh" type="text" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_AdresseAdh(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">AdresseAdh</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="CP" type="text" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_CP(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">CP</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Ville" type="text" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_Ville(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Ville</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input type="text" class="mdl-textfield__input" name="Sexe" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_Sexe(); ?>" readonly >
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="sample<?php echo $i; ?>">
      <li class="mdl-menu__item" onclick="onSelect('M', '<?php echo 'sample'.$i; ?>')">Masculin</li>
      <li class="mdl-menu__item" onclick="onSelect('F', '<?php echo 'sample'.$i;  $i++; ?>')">Feminin</li>
    </ul>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input type="text" class="mdl-textfield__input" name="Club" id="sample<?php echo $i; ?>" value="<?php echo $adherent->get_Club()->get_Nom(); ?>" readonly >
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="sample<?php echo $i; ?>">
      <?php foreach ($Clubs as $club) { ?>
      <li class="mdl-menu__item" onclick="onSelect('<?php echo $club->get_Nom() ?>', '<?php echo 'sample'.$i; ?>')"><?php echo $club->get_Nom() ?></li>
      <?php } ?>
    </ul>
  </div>

<br>


<button type="submit" name="submit" id="sub" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" disabled>
  valider
</button>

</form>
<script type="text/javascript">



  $(document).ready(function(){
    $('#datepicker').datepicker({
      'dateFormat' : 'yy-mm-dd'
    });

    setInterval(function(){
     if(!document.getElementById('sample2').value){
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