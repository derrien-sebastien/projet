</br>
<div class="menuAdmin">
        <ul>
            <li>
                <span>
                <a href="<?php echo site_url('visiteur/')?>"><img src="<?php echo base_url(); ?>assets/images/maison.svg" height="25" width="25">Accueil
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
</br>

<div align=center>
    <h2>Nos Evenements Marchands </h2>
        <?php 
            foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                echo '<h3>'.anchor('visiteur/EvenementMarchand/'.$unEvenementMarchand->NoEvenement.'/'.$unEvenementMarchand->Annee,$unEvenementMarchand->TxtHTMLEntete,array('class'=>'btn-primary')).'</h3>';
            endforeach;
        ?>
</div>
<div align=center>
    <h2 >Nos Evenements non Marchands </h2>
        <?php
            foreach ($lesEvenementsNonMarchands as $unEvenementNonMarchand):
                echo '<h3>'.anchor('visiteur/EvenementNonMarchand/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,$unEvenementNonMarchand->TxtHTMLEntete,array('class'=>'btn-primary')).'</h3>';
            endforeach;
        ?>
</div>
<p align='center'>Afin d'afficher plus de détails sur nos évènements, cliquer sur son titre</p>

