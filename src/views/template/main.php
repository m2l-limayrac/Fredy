
<?php 
  
  if(isset($_SESSION['demandeur'])){
    $demandeur = serialize($_SESSION['demandeur']);
    $demandeur = unserialize($demandeur);
  }
  /*echo "<pre>";
  print_r($demandeur);
  echo "</pre>";*/
?>

<!doctype html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="fr">
  <head>
    <script src="<?php echo MYINCLUDE ?>/jquery.min1.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>/js/jquery-ui/jquery-ui.min.css">
    <script type="text/javascript" src="<?php echo BASEURL ?>/js/jquery-ui/jquery-ui.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?php echo APPLINAME; ?></title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- <link rel="icon" sizes="192x192" href="<?php echo IMG ?>/Fredy.png"> -->
    <link rel="icon" sizes="192x192" href="<?php echo IMG ?>/Fredi.jpg">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Fredi">
    <!-- <link rel="apple-touch-icon-precomposed" href="<?php echo IMG ?>/Fredy.png"> -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo IMG ?>/Fredi.jpg">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="<?php echo IMG ?>/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- <link rel="shortcut icon" href="<?php echo IMG ?>/Fredy.png"> -->
    <link rel="shortcut icon" href="<?php echo IMG ?>/Fredi.jpg">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet" href="<?php echo MYINCLUDE ?>/css2.css">
    <link rel="stylesheet" href="<?php echo MYINCLUDE ?>/css3.css" type="text/css">
    <link rel="stylesheet" href="<?php echo MYINCLUDE ?>/icon4.css">
    <link rel="stylesheet" href="<?php echo MYINCLUDE ?>/material.indigo-pink.min5.css">
     <link rel="stylesheet" href="<?php echo MYINCLUDE ?>/material.blue-indigo.min6.css" /> 
    <link rel="stylesheet" href="<?php echo CSS ?>/styles.css">
    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>
  </head>
  <body>
    
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <?php if(isset($demandeur)){ ?>
           <?php if($demandeur->get_isRepresentant()){ ?>
            <span class=\"mdl-layout-title\">Bienvenue <?php echo $demandeur->get_Representant()->get_Nom(); ?> <?php echo $demandeur->get_Representant()->get_Prenom(); ?></span>
          <?php }else{ ?>
            <span class=\"mdl-layout-title\">Bienvenue <?php echo $demandeur->get_Adherent()->get_Nom(); ?> <?php echo $demandeur->get_Adherent()->get_Prenom(); ?></span>
            <?php } ?>
            <div class="mdl-layout-spacer"></div>
            
            <?php if(isset($_GET['url'])){ ?>
              <?php if($_GET['url'] == "Demandeur/details"){ ?>
              <a class="" href="<?php echo BASEURL.'/Demandeur/addNDF' ?>">
                <button id="newNDF" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored ">

                  <i class="material-icons">add</i>
                </button>
                <div class="mdl-tooltip mdl-tooltip--large" for="newNDF">Ajouter une note de frais</div>
              </a>
              <?php } ?>
            <?php } ?>

          <?php }else { ?>
            <span class=\"mdl-layout-title\">Vous n'êtes pas connecter</span>
            <?php } ?>
          </div>
      </header>
      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
         <header class="demo-drawer-header">
          <img src="<?php echo IMG ?>/user.jpg" class="demo-avatar">
          <div class="demo-avatar-dropdown">
          <?php if(isset($demandeur)){ ?>
          <?php if($demandeur->get_isRepresentant()){ ?>
            <span><?php echo $demandeur->get_Representant()->get_Nom(); ?> <?php echo $demandeur->get_Representant()->get_Prenom(); ?></span>
          <?php }else{ ?>
            <span><?php echo $demandeur->get_Adherent()->get_Nom(); ?> <?php echo $demandeur->get_Adherent()->get_Prenom(); ?></span>
            <?php } ?>
            <!-- <div class="mdl-layout-spacer"></div>
            <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
              <i class="material-icons" role="presentation">arrow_drop_down</i>
              <span class="visuallyhidden">Accounts</span>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
              <li class="mdl-menu__item"><a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/settings/'.$demandeur->get_Id_Demandeur() ?>"> parametre du compte</a></li>
              <li class="mdl-menu__item"><a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/logout' ?>">Déconnexion</a></li>
            </ul> -->
            <?php }else{ ?>
            <span>Non connecté</span>
            <?php } ?>
          </div>
        </header> 
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">


          <?php if(isset($demandeur)){ ?>
          
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/details' ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">details</i>Detail des notes de frais</a>
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/addNDF' ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">add</i>Ajouter une note de frais</a>
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/settings/'.$demandeur->get_Id_Demandeur() ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Parametre du compte</a>
            <?php if($demandeur->get_isRepresentant()){ ?>
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/settingsAdherents/'.$demandeur->get_Id_Demandeur() ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Parametre des Adherents</a>
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Adherent/ajout/'?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person_add</i>Ajouter un Adherent mineur </a>
           <?php } ?>

            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/logout' ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">eject</i>Déconnexion</a>
        
          <?php }else{ ?>
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/login' ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Se connecter</a>
            <a class="mdl-navigation__link" href="<?php echo BASEURL.'/Demandeur/register' ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person_add</i>S'inscrire</a>
          
            <?php } ?>


        </nav>
      </div>
      

    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
           <!-- <?php //echo Flash::show(); ?> -->
        <?php echo $content; ?>
        
        </div>
      </main>
    </div>
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" style="position: fixed; left: -1000px; height: -1000px;">
        <defs>
          <mask id="piemask" maskContentUnits="objectBoundingBox">
            <circle cx=0.5 cy=0.5 r=0.49 fill="white" />
            <circle cx=0.5 cy=0.5 r=0.40 fill="black" />
          </mask>
          <g id="piechart">
            <circle cx=0.5 cy=0.5 r=0.5 />
            <path d="M 0.5 0.5 0.5 0 A 0.5 0.5 0 0 1 0.95 0.28 z" stroke="none" fill="rgba(255, 255, 255, 0.75)" />
          </g>
        </defs>
      </svg>
      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 250" style="position: fixed; left: -1000px; height: -1000px;">
        <defs>
          <g id="chart">
            <g id="Gridlines">
              <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="27.3" x2="468.3" y2="27.3" />
              <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="66.7" x2="468.3" y2="66.7" />
              <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="105.3" x2="468.3" y2="105.3" />
              <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="144.7" x2="468.3" y2="144.7" />
              <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="184.3" x2="468.3" y2="184.3" />
            </g>
            <g id="Numbers">
              <text transform="matrix(1 0 0 1 485 29.3333)" fill="#888888" font-family="'Roboto'" font-size="9">500</text>
              <text transform="matrix(1 0 0 1 485 69)" fill="#888888" font-family="'Roboto'" font-size="9">400</text>
              <text transform="matrix(1 0 0 1 485 109.3333)" fill="#888888" font-family="'Roboto'" font-size="9">300</text>
              <text transform="matrix(1 0 0 1 485 149)" fill="#888888" font-family="'Roboto'" font-size="9">200</text>
              <text transform="matrix(1 0 0 1 485 188.3333)" fill="#888888" font-family="'Roboto'" font-size="9">100</text>
              <text transform="matrix(1 0 0 1 0 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">1</text>
              <text transform="matrix(1 0 0 1 78 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">2</text>
              <text transform="matrix(1 0 0 1 154.6667 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">3</text>
              <text transform="matrix(1 0 0 1 232.1667 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">4</text>
              <text transform="matrix(1 0 0 1 309 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">5</text>
              <text transform="matrix(1 0 0 1 386.6667 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">6</text>
              <text transform="matrix(1 0 0 1 464.3333 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">7</text>
            </g>
            <g id="Layer_5">
              <polygon opacity="0.36" stroke-miterlimit="10" points="0,223.3 48,138.5 154.7,169 211,88.5
              294.5,80.5 380,165.2 437,75.5 469.5,223.3   "/>
            </g>
            <g id="Layer_4">
              <polygon stroke-miterlimit="10" points="469.3,222.7 1,222.7 48.7,166.7 155.7,188.3 212,132.7
              296.7,128 380.7,184.3 436.7,125   "/>
            </g>
          </g>
        </defs>
      </svg>
    <script src="<?php echo MYINCLUDE ?>/material.min7.js"></script>
  </body>
</html>

<!-- ligne a supprimmer lors de la mise en production -->
