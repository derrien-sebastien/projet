<div>
<?php
$data=array();
for($i=0;$i<=count($produit)-1;$i++)
{
    $data[]= anchor('visiteur/ajouterProduitAuPanier'.$produit[$i]['NoProduit'], $produit[$i]['LibelleCourt']);
}
echo ($data);
?>
</div>
<div>
    <h2>Menu</h2>
</div>