<?php

//
// Formulaire d'un demandeur
//
$i=1;
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="AdresseMail" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_AdresseMail(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">AdresseMail</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="MotDePasse" type="password" id="sample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">MotDePasse</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" type="password" id="sample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">MotDePasse</label>
  </div>
  <p id="diff" style="display: none; color: #ff0000">Les mots de passe sont diferents</p>
  <!-- Icon button -->
<!-- Colored raised button -->
<br>
<br>
<?php if ($demandeur->get_isRepresentant()) { ?>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Nom" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Representant()->get_Nom(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Nom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Prenom" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Representant()->get_Prenom(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Prenom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Rue" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Representant()->get_Rue(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Rue</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Cp" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Representant()->get_Cp(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Cp</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Ville" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Representant()->get_Ville(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Ville</label>
  </div>
  <br>
<?php }else{ ?>

<!-- <?php// foreach ($demandeur->get_les_adherent() as $adherent) { ?>-->
  
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="numLicence" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_numLicence(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">numLicence</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Nom" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_Nom(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Nom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Prenom" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_Prenom(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Prenom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input class="mdl-textfield__input" name="DateNaissance" type="text" id="datepicker" value="<?php echo $demandeur->get_Adherent()->get_DateNaissance(); ?>">
    <label class="mdl-textfield__label" for="datepicker">DateNaissance..</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="AdresseAdh" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_AdresseAdh(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">AdresseAdh</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="CP" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_CP(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">CP</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="Ville" type="text" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_Ville(); ?>">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Ville</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input type="text" class="mdl-textfield__input" name="Sexe" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Adherent()->get_Sexe(); ?>" readonly >
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="sample<?php echo $i; ?>">
      <li class="mdl-menu__item" onclick="onSelect('M', '<?php echo 'sample'.$i; ?>')">Masculin</li>
      <li class="mdl-menu__item" onclick="onSelect('F', '<?php echo 'sample'.$i;  $i++; ?>')">Feminin</li>
    </ul>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield">
    <input type="text" class="mdl-textfield__input" name="Club" id="sample<?php echo $i; ?>" value="<?php echo $demandeur->get_Club()->get_Nom(); ?>" readonly >
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="sample<?php echo $i; ?>">
      <?php foreach ($Clubs as $club) { ?>
      <li class="mdl-menu__item" onclick="onSelect('<?php echo $club->get_Nom() ?>', '<?php echo 'sample'.$i; ?>')"><?php echo $club->get_Nom() ?></li>
      <?php } ?>
    </ul>
  </div>
  
<!--<?php// } ?> -->
<?php } ?>
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
       if(!document.getElementById('sample2').value || document.getElementById('sample2').value != document.getElementById('sample3').value){
        document.getElementById('sub').setAttribute('disabled', 'disabled');
       }else{
        document.getElementById('sub').removeAttribute('disabled');
       }


       if(document.getElementById('sample2').value == document.getElementById('sample3').value){
            document.getElementById('diff').style.display = "none";
            document.getElementById('diff').style.color = "#ff0000";
         }else{
            document.getElementById('diff').style.display = "";
         }
   }, 200);

  });

  function onSelect(value, sample){
  document.getElementById(sample).setAttribute("value", value);
}
</script>