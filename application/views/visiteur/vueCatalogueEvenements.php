
</br>
<div class="btn-primary">
    <h2>
        <img src="<?php echo base_url(); ?>assets/images/panier.png" height="25" width="25">&nbsp;<a href='<?php echo site_url('visiteur/catalogueProduits') ?>'>Tous nos produits</a>
    </h2>
</div>
<div class="btn-primary">
    <h2 class="btn-primary">Nos Evenements Marchands </h2>
        <?php 
            foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                echo '<h3 class="btn-primary">'.anchor('visiteur/EvenementMarchand/'.$unEvenementMarchand->NoEvenement.'/'.$unEvenementMarchand->Annee,$unEvenementMarchand->TxtHTMLEntete).'</h3>';
            endforeach;
        ?>
</div>
<div class="btn-primary">
    <h2 class="btn-primary">Nos Evenements non Marchands </h2>
        <?php
        echo '<div class="btn-primary">';
            foreach ($lesEvenementsNonMarchands as $unEvenementNonMarchand):
                echo '<h3 class="btn-primary">'.anchor('visiteur/EvenementNonMarchand/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,$unEvenementNonMarchand->TxtHTMLEntete).'</h3>';
            endforeach;
        echo'</div>';
        ?>
</div>
<p align='center'>Afin d'afficher plus de détails sur nos évènements, cliquer sur son titre</p>

