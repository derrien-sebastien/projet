<?php
/*donnée d'entrée: lesClasses array table classe 
*/
echo form_open('Administrateur/afficherEleveClasse');//a renseigné
echo "<table>\n";
echo "<tr><td><label for='classe'>choisissez:</label></td>
    <td><select name='classe'>    
    <option value='0'>Nouvelle classe</option>";
    foreach ($lesClasses as $uneClasse):
        echo "<option value='";
        echo $uneClasse['NoClasse'];
        echo "'>";
        echo $uneClasse['Nom'];
        echo "</option>";
   endforeach;
echo "</select></td></tr>";
echo "<tr><td></td><td><input type='submit' name='envoyer' value='charger une classe'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
?>