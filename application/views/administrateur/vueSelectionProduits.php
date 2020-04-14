</br>
<?php
echo form_open('Administrateur/formulaireProduit');
echo "<table>\n";
echo "<tr><td><label for='produit'>choisissez:</label></td>
<td><select name='Produit'>
    <option value='/////////'>Aucun produit selectionné</option>
    <option value='/////////'>Nouveau produit</option>";
    foreach ($lesProduit as $unProduit):
        echo "<option value='";
        echo $unProduit->NoEvenement."/".$unProduit->NoProduit."/".$unProduit->LibelleHTML
        ."/".$unProduit->LibelleCourt."/".$unProduit->Prix."/".$unProduit->Img_Produit."/".$unProduit->Stock
        ."/".$unProduit->NumeroOrdreApparition."/".$unProduit->Etre_Ticket."/".$unProduit->ImgTicket;
        echo "'>";
        echo $unProduit->LibelleCourt;
        echo "</option>";
   endforeach;
echo "</select></td></tr>";
echo "<tr><td></td><td><input type='submit' name='existant' value='charger un formulaire existant'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
?>