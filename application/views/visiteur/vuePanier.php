<?php
echo '<br>';
echo '<div class="container">';
echo    '<div class="row">';
echo       '<div class="col-lg-12" >';
echo            '<h1 class="encadre">Votre Panier</h1>';
echo            '<br>';
echo            '<table class="table table-dark">';
echo                '<thead>';
echo                    '<tr>';
echo                        '<td align="center">Produit</td>';
echo                        '<td align="center">libellé </td>';
echo                        '<td align="center">Prix </td>';
echo                        '<td align="center">Quantité</td>';
echo                        '<td align="center">Votre Total</td>';
echo                        '<td align="center">Vos Actions</td>';
echo                    '</tr>';
echo                '</thead>';
echo                '<tbody class="table table-dark">';
                        if($this->cart->total_items() > 0)
                        {
////////////////////////////// Déclaration de nos Variables ////////////////////////////
                            foreach($this->cart->contents() as $produit)
                            { 
echo                            '<tr>';
echo                                '<td align="center">';
echo                                    '<img src="'.base_url().'assets/images/'.$produit["image"].'"class="img-thumbnail" width="75"/>';
echo                                '</td>';
echo                                '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["name"].'</td>';
echo                                '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["price"].'€</td>';         
echo                                '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["qty"].'</td>';
echo                                '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["subtotal"].'€</td>';
echo                                '<td style="color:rgb(128, 122, 122);"align="center">Supprimer';
echo                                    '<a href="';
                                            echo site_url('Visiteur/removeItem/'.$produit['rowid'].'/'. $produit['adress']);
echo                                        '" ><i class="glyphicon glyphicon-trash"></i>';
echo                                    '</a>';
echo                                '</td>';
echo                            '</tr>';
                            } 
                        }
                        else
                        { 
echo                        '<tr>';
echo                            '<td colspan="6" style="color:rgb(128, 122, 122);"align="center"><p> Aucun Produit</p></td>';
echo                        '</tr>';
                        }
echo                '</tbody>';
echo            '</table>';
echo            '<div align="center">';
echo                '<a href="';
                        echo site_url('Visiteur/passerCommande');
echo                    '"><button class="btn btn-primary">PASSER COMMANDE</button>';
echo                '</a>';
echo                " \n ";
echo                '<a href="';
                        echo site_url('Visiteur/viderPanier/'.$unEvenementMarchand['NoEvenement'].'/'.$unEvenementMarchand['Annee']);               
echo                    '"><button class="btn btn-primary">VIDER LE PANIER</button>';
echo                '</a>';
echo            '</div>';
echo        '</div>';
echo    '</div>'; 
echo '</div>';

?>
<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->
    <script>
        function updateCartItem(obj,rowid)
        {
            $.get("<?php echo site_url('Visiteur/updateItemQty'); ?>", 
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
