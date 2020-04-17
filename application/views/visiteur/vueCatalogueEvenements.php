
</br>
<div>
    <h2><a href='<?php echo site_url('visiteur/indexPanier') ?>'>Tous nos produits</a></h2>
</div>
<div class="containerEv">
    <h2 align='left' class='textBlanc'>Nos Evenements Marchands </h2>
        <?php 
            foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                echo '<h3>'.anchor('visiteur/EvenementMarchand/'.$unEvenementMarchand->NoEvenement.'/'.$unEvenementMarchand->Annee,'<ol><li>'.$unEvenementMarchand->TxtHTMLEntete.'</li></ol>').'</h3>';
            endforeach;
        ?>
</div>
<div class="containerEv">
    <h2 align='left' class='textBlanc'>Nos Evenements non Marchands </h2>
        <?php
        echo '<div>';
            foreach ($lesEvenementsNonMarchands as $unEvenementNonMarchand):
                echo '<h3>'.anchor('visiteur/EvenementNonMarchand/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,'<ol><li>'.$unEvenementNonMarchand->TxtHTMLEntete.'</li></ol>').'</h3>';
            endforeach;
        echo'</div>';
        ?>
</div>
<p align='center'>Afin d'afficher plus de détails sur nos évènements, cliquer sur son titre</p>

