</br>
<a align="right" href="<?php echo site_url('visiteur/panier'); ?>" class="cart-link" title="View Cart">
    <i class="glyphicon glyphicon-shopping-cart"></i>
    <span><?php echo $this->cart->total_items(); ?></span>
</a>
<?php
        echo '<h1>'.$unEvenementMarchand['TxtHTMLEntete'].'</h1>';
        echo '</br>';
        echo '<h2>'.$unEvenementMarchand['TxtHTMLCorps'].'</h2>';
        echo '</br>';
        echo '<div class="container">';
        echo    '<div class="col-md-4">';
        echo            '<div class="thumbnail">';
        echo                    '<div class="caption">';
        echo                            $LesProduits['LibelleCourt'];
        echo '</br>';
        echo '<img width="200" '.img($LesProduits['Img_Produit']).'';
        echo '</br>';
        echo                                    '<div class="row">';
        echo                                            '<div class="col-md-7">';
        echo                                                    $LesProduits['Prix'],'€';
        echo                                            '</div>';
        echo                                            '<div class="col-md-5">';
        echo                                                    '<input type="number" name="quantity" id="<?php echo $row->NoProduit;?>" value="1" class="quantity form-control">';
        echo                                            '</div>';
        echo                                    '</div>';
        echo                            '<button class="add_cart btn btn-primary btn-block" data-productid="<?php echo $row->NoProduit;?>" data-productname="<?php echo $row->LibelleCourt;?>" data-productprice="<?php echo $row->Prix;?>">Ajouter</button>';
        echo                    '</div>';
        echo              '</div>';
        echo     '</div>';
        echo     '<div class="col-md-4">';
        echo            '<h4>Votre Panier</h4>';?>
                            <a align="right" href="<?php echo site_url('visiteur/panier'); ?>" class="cart-link" title="View Cart">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                <span><?php echo $this->cart->total_items(); ?></span>
                            </a>
        <?php       
        echo                    '<table class="table table-striped">';
        echo                            '<thead>';
        echo                                    '<tr>';
        echo                                            '<th>Produit Choisi</th>';
        echo                                            '<th>Prix du produit</th>';
        echo                                            '<th>Quantité choisie</th>';
        echo                                            '<th>Votre Total</th>';
        echo                                            '<th>Vos Actions</th>';
        echo                                    '</tr>';
        echo                            '</thead>';
        echo                            '<tbody id="detail_cart">';
        echo                            '</tbody>';
        echo                    '</table>';
        echo                    '<button class="btn btn-primary">PASSER COMMANDE</button>';
        echo     '</div>';
        echo     '</div>';
        echo '<h2>'.$unEvenementMarchand['TxtHTMLPiedDePage'].'</h2>';
        echo '</br>';
        echo '<p>'.img($unEvenementMarchand['ImgPiedDePage']).'<p>';
        echo '</br>';
        echo '<h2>'.$unEvenementMarchand['DateMiseHorsLigne'].'</h2>';
        echo '</br>';
        echo '<p>'.anchor('visiteur/catalogueEvenement','Retour à la liste des evenements').'</p>';    
        ?>       
        <?php
/* $data=array();
for($i=0;$i<=count($LesProduits)-1;$i++)
{
    $data[]= anchor('visiteur/ajouterProduitAuPanier'.$LesProduits[$i]['NoProduit'], $LesProduits[$i]['LibelleCourt']);
}
echo ($data);
?>
</div>
<div>
    <h2>Menu</h2>
</div>
<?php
echo anchor('visiteur/accueil', 'Accueil');
echo "<br>";
echo anchor('visiteur/catalogueProduits','lister les produits commandables');
echo "<br>";
echo anchor('visiteur/panier', 'consultation du panier');
echo "<br>";
echo anchor('visiteur/viderPanier', 'suppression du panier');
?> */