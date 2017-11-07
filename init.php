<?php
//
// Initialisation de l'application (version avec DAO)
//

include 'inc/Class/Motif.php';
include 'inc/Class/MotifDAO.php';



/*$produitDAO = new produitDAO();*/
$MotifDAO = new motifDAO();

// Création de la liste des établissements
$les_motif = $MotifDAO->findAll();
