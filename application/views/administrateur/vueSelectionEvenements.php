</br>
<?php
/*

*/
$evenement=array(
    '0/0'=>'Nouvel Evenement'
);
foreach ($lesEvenements as $unEvenement)
{
    $valeur=$unEvenement->Annee."/".$unEvenement->NoEvenement;
    $evenement[$valeur]=$unEvenement->Annee.'   '.$unEvenement->TxtHTMLEntete;
}
$commande=array(
    'name'=>'modif',
    'value'=>'modif'
);
$submit=array(
    'name'=>'existant',
    'value'=>'envoyer'
);

if($Provenance==='modifier')
{
    echo "<h1>choissisez un evenement a modifier</h1>";
    echo form_open('Administrateur/modifierEvenement');
    echo "<input type='hidden' name='Provenance' value='".$Provenance."'>"; 
}
elseif($Provenance=='commande')
{
    echo "<h1>choissisez un evenement pour voir les commandes associé</h1>";
    echo form_open('Administrateur/selectionCommande');
    echo "<input type='hidden' name='Provenance' value='".$Provenance."'>";  
}
elseif($Provenance=='ajouter')
{
    $donnees['Provenance']='ajouter';
    echo form_open('Administrateur/ajouterEvenement',$donnees);
}
else
{
echo form_open('Administrateur/formulaireEvenement');
}
echo "<table>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('choisissez:','evenement');
        echo "</td>";
        echo "<td>";
            echo form_dropdown('evenement',$evenement);
        echo "</td>";
    echo "</tr>";
    if($Provenance=='commande')
    {    
        echo "<tr>";
            echo "<td>";
                echo"</br>";
                echo form_label('selectionnez pour modifier la commande &nbsp&nbsp ');
            echo "</td>";
            echo "<td>";
                echo "</br>";    
                echo form_checkbox($commande);
            echo "</td>";
        echo "</tr>";
    }
    echo "<tr>";
        echo "<td>";
        echo "</td>";
        echo "<td>";
            echo form_submit($submit);    
        echo "</td>\n";
    echo "</tr>";
echo "</table>";
echo form_close();
?>
