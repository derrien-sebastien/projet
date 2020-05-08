<!doctype html>
    <html lan="en-US">
        <head>
            <title>Shopping cart</title>
        
        <meta charset="utf-8">

        <link href="https://maxcdn.bootstrpcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
            rel="stylesheet">
        <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            function updateCartItem(obj,rowid){
                $.get("<?php echo base_url('index.php/Cart/updateItemQty')
                    ; ?>", {rowid:rowid, qty:obj.value}, function
                    (resp){
                        if(resp == 'ok'){
                            location.reload();
                        }else{
                            alert('cart update failed, please try again.');
                        }

                    });
            }
        </script>
    </head>
    <body>
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
                            foreach($cartItems as $item){ ?>
                                <tr>
                                    <td>
                                        <?php $imageURL = !empty($item["Img_Produit"])?base_url('uploads/product_images/'.$item["Img_Produit"]):base_url('assets/images/essai.svg'); ?>
                                        <img src="<?php echo $imageURL ?>" width="50" />
                                    </td>
                                    <td><?php echo $item["name"]; ?></td>
                                    <td><?php echo $item["price"].'€'; ?></td>         
                                    <td><!-- <input type="number" class="
                                    form-control text-center" value=" -->
                                    <?php echo $item["qty"]; ?><!-- " onchange
                                    ='updateItemQty(this, "<?php /* echo $item["rowid"]; */ ?>")'> --></td>
                                    <td><?php echo $item["subtotal"].'€'; ?></td>
                                    <td>
                                        <a href="<?= base_url().'index.php/Cart/removeItem/'.$item['rowid']; ?>">
                                            <button class="btn btn-primary btn-sm"><i class="fa fa-times" aria-hidden="true">Retirer du panier</i></button>
                                        </a>
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
                            <td><a href="<?php echo site_url('Products/index'); ?>" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-menu-left"></i>Continuer</a></td>
                            <td colspan="3"></td>
                            <?php if($this->cart->total_items() > 0){?>
                                <td class="text-left">Total à payer: <b><?php echo $this->cart->total().'€'; ?></b></td>
                                <td><a href="<?php echo base_url('index.php/checkout/'); ?>" class="btn btn-primary btn-sm">Commander<i class="glyphicon glyphicon-menu-right"></i></a></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>
            </div>    
        </div>
    </body> 
    </html>