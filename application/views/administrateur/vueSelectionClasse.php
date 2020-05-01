<?php
/*donnée d'entrée: lesClasses array table classe 
*/
$classe=array(
    '0'=>'Nouvelle classe'
);
foreach ($lesClasses as $uneClasse)
{
    $noClasse=$uneClasse['NoClasse'];
    $nom=$uneClasse['Nom'];
    $classe[$noClasse]=$nom;
}

echo form_open('Administrateur/afficherEleveClasse');//a renseigné
echo '</br>';
echo '</br>';
echo "<table>\n";
    echo '<tr>';
        echo '<td>';
            echo form_label('choisissez:','classe');
        echo '</td>';
        echo '<td>';
            echo form_dropdown('classe',$classe);
        echo '</td>';
    echo "</tr>";
    echo "<tr>";
    echo "<td></td><td><input type='submit' name='envoyer' value='charger une classe'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
?>