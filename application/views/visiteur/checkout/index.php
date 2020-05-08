
        <div class="container" align="center">
            <h2 align="center" >Votre Commande</h2>
            <div class="row checkout" align="center">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="13%"></th>
                            <th width="34%">Produit</th>
                            <th width="18%">Prix</th>
                            <th width="13%">Quantité</th>
                            <th width="22%">Total</th>      
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
                            <td colspan="6"><p> Rien à commander</p></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <form class="form-horizontal" method="post" align="center">
                    <div class="ship-info" align="center">
                        <h4>Vos Informations</h4>
                        <div class="form-group" align="center">
                            <label class="control-label col-sm-2">Nom </label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" name="Nom" value="<?php echo !empty($custData['name'])?$custData['name']:''; ?>" placeholder="nom">
                                <?php echo form_error('name','<p class="help-block error">','</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Email</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control" name="Email" value="<?php echo !empty($custData['email'])?$custData['email']:''; ?>" placeholder="adresse mail">
                                    <?php echo form_error('Email','<p class="help-block error">','</p>'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Tel</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control" name="TelPortable" value="<?php echo !empty($custData['phone'])?$custData['phone']:''; ?>" placeholder="numéro de téléphone">
                                    <?php echo form_error('phone','<p class="help-block error">','</p>'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Adresse</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control" name="Ville" value="<?php echo !empty($custData['address'])?$custData['address']:''; ?>" placeholder="numéro de téléphone">
                                    <?php echo form_error('address','<p class="help-block error">','</p>'); ?>
                                </div>
                        </div>   
                    </div>
                    <div class="footBtn">
                        <a href="<?php echo site_url('Products/'); ?>" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-menu-left"></i>Continuer vos achats</a>
                        <a href="<?php echo site_url('Checkout/placeOrder'); ?>" class="btn btn-primary btn-sm">Envoyer Commande<i class="glyphicon glyphicon-menu-right"></i></a>
                    </div>
                </form>
            </div>
        </div>