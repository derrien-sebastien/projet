</br>
<?php
/* données attendu :
-$modif si nous voulont modifier les commande 
-$lignesCommandes tableau de toutes les commande

utilité afficher les produit regrouper par commande et par personne 
si $modif possibiliter de modifier payer et remis */
    $data =array(
        'annee'         =>  $annee,
        'noEvenement'   =>  $noEvenement    
    );
    $submit=array(
        'name'          =>  'submit',
        'value'         =>  'Valider',
        'class'         =>  'btn btn-primary'
    );
    $noPersonnePrecedente=0;//variable qui memorise la personne precedente 
    $noCommandePrecedente=0;//variable qui memorise la commande precedente(!noCommande dif dans un meme evenement)
    if($modif=='modif')
    {    
        echo form_open('Administrateur/commande');    
    }
    echo '<div class="container-fluid">';
        echo "<h1 class='encadre'>Recapitulatif des commande:</h1>";
    echo '</div>';
    echo "<table>";
    echo "<table>";
    echo '<thead>';
        echo '<tr>';
            echo '<th>';
                echo form_label('Nom');
            echo '</th>';
            echo '<th>';
                echo form_label('Prenom');
            echo '</th>';
            echo '<th>';
                echo form_label('Téléphone');
            echo '</th>';
            echo '<th>';
                echo form_label('N° commande');
            echo '</th>';
            echo '<th>';
                echo form_label('Montant');
            echo '</th>';
            echo '<th>';
                echo form_label('Payer');
            echo '</th>';
            echo '<th>';
                echo form_label('Reste à payer');
            echo '</th>';
            echo '<th>';
                echo form_label('Produit');
            echo '</th>';
            echo '<th>';
                echo form_label('Quantité Commandée');
            echo '</th>';
            echo '<th>';
                echo form_label('Quantité remise');
            echo '</th>';
        echo '</tr>';
    echo '</thead>';
        echo form_hidden($data);
        foreach($lignesCommandes as $uneLigne)
        {
            if($uneLigne->NoPersonne!=$noPersonnePrecedente)
            {
                echo "<tr>";
                    echo "<td>";
                        echo "___________________________";
                        echo "</br>";
                    echo "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>";        
                        echo "Adresse mail : ";
                        echo $uneLigne->Email;
                    echo "</td>";
                    echo "<td>";
                        echo "Nom : ";
                        echo $uneLigne->Nom;
                    echo '</td>';
                    echo "<td>";
                        echo "Prénom : ";
                        echo $uneLigne->Prenom;
                        echo "</br>";
                    echo "</td>";
                    if(isset($uneLigne->TelPortable))
                    {
                        echo "<td>";
                            echo "Téléphone Portable  :  ";
                            echo $uneLigne->TelPortable;
                        echo "</td>";
                    }
                    elseif(isset($uneLigne->TelFixe))
                    {
                        echo "<td>";
                            echo "Telephone Fixe:";
                            echo $uneLigne->TelFixe;
                        echo "</td>"; 
                    }  
                echo "</tr>";      
            }
            if($uneLigne->NoCommande!=$noCommandePrecedente)
            {   
                echo "<tr>";
                    echo "<td>";
                        echo "- - - - - - - - - - - - - - - - - - - - - - -  ";        
                    echo "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>";
                    echo "</td>";
                    echo "<td>";        
                        echo "Numéro de la commande : ";
                        echo $uneLigne->NoCommande;
                    echo "</td>";
                    echo "<td>";            
                        echo "Montant total : ";
                        echo $uneLigne->MontantTotal;
                        echo "</td>";
                        $paye=array(
                            'name'          =>  'paye['.$uneLigne->NoCommande.']',
                            'value'         =>  $uneLigne->Payer
                        );
                        if($modif=='modif' && $uneLigne->ResteAPayer > 0)
                        {
                            echo "<td>";
                                echo "Payé : ";
                                echo form_input($paye); 
                            echo "</td>"; 
                        }
                        else
                        {
                            echo "<td>";
                                echo "Payé : ";
                                echo $uneLigne->Payer;
                            echo "</td>";
                        }
                        echo "<td>";
                            echo form_submit($submit);
                        echo "</td>";
                    echo "</td>";
                echo "</tr>";
                echo "</br>";
                echo "<tr>";
                    echo "<td>";
                    echo "</td>";
                    echo "<td>";
                        echo "Reste à payer :";
                        echo $uneLigne->ResteAPayer;
                    echo "</td>";
                    echo "<td>";
                        echo "Type de payement :";
                        echo $uneLigne->ModePaiement;
                    echo "</td>";
                echo "</tr>";
                echo "</br>";
                echo "<tr>";
                    echo "<td>";
                    echo "</td>";
                    echo "<td>";
                        echo "Commentaire acheteur :";
                        echo $uneLigne->CommentaireAcheteur;
                    echo "</td>";
                echo "</tr>";
                echo "</br>";
                echo "<tr>";
                    echo "<td>";
                    echo "</td>";
                    echo "<td>";
                        echo "Commentaire Administrateur :";
                        echo $uneLigne->CommentaireAdministrateur;
                    echo "</td>";
                echo "</tr>";
            }
            echo "</br>";
            echo "<tr>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";    
                echo "Produit : ";
                echo $uneLigne->LibelleCourt;
                echo "</td>";
                echo "<td>";
                    echo "Quantité commandée : ";
                    echo $uneLigne->Quantite;
                echo "</td>";
                $remis=array(
                    'name'          =>  'remis['.$uneLigne->NoCommande.']['.$uneLigne->NoProduit.']',
                    'value'         =>  $uneLigne->Remis
                );
                if($modif=='modif')
                {
                    echo "<td>";
                        echo "Déjà remis :";
                        echo form_input($remis);
                    echo "</td>";   
                }
                else
                {
                    echo "<td>";
                        echo "Déjà remis :";
                        echo $uneLigne->Remis;
                    echo "</td>";
                }
                echo "<td>";
                    echo form_submit($submit);
                echo "</td>";
            echo "</tr>";  
            $noPersonnePrecedente=$uneLigne->NoPersonne;
            $noCommandePrecedente=$uneLigne->NoCommande;
        }
    echo "</table>";
echo form_close();
?>