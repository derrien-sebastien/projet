<?php
if($Provenance==='modifier')
{
    echo "<h1>choissisez une information à modifier</h1>";
    echo form_open('visiteur/modifierInformation');
    echo "<input type='hidden' name='Provenance' value='".$Provenance."'>"; 
}
else
{
echo form_open('visiteur/infosCompte');
}
echo "<table>\n";
echo "<tr><td><label for='Information'>choisissez:</label></td>
<td><select name='Information'>
    <option value='//////////'>Aucune information selectionnée</option>
    <option value='//////////'>Nouvel Information</option>";
    foreach ($lesInformation as $uneInformation):
        echo "<option value='";
        echo $uneInformation->NoPersonne."/".$uneInformation->Email."/".$uneInformation->Adresse."/".$uneInformation->Ville
        ."/".$uneInformation->CodePostal."/".$uneInformation->TelPortable."/".$uneInformation->TelFixe."/".$uneInformation->Actif
        ."/".$uneInformation->MotDePasse;
        echo "'>";
        echo $uneInformation->Email;
        echo "</option>";
   endforeach; 
echo "</select></td></tr>";
echo "<tr><td></td><td><input type='submit' name='existant' value='charger les informations existantes'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
?>