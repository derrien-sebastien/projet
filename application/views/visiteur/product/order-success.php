<div class="container">
    <h2> Statut de la commande</h2>
        <p class="ord-succ">Vérifiez les informations</p>
        <div class="row col-lg-12 ord-addr-info">
            <div class="col-sm-6 adr">
                <div class="hdr">Vos données transmises</div>
                    <p><?php echo $order['Nom']; ?></p>
                    <p><?php echo $order['Email']; ?></p>
                    <p><?php echo $order['TelPortable']; ?></p>
                    <p><?php echo $order['Ville']; ?></p>
                </div>
                <div class="col-sm-6 info">
                    <div class="hdr">Votre commande</div>
                        <p><b>Reference du produit</b> :<?php echo $order['LibelleCourt']; ?></p>
                        <p><b>Total à payer</b> :<?php  $order['MontantTotal'].'€'; ?></p>
                    </div>
                </div>
                <div class="row ord-items">
                    <?php if(!empty($order['items']))
                    {
                        foreach($order['items'] as $item)
                        {?>
                            <div class="col-lg-12 item">
                                <div class="col-sm-2">
                                    <div class="img" style="height: 75px; width: 75px;">
                                        <?php $imageURL = !empty($item["Img_Produit"])?base_url('uploads/product_images/'.$item["Img_Produit"]):base_url('assets/images/essai.svg'); ?>
                                        <img src="<?php echo $imageURL ?>" width="75" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <p><b><?php echo $item["name"]; ?></b></p>
                                <p><?php echo $item["price"].'€'; ?></p>
                                <p>Quantité commandée<?php echo $item["quantity"]; ?></p>
                            </div>
                            <div class="col-sm-2">
                                <p><b><?php echo $item["sub_total"].'€'; ?></b></p>
                            </div>
                <?php } } ?>
            </div>
        </div>
</div>