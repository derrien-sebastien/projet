<!-- 
	Données entrantes :

	- $product

	Données sortantes

	
-->
	<div class="container"><br /><!-- div  1 -->
		<div class="col-lg-6 col-md-6"><!-- div  2 -->
				<div class="table-responsive"><!-- div  3 -->
					<h4>Nos Produits</h4>	
					<?php foreach ($product as $row)
					{
						echo '
							<div class="col-md-4" style="padding:16px;
								background-color:#f1f1f1; border:1px solid #ccc;
								margin-bottom:16px; height:400px" align="center">
								<img src="'.base_url().'assets/images/'.$row->Img_Produit.'"
								class="img-thumbnail" /><br />
								<h4>'.$row->LibelleCourt.'</h4>
								<h3 class="text-danger">'.$row->Prix.'</h3>
								<input type="text" name="quantity" class="quantity" id="'.$row->NoProduit.'">
								<button type="button" name="add_cart" class="btn 
								btn-success add_cart" data-productname="'.$row->LibelleCourt.'" 
								data-price="'.$row->Prix.'" data-productid="'.$row->NoProduit.'" />Ajouter</button>
							</div>';
					}
					
					?>
				</div><!-- /div  3 -->
		</div><!-- /div  2 -->
		<div class="col-lg-6 col-md-6"><!-- div  2 bis -->
			<div id="cart_cetails"><!-- div  3 bis -->
				
				<h3>Cart is Empty</h3>
				<?php echo form_open('path/to/controller/update/method'); ?>

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
				<?php  echo $this->cart->format_number($this->cart->total_items());?>
			</div><!-- /div  3 bis -->
		</div><!-- /div  2 bis -->
	</div><!-- /div  1 -->
</body>
</html>
<script>
	$(document).ready(function(){
		$('.add_cart').click(function(){
			var NoProduit = $(this).data("productid");
			var LibelleCourt  = $(this).data("productname");
			var Prix = $(this).data("price");
			var quantity = $('#' + NoProduit).val();
			if(quantity != '' && quantity > 0)
			{
				
				$.ajax({
					url:"<?php echo site_url('visiteur/add')?>",
					method:"POST",
					data: {NoProduit:NoProduit, LibelleCourt:LibelleCourt, Prix:Prix, quantity:quantity},
					success: function(data)
					{
						alert("Produit ajouté au panier");
						$('#cart_details').html(data);
						$(quantity).val();
					}
				});
			}
			else
			{
				alert("Saisissez une quantité");
			}
			
		});
	});
	$('#cart_details').load("<?php echo base_url(); ?>shopping_cart/load");

 $(document).on('click', '.remove_inventory', function(){
  var row_id = $(this).attr("id");
  if(confirm("Vous allez retirer l'article. Vous confirmez ?"))
  {
   $.ajax({
    url:"<?php echo site_url('visiteur/remove')?>",
    method:"POST",
    data:{row_id:row_id},
    success:function(data)
    {
     alert("Article retiré du panier");
     $('#cart_details').html(data);
    }
   });
  }
  else
  {
   return false;
  }
 });

 $(document).on('click', '#clear_cart', function(){
  if(confirm("Are you sure you want to clear cart?"))
  {
   $.ajax({
    url:"<?php echo base_url(); ?>shopping_cart/clear",
    success:function(data)
    {
     alert("Your cart has been clear...");
     $('#cart_details').html(data);
    }
   });
  }
  else
  {
   return false;
  }
 });
</script>

