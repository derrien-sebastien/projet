
<?php
$hidden=array(
    'provenance'=>$provenance
);
echo form_open('Administrateur/formulaireProduit');
echo form_hidden($hidden);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<table>\n";
echo "<tr><td><label for='produit'>choisissez:</label></td>
<td><select name='produit'>
    <option value='/////////'>Aucun produit selectionné</option>
    <option value='/////////'>Nouveau produit</option>";
    foreach ($lesProduits as $unProduit):
        echo "<option value='";
        echo $unProduit->Annee."/".$unProduit->NoEvenement."/".$unProduit->NoProduit;
        echo "'>";
        echo $unProduit->LibelleCourt;
        echo "</option>";
   endforeach;
echo "</select></td></tr>";
echo "<tr><td></td><td><input type='submit' name='existant' value='charger un formulaire existant'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
?>