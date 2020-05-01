<?php
        echo '</br>';
        echo '</br>';
        echo '</br>';
        echo $Evenement->TxtHTMLPiedDePage;//affiche le pied de page 
        echo '</br>';
        echo '<p>'.img($Evenement->ImgPiedDePage).'<p>';//image de notre pied de page 
        echo '</br>';
        echo '</br>';
        echo $Evenement->DateMiseHorsLigne;
        echo '</br>';
        echo '<p>'.anchor('visiteur/nosEvenements','Retour à la liste des evenements').'</p>';
?>