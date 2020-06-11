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
    'class'             =>  'btn'
);
echo '<body class="bodyCommande">';
    echo '<section class="sectionCommande">';
        echo '<h1 class="encadre">Vos commandes passées</h1>';
        echo'</br>';
        echo '<h2 align="center">Ci-dessous, vos commandes passées sur notre site. Afin de les visualiser cliquez sur VOIR</h2>';
        echo '<div class="tbl-header">';
            echo '<table class="tableCommande" cellpadding="0" cellspacing="0" border="0">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th class="thCommande">';
                            echo 'N° de Commande';
                        echo'</th>';
                        echo '<th class="thCommande">';
                            echo 'Date de la Commande';
                        echo'</th>';
                        echo '<th class="thCommande">';
                            echo 'Mode de Paiement';
                        echo '</th>';
                        echo '<th class="thCommande">';
                            echo 'Montant Total';
                        echo '</th>';
                        echo '<th class="thCommande">';
                            echo 'Payer';
                        echo '</th>';
                        echo'<th class="thCommande">';
                            echo 'Action';
                        echo'</th>';
                    echo '</tr>';
                echo '</thead>';
            echo '</table>';
        echo '</div>';
        foreach($commandes as $uneCommande)
        {   
            $hidden[]=array(
                'noCommande'=>$uneCommande->NoCommande
            );
            echo form_open('Membre/afficherUneCommande');
                echo '<div class="tbl-content">';
                    echo '<table class="tableCommande" cellpadding="0" cellspacing="0" border="0">';
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
                    echo '</table>';
                echo '</div>';
            echo form_close();    
        } 
    echo '</section>';
?>

<script>
    $(window).on("load resize ", function() 
    {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css(
        {
            'padding-right':scrollWidth
        });
    }).resize();
</script>
