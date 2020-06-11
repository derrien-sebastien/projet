<?php
//donnees d'entree
/*
'$ligneCommandes'=
$noEvenement=evenement selectionné
$annee=>idem
$modif=>$modif,


*/
$memoireEmail="";
$memoireNoCommande="";
$nbLigne=1;
$submit=array(
    'name'      =>  'submit',
    'value'     =>  'VALIDER',
    'class'     =>  'btn'
);
$voir=array(
    'name'      =>  'voir',
    'value'     =>  'VALIDER',
    'class'     =>  'btn'
);
$hidden2=array(
    'NoEvenement'=>$noEvenement,
    'Annee'=>$annee
);
echo '<div class="container-fluid">';
    echo '<h1 class="encadre">Récapitulatif commande</h1>';
    echo'</br>';
    echo '<div class="stats">';
        echo '<h2 class="souligne" align="center"> Statistiques actuelles</h2>';
        echo '<ul>';
            echo '<li>Nombre de produits commandés &nbsp;: <span class="percent v70">'/* .$nbProduit*/.'</span></li>';
            echo "<li>Montant total que va rapporter l'évènement &nbsp;: <span class='percent v30'>"/* .$totalEven */."</span></li>";
            echo '<li>Montant total payé pour le moment&nbsp;: <span class="percent v100">'.'</span></li>';
        echo '</ul>';
    echo '</div>';
    echo '<h2 align="center">Ci-dessous, les commandes passées sur le site. Validation par ligne de commande.</h2>';
    echo '<body class="bodyCommande">';
        echo '<section class="sectionCommande">';
            echo '<table class="tableCommande">';
                echo '<div class="tbl-header">';
                    echo'<thead>';
                        echo '<tr>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Email</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Nom</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Prénom</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">N° Commande</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Total</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Payer</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Produit</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Quantité</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Remis</p>';
                            echo '</th>';
                            echo '<th class="thRecapCommande">';
                                echo '<p align="center">Actions</p>';
                            echo '</th>';
                        echo '</tr>';
                    echo '</thead>';
                echo '</div>';
                echo '<div class="tbl-content">';
                    echo '<tbody>';
                    echo form_open('Administrateur/commandesClientsParPersonne');
                    echo form_hidden($hidden2);
                    $i=0;
                        foreach($ligneCommandes as $uneLigne)
                        { 
                            $hidden['noCommande['.$i.']']=$uneLigne['contenu']->NoCommande;
                            $hidden['noProduit['.$i.']']=$uneLigne['contenu']->NoProduit; 
                            $hidden['montantTotal['.$i.']']=$uneLigne['contenu']->MontantTotal;   
                            $hidden['noPersonne['.$i.']']=$uneLigne['contenu']->NoPersonne;      
                            $payer=array(
                                'min'     =>  $uneLigne['contenu']->Payer,
                                'max'     =>  $uneLigne['contenu']->MontantTotal,
                                'step'    =>  '0.01',
                                'type'    =>  'number',
                                'name'    =>  'payer['.$i.']',
                                'value'   =>  $uneLigne['contenu']->Payer,
                                'size'    =>  '5' 
                            );
                            $remis=array(
                                'min'     =>  $uneLigne['contenu']->Remis,
                                'max'     =>  $uneLigne['contenu']->Quantite,
                                'step'    =>  '1',
                                'type'    =>  'number',
                                'name'    =>  'remis['.$i.']',
                                'value'   =>  $uneLigne['contenu']->Remis,
                                'size'    =>  '5'
                            );
                            echo form_hidden($hidden);
                            echo "<tr>";
                            if($memoireEmail != $uneLigne['contenu']->Email)//nbLigneParCommande+
                            {
                                echo "<td class='tdRecapCommande' rowspan='".$uneLigne['nbLigneParPersonne']."'>".$uneLigne['contenu']->Email."</td>";
                                echo "<td class='tdRecapCommande' rowspan='".$uneLigne['nbLigneParPersonne']."'>".$uneLigne['contenu']->Nom."</td>";
                                echo "<td class='tdRecapCommande' rowspan='".$uneLigne['nbLigneParPersonne']."'>".$uneLigne['contenu']->Prenom."</td>";
                                $memoireEmail = $uneLigne['contenu']->Email;
                            }
                            if ($memoireNoCommande != $uneLigne['contenu']->NoCommande)
                            {
                                echo "<td class='tdRecapCommande' rowspan='".$uneLigne['nbLigneParCommande']."' >".$uneLigne['contenu']->NoCommande."</td>";
                                echo "<td class='tdRecapCommande' rowspan='".$uneLigne['nbLigneParCommande']."' >".$uneLigne['contenu']->MontantTotal."</td>";
                                if($modif == '' || $uneLigne['contenu']->Payer==$uneLigne['contenu']->MontantTotal)
                                {
                                    if($uneLigne['contenu']->Payer==$uneLigne['contenu']->MontantTotal)
                                    {
                                        echo "<td class='tdRecapCommande-codeCouleurValide' rowspan='".$uneLigne['nbLigneParCommande']."'>";
                                    }
                                    else
                                    {
                                        echo "<td class='tdRecapCommande'rowspan='".$uneLigne['nbLigneParCommande']."'>";
                                    }
                                    echo $uneLigne['contenu']->Payer;
                                    echo "</td>";
                                }
                                else
                                {
                                    echo  "<td class='tdRecapCommande-codeCouleurNonValide' rowspan='".$uneLigne['nbLigneParCommande']."' >";
                                    echo form_input($payer);
                                    echo "</td>";
                                   
                                }
                                $memoireNoCommande = $uneLigne['contenu']->NoCommande;
                            }
                            echo "<td class='tdRecapCommande'>";
                            echo $uneLigne['contenu']->LibelleCourt;
                            echo "</td>";
                            echo "<td class='tdRecapCommande'>";
                            echo $uneLigne['contenu']->Quantite;
                            echo "</td>";
                            if($modif == ''|| $uneLigne['contenu']->Remis==$uneLigne['contenu']->Quantite)
                            {
                                if($uneLigne['contenu']->Remis==$uneLigne['contenu']->Quantite)
                                {
                                    echo "<td class='tdRecapCommande-codeCouleurValide'>";
                                }
                                else
                                {
                                    echo "<td class='tdRecapCommande'>";
                                }
                                echo $uneLigne['contenu']->Remis;
                                echo "</td>";
                            }
                            else 
                            {
                                echo "<td class='tdRecapCommande-codeCouleurNonValide'>";
                                echo form_input($remis);
                                echo "</td>";
                            }
                            if($modif == '' || $uneLigne['contenu']->Remis==$uneLigne['contenu']->Quantite && $uneLigne['contenu']->Payer==$uneLigne['contenu']->MontantTotal)
                            {
                                echo "<td class='tdRecapCommande'>";
                                echo "</td>";
                            }
                            else
                            {
                                echo "<td class='tdRecapCommande'>";
                                echo form_submit($submit);
                                echo "</td>";
                            }
                            $i++;
                        }
                        echo form_close();
                    echo '</tbody>';
                echo '</div>';
            echo'</table>';

    echo '</section>';















?>