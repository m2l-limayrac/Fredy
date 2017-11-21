<?php

//
// Vue "Commenter un billet"
//
?>
<h2>Ajouter un commentaire au billet <?php echo $billet->get_titre(); ?></h2>
<pre>
<?php echo $billet->get_contenu(); ?>
</pre>
<?php require_once SRC.DS.'Forms'.DS.'commentaireForm.php'; ?>
<hr>
<p>Revenir à la <a href="<?php echo BASEURL . '/billet/index';?>">liste</a> des billets</p>
