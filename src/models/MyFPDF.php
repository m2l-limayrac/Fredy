<?php

//
// Extension de la classe FPDF
//
require_once SRC . DS . 'models' . DS . 'fpdf' . DS . 'fpdf.php';

/**
 * Description of MyFPDF
 *
 * @author jef
 */
class MyFPDF extends FPDF {

  /**
   * Implémentation de l'entête
   */
  function Header() {
    // Date du jour
    $dateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $created = $dateTime->format('d/m/Y');
    $this->SetFont('Arial', '', 8);
    $this->Cell(50, 5, ("PPE"), "B", 0, 'L');
    $this->Cell(90, 5, ("Cerfa"), "B", 0, 'C');
    $this->Cell(50, 5, ($created), "B", 1, 'R');
  }

  /**
   * Implémentation du bas de page
   */
  function Footer() {
    $this->SetY(-15);
    $this->SetFont('Arial', '', 8);
    $this->Cell(50, 5, ("Institut Limayrac - Pinet, Lapeze, Roussel"), "T", 0, 'L');
    $this->Cell(90, 5, ("Note de frais.pdf"), "T", 0, 'C');
    $this->Cell(50, 5, ("Page " . $this->PageNo()), "T", 1, 'R');
  }


  function ImprovedTable($header, $lignes,$indemnite)
  {

      // Largeurs des colonnes
      $w = array(19, 31, 28, 19,19,18,16,26,17);
      // En-tête
      for($i=0;$i<count($header);$i++)
          $this->Cell($w[$i],7,$header[$i],1,0,'C');


      $this->Ln();
      // Données
      $this->SetFont('Arial', '', 9);

      $totalT =0;
      foreach($lignes as $ligne)
      {
          $this->Cell($w[0],10,c($ligne->get_Date()),'LR');;
          $this->Cell($w[1],10,c($ligne->get_Motif()),'LR');;
          $this->Cell($w[2],10,c($ligne->get_Trajet()),'LR');;
          $this->Cell($w[3],10,$ligne->get_Km(),'LR');;
          $coutTrajet = $ligne->get_Km()*$indemnite->get_tarifKilometrique();
          $this->Cell($w[4],10,$coutTrajet,'LR');; // cout trajet
          $this->Cell($w[5],10,$ligne->get_CoutPeage(),'LR');;
          $this->Cell($w[6],10,$ligne->get_CoutRepas(),'LR');;
          $this->Cell($w[7],10,$ligne->get_CoutHebergement(),'LR');;
          $total = $coutTrajet+$ligne->get_CoutPeage()+$ligne->get_CoutRepas()+$ligne->get_CoutHebergement();
          $this->Cell($w[8],10,$total,'LR');;
          $totalT = $totalT+$total;
          $this->Ln();
      }
          $this->Cell(array_sum($w),0,'','T');
          $this->Ln();

          $width = $w[8];
          $height = 10;
          $this->setX(186);
          $y = $this->getY(0);
          $this->Cell($width,$height, $totalT,1);
          $this->Cell($width,$height, $totalT,1);

          
          $this->setY($y + $height);
    
     
  }
}