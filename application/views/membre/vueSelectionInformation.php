<?php
if($Provenance==='modifier')
{
    echo "<h1>choissisez une information à modifier</h1>";
    ///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
    echo form_open('visiteur/modifierInformation');
    echo '<input type="hidden" name="Provenance" value="';
    echo    $Provenance;
    echo '">'; 
}
else
{
    ///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
    echo form_open('visiteur/infosCompte');
}
echo '<table>\n';
echo    '<tr>';
echo        '<td>';
echo            form_label('Information','Choisissez :');
echo        '</td>';
echo        '<td>';
echo            '<select name="Information">';
echo                '<option value="//////////">Aucune information selectionnée</option>';
echo                '<option value="//////////">Nouvel Information</option>';
////////////////////////////// Déclaration de nos Variables ////////////////////////////
                    foreach ($lesInformation as $uneInformation):
echo                    '<option value="';
echo                        $uneInformation->NoPersonne."/".$uneInformation->Email."/".$uneInformation->Adresse."/".$uneInformation->Ville."/".$uneInformation->CodePostal."/".$uneInformation->TelPortable."/".$uneInformation->TelFixe."/".$uneInformation->Actif."/".$uneInformation->MotDePasse;
echo                    '">';
echo                    $uneInformation->Email;
echo                    '</option>';
                    endforeach; 
echo            '</select>';
echo        '</td>';
echo    '</tr>';
echo    '<tr>';
echo        '<td>';
echo        '</td>';
echo        '<td>';
echo            '<input type="submit" name="existant" value="charger les informations existantes">';
echo        '</td>';
echo        '<td>';
echo        '</td>\n';
echo    '</tr>';
echo '</table>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>