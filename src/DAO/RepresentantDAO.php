<?php

require_once SRC . DS . 'models' . DS . 'Representant.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'DAO' . DS . 'AdherentDAO.php';
require_once SRC . DS . 'models' . DS . 'Adherent.php';


class RepresentantDAO extends DAO {

  private static $AdherentDAO;

  function find($Id_Demandeur) {

    $sql = "SELECT * FROM representant WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $params = array(":Id_Demandeur" => $Id_Demandeur);
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      if($row != false){
        $representant = new Representant($row);
      }else{
        $representant = new Representant();
      }
      if(SELF::$AdherentDAO == null){
        SELF::$AdherentDAO = new AdherentDAO();
      }
      $representant->set_les_adherents(SELF::$AdherentDAO->findAllByDemandeur($Id_Demandeur));
      return $representant;
  }

  function findAll() {

    $sql = "SELECT * FROM representant;";
      try {
          $sth = $this->executer($sql);
          $sth->execute();
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Representant($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

function insert(Representant $representant){
    //GLOBAL $con;

    $sql = "INSERT INTO representant (Nom, Prenom, Rue, Cp, Ville, id_Demandeur) VALUES (:Nom, :Prenom, :Rue, :Cp, :Ville, :id_Demandeur)";
    try {
        $params = array(':Nom' => $representant->get_Nom(),
                        ':Prenom' => $representant->get_Prenom(),
                        ':Rue' => $representant->get_Rue(),
                        ':Cp' => $representant->get_Cp(),
                        ':Ville' => $representant->get_Ville(),
                        ':id_Demandeur' => $representant->get_id_Demandeur());
        $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
}

  function update(Representant $representant){
    //print_r($representant);
    //GLOBAL $con;
    
    $sql = "UPDATE representant SET Nom = :Nom, Prenom = :Prenom, Rue = :Rue, Cp = :Cp, Ville = :Ville WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $params = array(':Id_Demandeur' => $representant->get_Id_Demandeur(), 
                              ':Nom' => $representant->get_Nom(), 
                              ':Prenom' => $representant->get_Prenom(),
                              ':Rue' => $representant->get_Rue(),
                              ':Cp' => $representant->get_Cp(),
                              ':Ville' => $representant->get_Ville());
          $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
  }
}

?>