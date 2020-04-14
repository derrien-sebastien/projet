<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<!DOCTYPE html >
<html>
	<head>
			<meta charset="utf-8">
     
            <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->	
		    <!--                         FEUILLES DE STYLE                             -->
		    <!--------------------------------------------------------------------------->	
		    <!--------------------------------------------------------------------------->
     
            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script> -->
 			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>  -->
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.js"></script>
            <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
        
            <?php echo '<link href='.css_url('style').' rel="stylesheet" />'?>
            <?php echo '<link href='.css_url('bootstrap.3.4.1').' rel="stylesheet" />'?>
            <?php echo '<link href='.distcss_url('summernote').' rel="stylesheet" />'?>   
            <?php echo '<script src='.distjs_url('summernote').'></script>';?>
            <?php echo '<script src='.distjs_url('jquery.3.4.1.js').'></script>';?>
            <?php echo '<script src='.distjs_url('bootstap').'></script>';?>
    </head>    
    <body>  
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo site_url('visiteur/accueil') ?>"><img src="<?php echo base_url(); ?>assets/images/accueil.png" height="25" width="25"></a>
                </div>
                <ul class="nav navbar-nav">
                    <?php if ($this->session->profil=='admin') : ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion compte<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('visiteur/InfosCompte') ?>">Gérer votre compte</a>
                                </li>&nbsp;&nbsp;
                                <li>
                                    <a href="<?php echo site_url('visiteur/ModificationMdp') ?>">Modifier votre mot de passe</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestion des évènements<span class="caret"></span></a>
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
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Suivi des évènements<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('Administrateur/selectionCommande') ?>">Recapitulatif des commandes</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('Administrateur/formulaireMail') ?>">Envoyer un mail</a>
                                </li>
                                    <!-- accuser de reception a faire -->
                                    <!-- relance mail-->                  
                            </ul>
                        </li>
                    <?php endif; ?>
                
                <?php if ($this->session->userdata('email') == False) {?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo site_url('visiteur/seConnecter') ?>">Connexion</a>                    
                        </li>
                        <?php }else { ?>
                        <li>
                            <a href="<?php echo site_url('visiteur/seDeConnecter') ?>">Déconnexion</a>
                        </li>
                    </ul>
                <?php } ?>
            </ul>
            </div>
        </nav>
        </br>
        </br>