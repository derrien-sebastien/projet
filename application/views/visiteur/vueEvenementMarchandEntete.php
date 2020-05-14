<?php
/*donnée d'entrée: lesProduits array table classe 
*/
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$submit=array(
    'name'      =>'submit',
    'value'     =>'envoyer',
    'class'     =>'btn btn-primary'
    
);
$qty = array(
    'min'           =>  '0',
    'step'          =>  '1',
    'type'          =>  'number', 
    'name'          =>  'qty',
    'placeholder'   =>  'x 1',
    'size'          => '5'
);  

echo '</br>';
echo '</br>';
echo "<thead>\n";
echo    '<div class="container">';// div 1
echo        '<tr>';
echo            '<td>';
echo                '<h1 class="encadre">'.$unEvenementMarchand['TxtHTMLEntete'].'</h1>';
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                '<h2>'.$unEvenementMarchand['TxtHTMLCorps'].'</h2>';
echo            '</td>';
echo        '</tr>';
echo    '</div>';// fin div 1
echo "</thead>";
echo '<div class="col-lg-12">';
////////////////////////////// Déclaration de nos Variables ////////////////////////////
        foreach($lesProduits as $unProduit)
        {
            $leNoProduit        = $unProduit['NoProduit'];
            $libelle            = $unProduit['LibelleCourt'];
            $libHTML            = $unProduit['LibelleHTML'];
            $prix               = $unProduit['Prix'];
            $image              = $unProduit['Img_Produit'];  
            $leNoEvenement      = $unProduit['NoEvenement'];
            $lAnnee             = $unProduit['Annee'];
            $adress             = $leNoEvenement.'X'.$lAnnee.'X'.$leNoProduit;
$hidden=array(
    'adress'=>$adress
);
echo        '<div class="col-sm-4 col-lg-4 col-md-4">';

echo            '<div class="thumbnail">';           
echo                '<h3 class="encadre" align="center">' .$libelle.'</h3>';
echo                '</br>'; 
echo                '<img class="pull-left" width="150" src="'.base_url().'assets/images/'.$image.'"class="img-thumbnail" />';
echo                '<div class="caption">';
echo                    '<h4>Caractéristiques :</h4>';
echo                    '<p>'.$libHTML.'</p>';
echo                    '<h4>Prix :</h4><h4>'.number_format($prix,2, ',',' ').'€</h4>';
///////////////////////////////   FORMULAIRE   //////////////////////////////////////// 
echo                    form_open('Visiteur/ajoutPanier');
echo                    form_hidden($hidden);
echo                    'Quantité souhaitée :';
echo                    '<div class="quantity">';
echo                        form_input($qty);
echo                        form_submit($submit);
echo                        form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
echo                    '</div>';
echo                '</div>';
echo            '</div>';
echo       '</div>';
        }
echo   '<div class="col-sm-4 col-lg-4 col-md-4">';
echo       '<div class="thumbnail">';
echo            '<h3 class="encadre" align="center">Votre Panier</h3>';
echo                '<a align="right" href="';
                        echo site_url('Visiteur/panier'); 
echo                    '" class="cart-link" title="View Cart">';
echo                    '<i class="glyphicon glyphicon-shopping-cart"></i>';
echo                    '<span>';
                            echo $this->cart->total_items(); 
echo                    '</span>';
echo                '</a>';
echo                '<table class="table table-striped">';
echo                    '<thead>';
echo                        '<tr>';
echo                           '<td>Produit</td>';
echo                           '<td>libellé </td>';
echo                           '<td>Prix </td>';
echo                           '<td>Quantité</td>';
echo                           '<td>Votre Total</td>';
echo                           '<td>Vos Actions</td>';
echo                        '</tr>';
echo                    '</thead>';
echo                    '<tbody>';
                            if($this->cart->total_items() > 0)
                            {
////////////////////////////// Déclaration de nos variables pour le PANIER ////////////////////////////
                                foreach($this->cart->contents() as $produit)
                                { 
echo                                '<tr>';
echo                                    '<td><img src="'.base_url().'assets/images/'.$produit["image"].'"class="img-thumbnail" width="75"/></td>';
echo                                    '<td>'.$produit["name"].'</td>';
echo                                    '<td>'.$produit["price"].'€</td>';         
echo                                    '<td>'.$produit["qty"].'</td>';
echo                                    '<td>'.$produit["subtotal"].'€</td>';
echo                                    '<td>';
echo                                    '<a href="';
                                            echo site_url('Visiteur/removeItem/'.$produit['rowid'].'/'. $produit['adress']);
                                        
echo                                        '"><i class="glyphicon glyphicon-trash"></i>';
echo                                    '</a>';
echo                                    '</td>';
echo                                '</tr>';
                                } 
                            }
                            else
                            { 
echo                            '<tr>';
echo                                '<td colspan="6"><p>Aucun produit</p></td>';
echo                            '</tr>';
                            }
echo                    '</tbody>';
echo                '</table>';
echo                '<a href="';
                        echo site_url('Visiteur/passerCommande');
echo                    '"><button class="btn btn-primary">PASSER COMMANDE</button>';
echo                '</a>';
echo                " \n ";
echo                '<a href="';
                        echo site_url('Visiteur/viderPanier/'.$unEvenementMarchand['NoEvenement'].'/'.$unEvenementMarchand['Annee']);                   
echo                    '"><button class="btn btn-primary">vider panier</button>';
echo                '</a>';
echo        '</div>';
echo    '</div>'; 
echo '</div>';
echo '</div>';
echo "<tfoot\n";
echo    '<div class="container">';
echo        '<tr>';
echo            '<td>';
echo                '<h2 align="center">'.$unEvenementMarchand['TxtHTMLPiedDePage'].'</h2>';
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                '<p align="center">'.img($unEvenementMarchand['ImgPiedDePage']).'<p>';
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                '<h2 align="center">Cet évènement se termine le '.$unEvenementMarchand['DateMiseHorsLigne'].'</h2>';
echo            '</td>';
echo        '</tr>'; 
echo '</div>';
echo '</tfoot\n';
echo '</div>';  
echo '</form>';
echo '</br>';
echo '<div align="center">';
echo    '<a href="';
            echo site_url('Visiteur/catalogueEvenement');
echo        '"><button class="btn btn-primary">Retour au catalogue</button>';
echo    '</a>';
echo '</div>';
echo '</br>';
echo '</br>';
?>
<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->
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
