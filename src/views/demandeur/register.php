<?php
$i=1;
?>
<form action="<?php echo BASEURL.'/'.$action; ?>" method="post">
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="AdresseMail" type="email" id="sample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">AdresseMail</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="MotDePasse" type="password" id="sample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">MotDePasse</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" type="password" id="pass2" value="">
    <label class="mdl-textfield__label" for="pass2">MotDePasse</label>
  </div>
  <p id="diff" style="display: none; color: #ff0000">Les mots de passe sont diferents</p>
  <!-- Icon button -->
<!-- Colored raised button -->
<br>
<div class="mdl-textfield mdl-js-textfield mdl-textfield">
  <input type="text" class="mdl-textfield__input" name="Id_Club" id="sample<?php echo $i; ?>" value="" readonly >
  <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="sample<?php echo $i; ?>">
    <?php foreach ($Clubs as $club) { ?>
    <li class="mdl-menu__item" onclick="onSelect('<?php echo $club->get_Nom() ?>', '<?php echo 'sample'.$i; ?>')"><?php echo $club->get_Nom() ?></li>
    <?php } ?>
  </ul>
  <label class="mdl-textfield__label" for="sample<?php echo $i; $i++; ?>">Club</label>
</div>
<p>Je suis un :</p>
<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="radio1">
    <input type="radio" id="radio1" class="mdl-radio__button" name="isRepresentant" value="1" checked>
    <span class="mdl-radio__label">Representant</span>
</label>
<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="radio2">
    <input type="radio" id="radio2" class="mdl-radio__button" name="isRepresentant" value="0">
    <span class="mdl-radio__label">Adherent</span>
</label>

<br>
<div id="isRepresentant">
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="NomR" type="text" id="Rsample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Rsample<?php echo $i; $i++; ?>">Nom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="PrenomR" type="text" id="Rsample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Rsample<?php echo $i; $i++; ?>">Prenom</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="RueR" type="text" id="Rsample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Rsample<?php echo $i; $i++; ?>">Rue</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="CpR" type="text" id="Rsample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Rsample<?php echo $i; $i++; ?>">Cp</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" name="VilleR" type="text" id="Rsample<?php echo $i; ?>" value="">
    <label class="mdl-textfield__label" for="Rsample<?php echo $i; $i++; ?>">Ville</label>
  </div>
  <br>
</div>


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
    
    var divRepresentant = document.getElementById('isRepresentant');
    var divAdherent = document.getElementById('isAdherent');

    setInterval(function(){
if(document.getElementById('sample2').value == document.getElementById('pass2').value){
            document.getElementById('diff').style.display = "none";
            document.getElementById('diff').style.color = "#ff0000";
         }else{
            document.getElementById('diff').style.display = "";
         }
     if(document.getElementById('radio1').checked){
      $('#datepicker').datepicker("destroy");
      $('#datepicker').removeClass("hasDatepicker");
      if(!document.getElementById('sample1').value ||
       !document.getElementById('sample2').value ||
        !document.getElementById('sample3').value ||
         !document.getElementById('pass2').value ||
          !document.getElementById('radio1').value ||
           !document.getElementById('radio2').value ||
             !document.getElementById('Rsample4').value ||
              !document.getElementById('Rsample5').value ||
               !document.getElementById('Rsample6').value ||
                !document.getElementById('Rsample7').value ||
                 !document.getElementById('Rsample8').value ){

      document.getElementById('sub').setAttribute('disabled', 'disabled');
     }else{
      document.getElementById('sub').removeAttribute('disabled');
     }

      divAdherent.setAttribute('hidden', 'hidden');
      divRepresentant.removeAttribute('hidden', 'hidden');
    }else{
      $('#datepicker').datepicker({
      'dateFormat' : 'yy-mm-dd', 
      'changeYear': true,
      'yearRange' : '-100:-18'
    });
      $('#datepicker').addClass("hasDatepicker");
      $('#datepicker').attr('id', 'datepicker');
      
      if(!document.getElementById('sample1').value ||
       !document.getElementById('sample2').value ||
        !document.getElementById('pass2').value ||
         !document.getElementById('radio1').value ||
          !document.getElementById('radio2').value ||
            !document.getElementById('Asample9').value ||
             !document.getElementById('Asample10').value ||
              !document.getElementById('Asample11').value ||
               !document.getElementById('Asample12').value ||
                !document.getElementById('Asample13').value ||
                 !document.getElementById('Asample14').value ||
                  !document.getElementById('Asample15').value ){

      document.getElementById('sub').setAttribute('disabled', 'disabled');
     }else{
      document.getElementById('sub').removeAttribute('disabled');
     }
     
      divRepresentant.setAttribute('hidden', 'hidden');
      divAdherent.removeAttribute('hidden', 'hidden');
    }
   }, 200);

  });

  function onSelect(value, sample){
  console.log(sample);
  document.getElementById(sample).setAttribute("value", value);
}
</script>
