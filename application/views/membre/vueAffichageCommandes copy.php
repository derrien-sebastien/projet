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
echo '<div class="container-fluid">';
    echo '<div class="row">';
        echo '<div class="col-lg-12" >';
            echo '<h1 class="encadre">Vos commandes passées</h1>';
            echo'</br>';
            echo '<h2>Ci-dessous, vos commandes passées sur notre site. Afin de les visualiser cliquez sur VOIR</h2>';
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
                            echo '<td class="tdCommande">';
                                echo $uneCommande->NoCommande;
                            echo'</td>';
                            echo '<td>';
                                echo $uneCommande->DateCommande;
                            echo'</td>';
                            echo '<td class="tdCommande">';
                                echo $uneCommande->ModePaiement;
                            echo '</td>';
                            echo '<td class="tdCommande">';
                                echo $uneCommande->MontantTotal;
                            echo '</td>';
                            echo '<td class="tdCommande">';
                                echo $uneCommande->Payer;
                            echo '</td>';
                            echo'<td class="tdCommande">';
                                echo form_submit($submit);
                            echo'</td>';
                        echo '</tr>';
                    echo '</tbody>';
                echo form_close();    
            }
            echo '</table>';
        echo '</div>';
    echo '</div>';
echo '</div>';  
