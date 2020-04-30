
        <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->	
		    <!--                              NAVBAR                                   -->
		    <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->         
      
  <body>  
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url('visiteur/accueil') ?>"><img src="<?php echo base_url(); ?>assets/images/accueil.png" height="25" width="25"></a>
        </div>
          <ul class="nav navbar-nav">

            <!--visiteur-->
            
            <li>
              <a href="<?php echo site_url('visiteur/catalogueEvenement') ?>">Nos Evenements</a>
            </li>
            <li>
                <a href="<?php echo site_url('visiteur/catalogueProduits') ?>">Nos Produits disponibles</a>
            </li>
            <?php if ($this->session->profil=='membre') : ?>
              
                
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion compte<!--lien activation des evenement-->
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo site_url('membre/InfosCompte') ?>">Gérer votre compte</a>
                    </li>&nbsp;&nbsp;
                    <li>
                      <a href="<?php echo site_url('membre/ModificationMdp') ?>">Modifier votre mot de passe</a>
                    </li> &nbsp;
                    <li>
                      <a href="<?php echo site_url('membre/Actif') ?>">Se désinscrire de la newsletter</a>
                    </li>&nbsp;
                  </ul>
                </li>   
              <?php endif; ?>
           

            <!--administrateur-->

            <?php if ($this->session->profil=='admin') : ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion compte<!--lien activation des evenement-->
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="<?php echo site_url('membre/InfosCompte') ?>">Gérer votre compte</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('visiteur/ModificationMdp') ?>">Modifier votre mot de passe</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion des évènements<!--lien activation des evenement-->
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="<?php echo site_url('Administrateur/ajouterEvenement') ?>">Ajouter un Evenement</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('Administrateur/modifierEvenement') ?>">Modifier un Evenement</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('Administrateur/ajouterProduit') ?>">Ajouter un Produit</a>
                  </li>
		              <li>
                    <a href="<?php echo site_url('Administrateur/modifierProduit') ?>">Modifier un Produit</a>
                  </li>
                </ul>
              </li> 
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Suivi des évènements
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="<?php echo site_url('Administrateur/selectionCommande') ?>">Recapitulatif des commandes</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('Administrateur/formulaireMail') ?>">Envoyer un mail</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('Administrateur/afficherProbleme') ?>">Gestion des problemes d'administration</a>
                  </li>
                  <!-- accuser de reception a faire -->
                  <!-- relance mail-->                  
                </ul>
              </li>
            <?php endif; ?>
          </ul>
              
        <!-- commun-->

          <ul class="nav navbar-nav navbar-right">
            <?php if ($this->session->userdata('email') == False) {?>
              <li>
                <a href="<?php echo site_url('visiteur/seConnecter') ?>">Connexion</a>                    
              </li>  
            <?php }elseif ($this->session->userdata('email') == True) { ?>
              <li>
                <a href="<?php echo site_url('visiteur/seDeConnecter') ?>">Déconnexion</a>
              </li>
            <?php } ?>
          </ul>            
      </div>
    </nav>
    </br>
    </br>