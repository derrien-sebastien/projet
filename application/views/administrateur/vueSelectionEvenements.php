</br>
<?php

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
else
{
echo form_open('Administrateur/formulaireEvenement');
}
echo "<table>\n";
echo "<tr><td><label for='Evenement'>choisissez:</label></td>
<td><select name='Evenement'>
    <option value='//////////'>Aucun evenement selectionné</option>
    <option value='//////////'>Nouvel Evenement</option>";    
    foreach ($lesEvenements as $unEvenement):
        echo "<option value='";
        echo $unEvenement->Annee."/".$unEvenement->NoEvenement."/".$unEvenement->DateMiseEnLigne."/".$unEvenement->DateMiseHorsLigne
        ."/".$unEvenement->TxtHTMLEntete."/".$unEvenement->TxtHTMLCorps."/".$unEvenement->TxtHTMLPiedDePage."/".$unEvenement->ImgEntete
        ."/".$unEvenement->ImgPiedDePage."/".$unEvenement->EmailInformationHTML."/".$unEvenement->EnCours;
        echo "'>";
        echo $unEvenement->TxtHTMLEntete;
        echo "</option>";
   endforeach; 
echo "</select></td></tr>";
if($Provenance=='commande')
{
    $commande=array(
        'name'=>'modif',
        'value'=>'modif'
    );
    echo '<tr><td></br>';
    echo form_label('selectionnez pour modifier la commande &nbsp&nbsp ');
    echo '</td><td></br>';    
    echo form_checkbox($commande);
    echo '</td></tr>';
    
}
echo "<tr><td></td><td><input type='submit' name='existant' value='envoyer'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
?>
