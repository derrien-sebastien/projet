<?php
/*

    Doneees d'entrees:
    $commandes

Donnees voulu
libelleEvenement libelleProduit Mqty prix dateRemise noCommande DejaPayer   


*/
$submit=array(
    'name'              =>  'voir',
    'value'             =>  'VOIR',
    'class'             =>  'btn btn-primary'
);
echo'</br>';
echo '<table class="table table-dark">';
    echo '<tr>';
            echo '<th scope="col">';
                echo 'N° de Commande';
            echo'</th>';
            echo '<th scope="col">';
                echo 'Date de la Commande';
            echo'</th>';
            echo '<th scope="col">';
                echo 'Mode de Paiement';
            echo '</th>';
            echo '<th scope="col">';
                echo 'Montant Total';
            echo '</th>';
            echo '<th scope="col">';
                echo 'Payer';
            echo '</th>';
        echo'<th scope="col">';
            echo 'Action';
        echo'</th>';
    echo '</tr>';
foreach($commandes as $uneCommande)
{   
    $hidden[]=array(
        'noCommande'=>$uneCommande->NoCommande
    );
    echo form_open('Membre/afficherUneCommande');
        echo '<tbody>';
            echo form_hidden($hidden);
            echo '<tr>';
                echo '<td>';
                    echo $uneCommande->NoCommande;
                echo'</td>';
                echo '<td>';
                    echo $uneCommande->DateCommande;
                echo'</td>';
                echo '<td>';
                    echo $uneCommande->ModePaiement;
                echo '</td>';
                echo '<td>';
                    echo $uneCommande->MontantTotal;
                echo '</td>';
                echo '<td>';
                    echo $uneCommande->Payer;
                echo '</td>';
                echo'<td>';
                    echo form_submit($submit);
                echo'</td>';
            echo '</tr>';
        echo '</tbody>';
    echo form_close();   
}
echo '</table>';

