
<?php
/* donnée entrée
    -provenance
    -lesProduits

   donnée sortie
    -provenance
    -produit
*/
$hidden=array(
    'provenance'=>$provenance
);

$produit=array(
    '0/0/0'=>'Nouveau produit'
);

foreach ($lesProduits as $unProduit)
{
    $valeur=$unProduit->Annee."/".$unProduit->NoEvenement."/".$unProduit->NoProduit;
    $produit[$valeur]=$unProduit->Annee."   ".$unProduit->LibelleCourt;
}
$submit=array(
    'name'=>'existant',
    'value'=>'charger un formulaire existant'
);

echo form_open('Administrateur/formulaireProduit');
echo form_hidden($hidden);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<table>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('choisissez:','produit');
        echo"</td>";
        echo "<td>";
            echo form_dropdown('produit',$produit);
        echo "</td>";
    echo"</tr>";
    echo "<tr>";
        echo "<td>";
        echo "</td>";
        echo "<td>";
            echo form_submit($submit);
        echo "</td>";
    echo "</tr>";
echo "</table>";
echo form_close();
?>