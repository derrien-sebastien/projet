</br>
<?php
/* données attendu :
-$modif si nous voulont modifier les commande 
-$lignesCommandes tableau de toutes les commande

utilité afficher les produit regrouper par commande et par personne 
si $modif possibiliter de modifier payer et remis */

if($modif=='modif')
{    
    echo form_open('Administrateur/commande');    
}
$noPersonnePrecedente=0;//variable qui memorise la personne precedente 
$noCommandePrecedente=0;//variable qui memorise la commande precedente(!noCommande dif dans un meme evenement)
echo "<h1>Recapitulatif des commande:</h1>";
echo "<table>";
$data =array(
    'annee'  => $annee,
    'noEvenement' => $noEvenement    
);
echo form_hidden($data);
foreach($lignesCommandes as $uneLigne)
{
    if($uneLigne->NoPersonne!=$noPersonnePrecedente)
    {
        
        //echo "</br>";
        echo "<tr><td>";
        echo "___________________________";
        echo "</br>";
        echo "</td></tr><tr><td>";        
        echo "adresse mail: ".$uneLigne->Email."</td><td> Nom: ".$uneLigne->Nom."</td><td> Prenom: ".$uneLigne->Prenom;
        echo "</br>";
        if(isset($uneLigne->TelPortable))
        {
            echo "</td><td> Telephone: ".$uneLigne->TelPortable;
        }
        elseif(isset($uneLigne->TelFixe))
        {
            echo "</td><td> Telephone: ".$uneLigne->TelFixe; 
        }  
        echo "</td></tr>";      
    }
    if($uneLigne->NoCommande!=$noCommandePrecedente)
    {
        
        //echo "</br>";
        echo "<tr><td>";
        echo "- - - - - - - - - - - - - - - - - - - - - - -  ";        
        echo "</td></tr><tr><td></td><td>";        
        echo "Numero de commande: ".$uneLigne->NoCommande."</td><td> Montant total: ".$uneLigne->MontantTotal;
        if($modif=='modif')
        {
            echo "</td><td> Payé: ";
            $paye=array(
                'name'=>'paye['.$uneLigne->NoCommande.']',
                'value'=>$uneLigne->Payer
            );
            echo form_input($paye);
            
        }
        else
        {
            echo "</td><td> Payé: ".$uneLigne->Payer;
        }
        echo "</td></tr></br>";
        echo"<tr><td></td><td>Reste a payer: ".$uneLigne->ResteAPayer."</td><td> Type de payement: ".$uneLigne->ModePaiement;
        echo "</td></tr></br>";
        echo "<tr><td></td><td>Commentaire acheteur: ".$uneLigne->CommentaireAcheteur;
        echo "</td></tr></br>";
        echo "<tr><td></td><td>Commentaire Administrateur: ".$uneLigne->CommentaireAdministrateur;
        echo "</td></tr>";
        }
    
    echo "</br>";
    echo "<tr><td></td><td></td><td>";    
    echo "Produit: ".$uneLigne->LibelleCourt."</td><td> Quantité commandé: ".$uneLigne->Quantite;
    if($modif=='modif')
    {
        echo "</td><td> Deja remis: ";
        $remis=array(
            'name'=>'remis['.$uneLigne->NoCommande.']['.$uneLigne->NoProduit.']',
            'value'=>$uneLigne->Remis
        );
        echo form_input($remis);
    }
    else
    {
        echo "</td><td> Deja remis: ".$uneLigne->Remis;
    }
    echo "</td></tr>";
    $noPersonnePrecedente=$uneLigne->NoPersonne;
    $noCommandePrecedente=$uneLigne->NoCommande;
}
echo "</table>";
echo "<input type='submit' name='submit' value='envoyer'>";
echo "</form>";