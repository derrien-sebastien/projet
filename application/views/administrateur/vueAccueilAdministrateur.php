  <h1>Bienvenu sur l'accueil administrateur</h1>
  <div class="menuAdmin">
    <ul>
      <li>
        <span>
          <img src="<?php echo base_url(); ?>assets/images/maison.svg" height="25" width="25">Super Admin</a></li>
        </span>
        <li>
          <span>
            <img src="<?php echo base_url(); ?>assets/images/utilisateur.svg" height="25" width="25">Utilisateurs</a>
          </span>
          <ul>
            <li><a href="<?php/*         */?>">Ajouter membre</li>
            <li><a href="<?php/*         */?>">Ajouter admin</li>
            <!--<li><a href="<?php/*         */?>">Les connectés</li> -->
          </ul>
        </li>
        <li>
          <span>
            <img src="<?php echo base_url(); ?>assets/images/even.svg" height="25" width="25">Evènements
          </span>
          <ul>
            <li><a href="<?php echo site_url('administrateur/ajouterEvenement')?>">Ajouter un Evenement</a></li>
            <li><a href="<?php echo site_url('administrateur/modifierEvenement')?>">Modifier un Evenement</a></li>
          </ul>
        </li>
        <li>
          <span>
            <img src="<?php echo base_url(); ?>assets/images/produit.svg" height="25" width="25">Produits
          </span>
          <ul>  
            <li><a href="<?php echo site_url('administrateur/ajouterProduit')?>">Ajouter un Produit</a></li>
            <li><a href="<?php echo site_url('administrateur/modifierProduit')?>">Modifier un Produit</a></li>
          </ul>
        </li>
        <li>
          <span>
            <img src="<?php echo base_url(); ?>assets/images/enveloppe.svg" height="25" width="25">Mailing
          </span>
          <ul>  
            <li><a href="<?php echo site_url('Administrateur/formulaireMail') ?>">Envoi de Mail</a></li>
            <li><a href="<?php /* echo site_url('Administrateur/formulaireMail')  */?>">Traitement Mail</a></li>
          </ul>
        </li>
        <li>
          <span>
            <img src="<?php echo base_url(); ?>assets/images/euro.svg" height="25" width="25">Commandes
          </span>
          <ul>  
            <li><a href="<?php echo site_url('Administrateur/selectionCommande') ?>">Recapitulatif des commandes</a></li>
            <li><a href="<?php /* echo site_url('Administrateur/formulaireMail')  */?>">Validation des commandes</a></li>
          </ul>
        </li>
      </ul>
    </div>



