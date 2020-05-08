
    <div class="container">
        <h2 align="center" >Votre Panier</h2>
        <div class="row cart">
            <table class="table">
                <thead>
                    <tr>
                        <th width="10%"></th>
                        <th width="30%">Produit</th>
                        <th width="15%">Prix</th>
                        <th width="13%">Quantité</th>
                        <th width="20%">Total</th>
                        <th width="12%"></th>       
                    </tr>
                </thead>
                <tbody>
                    <?php if($this->cart->total_items() > 0){
                        foreach($prodPanier as $item){ ?>
                            <tr>
                                <td>
                                    <?php $imageURL = !empty($item["Img_Produit"])?base_url('uploads/product_images/'.$item["Img_Produit"]):base_url('assets/images/essai.jpeg'); ?>
                                    <img src="<?php echo $imageURL ?>" width="50" />
                                </td>
                                <td><?php echo $item["name"]; ?></td>
                                <td><?php echo $item["price"].'€'; ?></td>         
                                <td><?php echo $item["qty"]; ?> </td>
                                <td><?php echo $item["subtotal"].'€'; ?></td>
                                <td>
                                    <a href="<? echo site_url('visiteur/removeItem'.$item["rowid"]); ?>" ><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                        <?php } }else{ ?>
                        <tr>
                            <td colspan="6"><p> your cart is empty ....</p></td>
                        </tr>
                        <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><a href="<?php  /* echo site_url('visiteur/EvenementMarchand/'.$unEvenementMarchand['NoEvenement'].'/'.$unEvenementMarchand['Annee']); */ ?>" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i>Continuer</a></td>
                        <td colspan="3"></td>
                        <?php if($this->cart->total_items() > 0){?>
                            <td class="text-left">Total à payer: <b><?php echo $this->cart->total().'€'; ?></b></td>
   <!--connection-->        <td><a href="<?php echo base_url('checkout/'); ?>" class="btn btn-success btn-block">Commander<i class="glyphicon glyphicon-menu-right"></i></a></td>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
        </div>    
    </div>
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
