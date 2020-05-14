
        <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->	
		    <!--                              NAVBAR                                   -->
		    <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->         
       
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url('Visiteur/accueil') ?>"><img src="<?php echo base_url(); ?>assets/images/accueil.png" height="25" width="25"></a>
        </div>
          <ul class="nav navbar-nav">

            <!--visiteur-->
            
            <li>
              <a href="<?php echo site_url('Visiteur/catalogueEvenement') ?>"><i class="glyphicon  glyphicon-book"></i>&nbsp;Nos Evenements</a>
            </li>
            <li>
            <a href="<?php echo site_url('Visiteur/panier') ?>"><i class="glyphicon glyphicon-shopping-cart"></i><span><?php echo $this->cart->total_items(); ?></span>Panier</a>
            </li>
          
            <?php if ($this->session->profil=='membre') : ?>
              
                
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-cog"></i>&nbsp;Gestion compte
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo site_url('Membre/InfosCompte') ?>">Gérer votre compte</a>
                    </li>&nbsp;&nbsp;
                    <li>
                      <a href="<?php echo site_url('Membre/ModificationMdp') ?>">Modifier votre mot de passe</a>
                    </li> &nbsp;
                    <li>
                      <a href="<?php echo site_url('Membre/Actif') ?>">Se désinscrire de la newsletter</a>
                    </li>&nbsp;
                  </ul>
                </li> 
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-envelope"></i>&nbsp;Réclamation<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo site_url('Visiteur/problemGeneral') ?>">Signaler un problème</a>
                    </li>
                  </ul>
                </li>   
              <?php endif; ?>
           

            <!--administrateur-->

            <?php if ($this->session->profil=='admin') : ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion compte
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="<?php echo site_url('Membre/InfosCompte') ?>">Gérer votre compte</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('Membre/ModificationMdp') ?>">Modifier votre mot de passe</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion des évènements
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
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Suivi administratif
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
                  <li>
                    <a href="<?php echo site_url('Administrateur/modifierClasse') ?>">Gestion des classes</a>
                  </li>
                  <li>
                    <a href="<?php echo site_url('Administrateur/changerLEtatDunEvenement') ?>">activer desactiver un evenement</a>
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
                <a href="<?php echo site_url('Visiteur/seConnecter') ?>">Connexion</a>                    
              </li>  
            <?php }elseif ($this->session->userdata('email') == True) { ?>
              <li>
                <a href="<?php echo site_url('Visiteur/seDeConnecter') ?>">Déconnexion</a>
              </li>
            <?php } ?>
          </ul>            
      </div>
    </nav>
    </br>
    </br>