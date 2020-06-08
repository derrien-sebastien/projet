<?php
foreach($commandes as $commande)
{
    echo '<table>';
    echo '<tr>';
        echo '<td>';
            echo 'Actuellement il y a';
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
        echo $commande->nbLignes;
        echo '</td>';
    echo '</tr>';
} 

