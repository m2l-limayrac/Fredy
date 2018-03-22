<?php
//
// top14server - Serveur web service RESTful
//
// Retourne la liste des clubs sous la forme d'un fichier JSON
// Exemples : 
// http://192.168.26.1/Fredy/API/clubs.php?token=c4c662e16b163a7824ef7522e45cc2
// ou
// http://localhost/projets/top14server/clubs.php?user=jef&password=jefjef
include "inc/ini.inc.php";

// Récupère le token s'il existe
$token = isset($_GET['token']) ? $_GET['token'] : NULL;
// Récupère les paramètres de connexion s'ils existent
$user = isset($_GET["user"]) ? $_GET["user"] : "";
$password = isset($_GET["password"]) ? $_GET["password"] : "";

// Authentification
// S'il existe, cherche le token dans le fichier des tokens
$authentifie = FALSE;
if ($token) {
  $tokens = get_tokens();  // Lit le fichier des tokens
  if (in_array($token, $tokens)) {
    $authentifie = TRUE;
  }
}

// S'ils existent, cherche le user et le mot de passe
if (isset($users[$user]) && $password == $users[$user]) {
  $authentifie = TRUE;
  // Crée un token aléatoire (<PHP7)
  $token = bin2hex(openssl_random_pseudo_bytes(15));
  // Ajoute le token au fichier des tokens
  add_token($token);
}

// Si authentifié, fournit la liste des clubs
if ($authentifie) {
  foreach ($noms as $cle => $valeur) {
    // Crée un tableau PHP pour chaque équipe
    $club = array(
        "id" => $cle,
        "nom" => $valeur,
        "couleurs" => $couleurs[$cle],
        "stade" => $stades[$cle],
        "ecusson" => $ecussons[$cle] . ".png",
        "classement" => $classements[$cle]
    );
    // Convertit le tableau en objet (JSON) et construit un nouveau tableau rassemblant toutes les équipes
    $clubs[] = (object) $club;
  }
  $message = count($clubs) . " equipe(s)";
} else {
  $message = "user non authentifié";
  $clubs = NULL;
}

// Construit le format JSON
$json = build_json($message, $token, $clubs);
// Envoie la réponse 
send_json($json);