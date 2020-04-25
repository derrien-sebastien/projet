<h1>Bienvenu sur l'accueil</h1>
    <div class="menuAdmin">
        <ul>
            <li>
                <span>
                <a href="<?php echo site_url('visiteur/accueil')?>"><img src="<?php echo base_url(); ?>assets/images/maison.svg" height="25" width="25">Accueil</a>
                </span>
            </li>
            <li>
                <span>
                    <img src="<?php echo base_url(); ?>assets/images/utilisateur.svg" height="25" width="25">Gestion de compte 
                </span>
                <ul>  
                    <li><a href="<?php echo site_url('membre/infosCompte') ?>">Vos informations</a></li>
                    <li><a href="<?php echo site_url('membre/ModificationMdp')?>">Modification du mot de passe</a></li>
                </ul>
            </li>
            <li>
                <span>
                    <a href="<?php echo site_url('visiteur/catalogueEvenement')?>"><img src="<?php echo base_url(); ?>assets/images/even.svg" height="25" width="25">Nos Evènements</a>
                </span>
            </li>
            <li>
                <span>
                    <a href="<?php echo site_url('visiteur/catalogueProduits')?>"><img src="<?php echo base_url(); ?>assets/images/catalogue.svg" height="25" width="25">Nos Produits</a>
                </span>
            </li>
            <li>
                <span>
                    <img src="<?php echo base_url(); ?>assets/images/euro.svg" height="25" width="25">Vos Commandes
                </span>
                <ul>  
                    <li><a href="<?php echo site_url('Administrateur/selectionCommande') ?>">Recapitulatif des commandes</a></li>
                    <li><a href="<?php /* echo site_url('Administrateur/formulaireMail')  */?>">Validation des commandes</a></li>
                </ul>
            </li>
        </ul>
  </div>
