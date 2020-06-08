<?php
/*donnée d'entrée: lesProduits array table classe 
*/
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$submit=array(
    'name'      =>'submit',
    'value'     =>'Ajouter au panier',
    'class'     =>'btn btn-primary'
    
);
$qty = array(
    'min'           =>  '0',
    'step'          =>  '1',
    'type'          =>  'number', 
    'name'          =>  'qty',
    'value'         =>  '1',
    'size'          =>  '5'
);  

echo '</br>';
echo '</br>';
echo "<thead>\n";
    echo '<div class="container-fluid" align="center" width="80%">';// div 1
        echo '<tr>';
            echo '<td>';
                echo '<div align="center">';
                    echo '<h1>'.$unEvenementMarchand['TxtHTMLEntete'].'</h1>';
                echo '</div>';
            echo '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>';
                echo '<h2>'.$unEvenementMarchand['TxtHTMLCorps'].'</h2>';
            echo '</td>';
        echo '</tr>';
    echo '</div>';// fin div 1
echo "</thead>";
echo "<tbody>";

echo '<div class="col-lg-12">';
////////////////////////////// Déclaration de nos Variables ////////////////////////////

    if(isset($lesProduits))
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
            $adress             = $leNoEvenement.'X'.$lAnnee.'X'.$leNoProduit;
            $hidden=array(
                'adress'=>$adress
            );
            echo '<div class="col-sm-3 col-lg-4 col-md-3">';
                echo '<div align="center">';           
                    echo '<h3 class="encadre" align="center">' .$libelle.'</h3>';
                    echo '</br>';
                    if(empty($image))
                    {
                        echo '<img class="pull-left" width="150" src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" />';
                    }
                    else
                    {
                        echo '<img class="pull-left" width="150" src="'.base_url().'assets/images/'.$image.'"class="img-thumbnail" />';
                    } 
                    echo '<div class="caption" align="right">';
                        echo '<h3>'.$libHTML.'</h3>';
                        echo '</br>';
                        echo '<h4>'.number_format($prix,2, ',',' ').'€</h4>';
                        echo '</br>';
    ///////////////////////////////   FORMULAIRE   //////////////////////////////////////// 
                        echo form_open('Visiteur/ajoutPanier');
                        echo form_hidden($hidden);
                        echo '<div align="center">';
                            echo form_input($qty);
                        echo '</div>';
                        echo '</br>';
                        echo '<div align="center">';
                            echo form_submit($submit);
                        echo '</div>';
                        echo form_close();
    //////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    } 
echo '</div>';
echo '</tbody>';
echo "<tfoot\n";
    echo '<div class="container">';
        echo '<tr>';
            echo '<td>';
                echo '<h2 align="center">'.$unEvenementMarchand['TxtHTMLPiedDePage'].'</h2>';
            echo '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>';
                echo '<h2 align="center">Cet évènement se termine le '.$unEvenementMarchand['DateMiseHorsLigne'].'</h2>';
            echo '</td>';
        echo '</tr>'; 
    echo '</div>';
echo '</tfoot\n'; 
echo form_close();
echo '</br>';
echo '<div align="center">';
    echo '<a href="';
        echo site_url('Visiteur/catalogueEvenement');
        echo '"><button class="btn btn-primary">Retour au catalogue</button>';
    echo '</a>';
    echo '&emsp;';
    echo '<a href="';
        echo site_url('Visiteur/panier');
        echo '"><button class="btn btn-primary">Voir le panier</button>';
    echo '</a>';
echo '</div>';
echo '</br>';
echo '</br>';
echo form_close();
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
    <!-- echo '<div class="col-sm-4 col-lg-4 col-md-4">';
        echo '<div class="thumbnail">';
            echo '<h3 class="encadre" align="center">Votre Panier</h3>';
            echo '<a align="right" href="';
                echo site_url('Visiteur/panier'); 
                echo '" class="cart-link" title="View Cart">';
                echo '<i class="glyphicon glyphicon-shopping-cart"></i>';
                echo '<span>';
                    echo $this->cart->total_items(); 
                echo '</span>';
            echo '</a>';
            echo '<table class="table table-striped">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<td>Produit</td>';
                        echo '<td>libellé </td>';
                        echo '<td>Prix </td>';
                        echo '<td>Quantité</td>';
                        echo '<td>Votre Total</td>';
                        echo '<td>Vos Actions</td>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                    if($this->cart->total_items() > 0)
                    {
    ////////////////////////////// Déclaration de nos variables pour le PANIER ////////////////////////////
                        foreach($this->cart->contents() as $produit)
                        { 
                            echo '<tr>';
                                echo '<td><img src="'.base_url().'assets/images/'.$produit["image"].'"class="img-thumbnail" width="75"/></td>';
                                echo '<td>'.$produit["name"].'</td>';
                                echo '<td>'.$produit["price"].'€</td>';         
                                echo '<td>'.$produit["qty"].'</td>';
                                echo '<td>'.$produit["subtotal"].'€</td>';
                                echo '<td>';
                                    echo '<a href="';
                                        echo site_url('Visiteur/removeItem/'.$produit['rowid']);
                                        echo '"><i class="glyphicon glyphicon-trash"></i>';
                                    echo '</a>';
                                echo '</td>';
                            echo '</tr>';
                        } 
                    }
                    else
                    { 
                        echo '<tr>';
                            echo '<td colspan="6"><p>Aucun produit</p></td>';
                        echo '</tr>';
                    }
                echo '</tbody>';
            echo '</table>';
            if($this->cart->total_items() > 0)
            {
                echo '<a href="';
                    echo site_url('Visiteur/passerCommande');
                    echo '"><button class="btn btn-primary">PASSER COMMANDE</button>';
                echo '</a>';
                echo " \n ";
                echo '<a href="';
                    echo site_url('Visiteur/viderPanier/'.$unEvenementMarchand['NoEvenement'].'/'.$unEvenementMarchand['Annee']);                   
                    echo '"><button class="btn btn-primary">vider panier</button>';
                echo '</a>';
            }      
        echo '</div>';
    echo '</div>'; --> 