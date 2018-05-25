<?php
//
// top14server - Serveur web service RESTful
//
// Fonctions pour l'application

/**
 * Construit une chaîne JSON à partir d'un tableau PHP
 * @param string $message
 * @param string $token
 * @param array $clubs
 * @return string
 */
function build_json($lesLignes,$token) {
    
  $tableau = array(
    "lesLignes" => $lesLignes,
    "token" => $token,
);
$json = json_encode($tableau);
return $json;
}

/**
 * Envoie une réponse HTTP en JSON
 * @param string $json
 * TODO : envoyer une status code HTTP
 */
function send_json($json) {
  header("Content-type: application/json; charset=utf-8");
  echo $json;
}

/**
 * Ajoute un token dans le fichier des tokens
 * @param string $token
 */
function add_token($token) {
   file_put_contents(TOKEN_FILENAME,$token.PHP_EOL,FILE_APPEND);  
}

/**
 * Lit le fichier des tokens dans un tableau PHP
 * @return array
 */
function get_tokens() {
  $tableau = array();
  if (file_exists(TOKEN_FILENAME)) {
    $tableau = file(TOKEN_FILENAME,FILE_IGNORE_NEW_LINES);
  }
  return $tableau;
}