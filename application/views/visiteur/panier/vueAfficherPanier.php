<div class="container"><br /><!-- div  1 -->
		<div class="col-lg-6 col-md-6"><!-- div  2 -->
			<div class="table-responsive"><!-- div  3 -->
				<h4>Nos Produits</h4>	
                <?php foreach ($product as $row)
				{
                    echo '<h4>'.$row->LibelleCourt.'</h4>';
                    echo '<h3>'.$row->Prix.'</h3>';
                    echo '<button type="button" name="ajout" onClick= id='.$row->NoProduit.'> Ajouter</button>';
						
                }
                ?>
            </div><!-- /div  3 -->
		</div><!-- /div  2 -->
    </div><!-- /div  1 -->
<?php echo form_open('visiteur/majPanier');?>
<!--$variable=resultat function js
$hidden=array('button'=>$variable)
echo form_hidden($hidden)
-->
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
        <th>QTY</th>
        <th>Item Description</th>
        <th style="text-align:right">Item Price</th>
        <th style="text-align:right">Sub-Total</th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $items): ?>

        <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

        <tr>
                <td><?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
                <td>
                        <?php echo $items['name']; ?>

                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

                                <p>
                                        <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

                                                <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

                                        <?php endforeach; ?>
                                </p>

                        <?php endif; ?>

                </td>
                <td style="text-align:right"><?php echo $this->cart->format_number($items['price']); ?></td>
                <td style="text-align:right">$<?php echo $this->cart->format_number($items['subtotal']); ?></td>
        </tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Total</strong></td>
        <td class="right">$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>

</table>

<p><?php echo form_submit('', 'Update your Cart'); ?></p>
</body>
</html>