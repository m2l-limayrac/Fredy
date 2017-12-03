<?php

//
// Formulaire pour les connexions
//
?>
<!-- Simple Textfield -->
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="AdresseMail" type="text" id="sample1" value="<?php echo $demandeur->get_AdresseMail(); ?>">
    <label class="mdl-textfield__label" for="sample1">AdresseMail</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="MotDePasse" type="password" id="sample2" value="<?php echo $demandeur->get_MotDePasse(); ?>">
    <label class="mdl-textfield__label" for="sample1">MotDePasse</label>
  </div>
  <!-- Icon button -->
<!-- Colored raised button -->
<br>
<button type="submit" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
  connexion
</button>

</form>
