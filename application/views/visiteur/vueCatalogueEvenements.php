<div class="containerEv">
    <h2 align='left' class='textBlanc'>Nos Evenements Marchands </h2>
        <?php 
            foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                echo '<h3 align="left">'.anchor('visiteur/Evenement/'.$unEvenementMarchand->NoEvenement.'/'.$unEvenementMarchand->Annee,'<ol><li>'.$unEvenementMarchand->TxtHTMLEntete.'</li></ol>').'</h3>';
            endforeach;
        ?>
</div>
<div class="containerEv">
    <h2 align='left' class='textBlanc'>Nos Evenements non Marchands </h2>
        <?php 
            foreach ($lesEvenementsNonMarchands as $unEvenementNonMarchand):
                echo '<h3 align="left">'.anchor('visiteur/Evenement/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,'<ol><li>'.$unEvenementNonMarchand->TxtHTMLEntete.'</li></ol>').'</h3>';
            endforeach;
        ?>
</div>

