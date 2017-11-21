<?php

//
// Vue "Détails d'un adherent"
//
echo '<h2>Détails de l\'adherent ' . $adherent->get_login() . '</h2>';
echo '<p>Revenir à la <a href="' . BASEURL . '/adherent/index">[liste]</a> des adherents</p>';
echo '<ul>';
echo '<li>ID : ' . $adherent->get_id_adherent() . '</li>';
echo '<li>login : ' . $adherent->get_login() . '</li>';
echo '<li>password : ' . $adherent->get_password() . '</li>';
echo '<li>Administrateur : ' . $adherent->get_lib_is_admin() . '</li>';
echo '</ul>';
