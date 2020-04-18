<?php
session_start();
/* Initialisation du panier */
if(!isset($_SESSION['panier']))
{
        $_SESSION['panier'] = array();
        /* Subdivision du panier */
        $_SESSION['panier']['id'] = array();
        $_SESSION['panier']['qty'] = array();
        $_SESSION['panier']['name'] = array();
        $_SESSION['panier']['price'] = array();
}
array_push($_SESSION['panier']['id'],$select['id']);
array_push($_SESSION['panier']['qty'],$select['qty']);
array_push($_SESSION['panier']['name'],$select['name']);
array_push($_SESSION['panier']['price'],$select['price']);

?>

<?php
var_dump($_SESSION['panier']);
?>
<?php echo form_open('path/to/controller/update/method'); ?>

<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
        <th>Quantité</th>
        <th> Description du produit</th>
        <th style="text-align:right">Prix Produit<?php echo $unProduit->Prix;?></th>
        <th style="text-align:right">Total </th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $UnProduit): ?>

        <?php echo form_hidden($i.'[rowid]', $UnProduit['rowid']); ?>

        <tr>
                <td>
                    <?php echo form_input(array('name' => $i.'[qty]', 'value' => $UnProduit['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                </td>
                <td>
                        <?php echo $UnProduit['name']; ?>
                        <?php if ($this->cart->has_options($UnProduit['rowid']) == TRUE): ?>
                                <p>
                                        <?php foreach ($this->cart->product_options($UnProduit['rowid']) as $option_name => $option_value): ?>
                                                <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />
                                        <?php endforeach; ?>
                                </p>

                        <?php endif; ?>

                </td>
                <td style="text-align:right">
                    <?php echo $this->cart->format_number($UnProduit['price']); ?>
                </td>
                <td style="text-align:right"><?php echo $this->cart->format_number($UnProduit['subtotal']); ?></td>
        </tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Résumé Commande</strong></td>
        <td class="right">$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>

</table>

<p><?php echo form_submit('', 'Update your Cart'); ?></p>