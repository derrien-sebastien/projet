
        <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->	
		    <!--                              NAVBAR                                   -->
		    <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->         
       
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url('Visiteur/catalogueEvenement') ?>"><img src="<?php echo base_url(); ?>assets/images/accueil.png" height="25" width="25"></a>
        </div>
          <ul class="nav navbar-nav">

            <!--visiteur-->
            <li>
              <a href="<?php echo site_url('Visiteur/panier') ?>"><i class="glyphicon glyphicon-shopping-cart"></i><span><?php echo $this->cart->total_items(); ?></span>Panier</a>
            </li>
         
          
            <?php if ($this->session->profil=='membre'||$this->session->profil=='admin') : ?>
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
                    <a href="<?php echo site_url('Membre/Actif') ?>">S'inscrire/Se désinscrire de la newsletter</a>
                  </li>&nbsp;
                  <li>
                    <a href="<?php echo site_url('Membre/mesCommandes') ?>">Vos Commandes</a>
                  </li> &nbsp;
                </ul>
              </li> 
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-envelope"></i>&nbsp;Réclamation<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="<?php echo site_url('Membre/problem') ?>">Signaler un problème</a>
                  </li>
                </ul>
              </li>   
            <?php endif; ?>
           
            <!--administrateur-->

            <?php if ($this->session->profil=='admin') : ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> 
                  <span class="nav-label">Evènementiel</span> 
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Gestion des évènements</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/ajouterEvenement') ?>">Ajouter un évènement</a>
                      </li>&nbsp;
                      <li>
                        <a href="<?php echo site_url('Administrateur/modifierEvenement') ?>">Modifier un évènement</a>
                      </li>&nbsp;
                      <li>
                      <a href="<?php echo site_url('Administrateur/changerLEtatDunEvenement') ?>">Activer/Désactiver un évènement</a>
                      </li>
                    </ul>
                  </li>&nbsp;
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Gestion des produits</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/ajouterProduit/0/0') ?>">Ajouter un Produit</a>
                      </li>&nbsp;
                      <li>
                        <a href="<?php echo site_url('Administrateur/modifierProduit') ?>">Modifier un Produit</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li> 
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Suivi administratif
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Gestion des classes</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/modifierClasse') ?>">Gestion des classes</a>
                      </li>
                    </ul>
                  </li>&nbsp;
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Gestion des commandes</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/selectionCommande') ?>">Récapitulatif des commandes</a>
                      </li>
                    </ul>
                  </li>&nbsp;
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Gestion des membres</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/ajouterUnMembre') ?>">Ajouter un membre</a>
                      </li>&nbsp;
                      <li>
                        <a href="<?php echo site_url('Administrateur/ajouterAdmin') ?>">Ajouter un administrateur</a>
                      </li>
                    </ul>
                  </li>&nbsp;
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Gestion des problèmes</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/afficherProbleme') ?>">Gestion des problèmes d'administration</a>
                      </li>
                    </ul>
                  </li>&nbsp;
                  <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                      <span class="nav-label">Mailing</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php echo site_url('Administrateur/formulaireMail') ?>">Envoyer un mail</a>
                      </li>
                    </ul>
                  </li>
                  <!-- accuser de reception a faire -->
                  <!-- relance mail-->                  
                </ul>
              </li>
            <?php endif; ?>
          </ul>
              
        <!-- commun-->

          <ul class="nav navbar-nav navbar-right">
            <?php if ($this->session->profil=='admin') : ?>
              <li>
                <a href="<?php echo site_url('Administrateur/aide') ?>"><img src="<?php echo base_url(); ?>assets/img_site/help.png" height="25" width="25"></a>
              </li>
            <?php endif; ?>
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


<style>

.dropdown-submenu
{
  position:relative;
}
.dropdown-submenu>.dropdown-menu
{
  top:0;left:100%;
  margin-top:-6px;
  margin-left:-1px;
  -webkit-border-radius:0 6px 6px 6px;
  -moz-border-radius:0 6px 6px 6px;
  border-radius:0 6px 6px 6px;
}
.dropdown-submenu:hover>.dropdown-menu
{
  display:block;
}
.dropdown-submenu>a:after
{
  display:block;
  content:" ";
  float:right;
  width:0;
  height:0;
  border-color:transparent;
  border-style:solid;
  border-width:5px 0 5px 5px;
  border-left-color:#cccccc;
  margin-top:5px;
  margin-right:-10px;
}
.dropdown-submenu:hover>a:after
{
  border-left-color:#ffffff;
}
.dropdown-submenu.pull-left
{
  float:none;
}
.dropdown-submenu.pull-left>.dropdown-menu
{
  left:-100%;
  margin-left:10px;
  -webkit-border-radius:6px 0 6px 6px;
  -moz-border-radius:6px 0 6px 6px;
  border-radius:6px 0 6px 6px;
}
</style>