<?php
echo "Nombre d'article dans votre panier : ".$this->cart->total_items();
if($this->cart->contents())
{
    $data = array();
    $lesProduits = $this->cart->contents();
    foreach($lesProduits as $unProduit)
    {
        $data[] = $unProduit['LibelleCourt'] . ' - Quantité : ' . $unProduit['qty'] . ' - Prix : ' . $unProduit['Prix'] . '€ ==> ' .anchor('visiteur/suppressionDuPanier' . $unProduit['rowid []'], 'X')  ;
    }
    echo "<ul>";
    echo $data;
    echo "</ul>";
    echo "</br>";
    echo "</br>";
    echo "Total à payer : " . $this->cart->total() . ' € ';
}
else
{
    echo "<span class=error>Panier Vide</span>";
}
?>
<h2>Menu</h2>
<?php
echo anchor('visiteur/accueil', 'Accueil');
echo "<br>";
echo anchor('visiteur/catalogueProduits','lister les produits commandables');
echo "<br>";
echo anchor('visiteur/panier', 'consultation du panier');
echo "<br>";
echo anchor('visiteur/viderPanier', 'suppression du panier');
?>