<?php
    echo '<div class="container">';
    echo '<h1 id="encadre">'.$unEvenementMarchand['TxtHTMLEntete'].'</h1>';
    echo '</br>';
    echo '<h2>'.$unEvenementMarchand['TxtHTMLCorps'].'</h2>';
    echo '</br>';
    echo        '<div class="row">';
    echo            '<div class="col-lg-12">';
                        if(!empty($lesProduits))
                        {
                            foreach($lesProduits as $unProduit)
                            {
                                $leNoProduit        = $unProduit->NoProduit;
                                $libelle            = $unProduit->LibelleCourt;
                                $libHTML            = $unProduit->LibelleHTML;
                                $prix               = $unProduit->Prix;
                                $image              = $unProduit->Img_Produit;  
                                $leNoEvenement      = $unProduit->NoEvenement;
                                $lAnnee             = $unProduit->Annee;
                                $adress             = "$leNoEvenement/$lAnnee/$leNoProduit";
    echo                        '<div class="col-sm-4 col-lg-4 col-md-4">';
    echo                            '<div class="thumbnail">';
    echo                                '<h1 id="encadre">'.$libelle.'</h1>';
    echo                                '</br>';
    echo                                '<img width="200" src="'.base_url().'assets/images/'.$image.'"class="img-thumbnail" />';
    echo                                '</br>';
    echo                                    '<div class="caption">';
    echo                                        '<h4 class="pull-right">'.number_format($prix,2, ',',' ').'€</h4>';
    echo                                        '<p>'.$libHTML.'</p>';                    
    echo                                 '</div>';
    echo                                 '<div class="col-md-5">';
    echo                                     '<input type="number" name="Qty" id="<?php echo $row->NoProduit;?>" value="1" class="quantity form-control">';
    echo                                 '</div>';
    echo                                 '<div class="atc">';
    echo                                    '<a  href="';
                                                echo site_url('visiteur/ajoutPanier/'.$leNoProduit);
                                                echo '">'; 
    echo                                        '<button class="btn">Ajouter au panier</button>';
    echo                                    '</a>';
    echo                                '</div>';
    echo                            '</div>';
    echo                        '</div>';
                            } 
                        }           
    echo                '<div class="row">';
    echo                    '<div class="col-lg-12" >';
    echo                        '<h4>Votre Panier</h4>';
    echo                         '<a align="right" href="';
    /* echo site_url($adress);  */
    echo                                '" class="cart-link" title="View Cart">';
    echo                                '<i class="glyphicon glyphicon-shopping-cart"></i>';
    echo                                '<span>';
                                            echo $this->cart->total_items(); 
    echo                                '</span>';
    echo                          '</a>';
    echo                          '<table class="table table-striped">';
    echo                                '<thead>';
    echo                                    '<tr>';
    echo                                        '<td>Produit</td>';
    echo                                        '<td>libellé </td>';
    echo                                        '<td>Prix </td>';
    echo                                        '<td>Quantité</td>';
    echo                                        '<td>Votre Total</td>';
    echo                                        '<td>Vos Actions</td>';
    echo                                    '</tr>';
    echo                                '</thead>';
    echo                                '<tbody>';
                                            if($this->cart->total_items() > 0)
                                            {
                                                foreach($prodPanier as $produit)
                                                { 
    echo                                            '<tr>';
    echo                                                '<td>';
    echo                                                    '<img src="'.$produit["image"].'" width="50" />';
    echo                                                '</td>';
    echo                                                '<td>'.$produit["name"].'</td>';
    echo                                                '<td>'.$produit["price"].'€</td>';         
    echo                                                '<td>'.$produit["qty"].'</td>';
    echo                                                '<td>'.$produit["subtotal"].'€</td>';
    echo                                                '<td>';
    echo                                                    '<a href="';
                                                                echo site_url('visiteur/removeItem'.$produit["rowid"]);
    echo                                                        '"><i class="glyphicon glyphicon-trash"></i></a>';
    echo                                                '</td>';
    echo                                            '</tr>';
                                                } 
                                            }
                                            else
                                            { 
    echo                                        '<tr>';
    echo                                            '<td colspan="6"><p> your cart is empty ....</p></td>';
    echo                                        '</tr>';
                                            }
    echo                                '</tbody>';
    echo                            '</table>';
    echo                            '<button class="btn btn-primary">PASSER COMMANDE</button>';
    echo                       '</div>';
    echo                '</div>';
    echo '<h2>'.$unEvenementMarchand['TxtHTMLPiedDePage'].'</h2>';
    echo '</br>';
    echo '<p>'.img($unEvenementMarchand['ImgPiedDePage']).'<p>';
    echo '</br>';
    echo '<h2>'.$unEvenementMarchand['DateMiseHorsLigne'].'</h2>';
    echo '</br>';
    echo '<p>'.anchor('visiteur/catalogueEvenement','Retour à la liste des evenements').'</p>'; 
    echo '</div>';   
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
?> 
a refaire
echo''; '""'
echo '<a  href="';
        echo site_url("visiteur/addToCart/".$LesProduits["NoProduit"]);
        echo '">'; ?>

    echo '<table>';
    echo '<tr>';
    echo '<th>';
    echo '</th>'; 
    echo '</tr>'; 
    echo '</tr>';
    echo '</table>';
echo '</div>';


*/?>
<script>
function updateCartItem(obj,rowid)
{
    $.get("<?php echo site_url('visiteur/updateItemQty'); ?>", 
    {rowid:rowid, qty:obj.value},
    function(resp)
    {
        if(resp == 'ok')
        {
            location.reload();
        }
        else
        {
            alert('cart update failed, please try again.');
        }

    });
}
</script>
