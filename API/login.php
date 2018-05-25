<?php
//
// top14server - Serveur web service RESTful
//
// Authentifie un client Android et renvoie une réponse JSON
// Exemple : http://192.168.150.56/AlexisLapeze/Fredy/API/login.php?user=simon.berbier@gmail.com&password=1234
include "./inc/ini.inc.php";
//require_once "../src/config/init.php";



// Récupère les paramètres dans l'URL
$user = isset($_GET["user"]) ? $_GET["user"] : "";
$password = isset($_GET["password"]) ? $_GET["password"] : "";
// Vérifie si le user existe
if (isset($user) && isset($password)) {
	if($user != "" && $password != ""){
		//$demandeurDAO = new DemandeurDAO();
		//$demandeur = $demandeurDAO->findAllByMail($user);
		$demandeur = new Demandeur();
		$demandeur->set_AdresseMail($user);
		$demandeur->set_MotDePasse($password);
		
		if(Auth::connecter($demandeur)){
		$demandeur = serialize($_SESSION['demandeur']);
      	$demandeur = unserialize($demandeur);
      	/*echo "<pre>";
		print_r($demandeur);
		echo "</pre>";*/
		$trouve = null;
		foreach ($demandeur->get_les_notes() as $note) {
			foreach ($note->get_les_lignes() as $ligne) {
				if($ligne->get_Annee() == date("Y")){
					$myLigne = array(
					  "id_Ligne" => $ligne->get_Id_Ligne(), 
					  "Date" => $ligne->get_Date(), 
					  "Km" => $ligne->get_Km(), 
					  "CoutPeage" => $ligne->get_CoutPeage(),  
					  "CoutRepas" => $ligne->get_CoutRepas(), 
					  "CoutHebergement" => $ligne->get_CoutHebergement(),  
					  "Trajet" => $ligne->get_Trajet(),  
					  "Annee" => $ligne->get_Annee(),    
					  "Motif" => $ligne->get_Motif()  
					);
					$trouve[] = $myLigne;
				}
			}
		}
		if($trouve != null){
			// $lesLignes = array(
			// 	"lesLignes" => $trouve
			// );
			$lesLignes = $trouve;
		}else {
			$lesLignes = "aucune ligne dans l'année courante";
		}
		 // Crée un token aléatoire (<PHP7)
		 $token = bin2hex(openssl_random_pseudo_bytes(15));
		 // Ajoute le token au fichier des tokens
		 add_token($token);
		}else{
			$lesLignes = "nope";
			$token = null;
		}
	}  
} else {
  $lesLignes = "user non authentifié";
  $token = null;
}

// Construit le format JSON
$json = build_json($lesLignes, $token);
// Envoie la réponse 
send_json($json);