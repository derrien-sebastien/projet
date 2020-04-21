
</br>
<div>
    <h2>
        <img src="<?php echo base_url(); ?>assets/images/panier.png" height="25" width="25">&nbsp;<a href='<?php echo site_url('visiteur/indexPanier') ?>'>Tous nos produits</a>
    </h2>
</div>
<div class="containerEv">
    <h2 class='textBlanc'>Nos Evenements Marchands </h2>
        <?php 
            foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                echo '<h3>'.anchor('visiteur/EvenementMarchand/'.$unEvenementMarchand->NoEvenement.'/'.$unEvenementMarchand->Annee,$unEvenementMarchand->TxtHTMLEntete).'</h3>';
            endforeach;
        ?>
</div>
<div class="containerEv">
    <h2 class='textBlanc'>Nos Evenements non Marchands </h2>
        <?php
        echo '<div>';
            foreach ($lesEvenementsNonMarchands as $unEvenementNonMarchand):
                echo '<h3>'.anchor('visiteur/EvenementNonMarchand/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,$unEvenementNonMarchand->TxtHTMLEntete).'</h3>';
            endforeach;
        echo'</div>';
        ?>
</div>
<p align='center'>Afin d'afficher plus de détails sur nos évènements, cliquer sur son titre</p>

