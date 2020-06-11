<?php
/*donnee entré
$evenement
$montantTotalVentes
$motantTotalDejaPaye
$quantiterParArticle
$nbEvenementAnnee
$montantTotalVenteAnnees
$nbCommande*/
echo '<br>';
echo '<div class="container-fluid">';
    echo "<h1 class='encadre'>Concernant l'année en cours</h1>";
    echo'</br>';
    echo '<div class="caption" align="center">';
        if(isset($nbEvenementAnnee))
        {
            echo "<h4>".'Au total nous avons réalisé '.$nbEvenementAnnee->NombreDEvenement. ' évènements cette année.';   
        }
        if(isset($montantTotalVenteAnnees))
        {
            echo "<h4>".'qui nous on rapportés :'.$montantTotalVenteAnnees->MontantDesCommandes. '€ ';    
        }            
    echo '</div>';
    echo '</br>';
    if(isset($evenement))
    {
        echo "<h2 class='encadre'>Concernant l'évènement ".$evenement->TxtHTMLEntete." nous avons actuellement</h2>";
        echo'</br>';
    }
    echo '<div class="caption" align="center">';
        if(isset($montantTotalVentes))
        {
            echo "<h4>".$montantTotalVentes->MontantDesCommandes." € de commandes</h4>";    
        }
        if(isset($motantTotalDejaPaye))
        {
            echo "<h4>".$motantTotalDejaPaye->MontantPaye. '€ déjà payé.</h4>';    
        }
        if(isset($quantiterParArticle))
        {
            foreach($quantiterParArticle as $unProduit)
            {
                echo "<h4>".'pour le produit '.$unProduit->LibelleCourt. ' il y a eu '.$unProduit->nbProduit.' quantité de commandée, </h4>'; 
            }   
        }
    echo '</div>'; 
echo '</div>';
echo '</br>';
echo '</br>';
echo '</br>';