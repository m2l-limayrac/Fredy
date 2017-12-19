	<!-- Wide card with share menu button -->
	<style>
	.demo-card-wide.mdl-card {
	    width: 724px;
	    margin-left: 19%;
	    margin-top: 4%;
	}
	.demo-card-wide > .mdl-card__title {
	  color: #0084FF;
	  height: 500px;
	  /* background: url('<?php echo IMG ?>/Fredy.png') center / cover;  */
	  background: url('<?php echo IMG ?>/Fredi.jpg') center / cover; 

	}
	.demo-card-wide > .mdl-card__menu {
	  color: #fff;
	}
	</style>

	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
	  <div class="mdl-card__title">
	  </div>
	  <div class="mdl-card__supporting-text">
	    <p>Bienvenue sur le Fredi ! cliquer pour vous connecter</p>
	  </div>
	  <div class="mdl-card__actions mdl-card--border"> 
	    <a href="<?php echo BASEURL ?>/demandeur/login" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
	      Se connecter
	    </a>
	    <a href="<?php echo BASEURL ?>/demandeur/register" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
	      S'inscrire
	    </a>
	  </div>
	</div>