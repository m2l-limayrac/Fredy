<?php
//
// top14server - Serveur web service RESTful
//
// Authentifie un client Android et renvoie une réponse JSON
// Exemple : http://192.168.26.1/Fredy/API/login.php?user=jef&password=jefjef
include "./inc/ini.inc.php";
//require_once "../src/config/init.php";



// Récupère les paramètres dans l'URL
$user = isset($_GET["user"]) ? $_GET["user"] : "";
$password = isset($_GET["password"]) ? $_GET["password"] : "";
var_dump($user);
// Vérifie si le user existe
if (isset($user) && isset($password)) {
	if($user != "" && $password != ""){
		$demandeurDAO = new DemandeurDAO();
		$demandeur = $demandeurDAO->findAllByMail($user);
		$demandeur->set_MotDePasse($password);
		if(Auth::connecter($demandeur)){
			$message = "user authentifié";
		 // Crée un token aléatoire (<PHP7)
		 $token = bin2hex(openssl_random_pseudo_bytes(15));
		 // Ajoute le token au fichier des tokens
		 add_token($token);
		}else{
			$message = "nope";
			$token = null;
		}
	}  
} else {
  $message = "user non authentifié";
  $token = null;
}

// Construit le format JSON
$json = build_json($message, $token, NULL);
// Envoie la réponse 
send_json($json);