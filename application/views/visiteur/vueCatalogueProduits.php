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
								<img src="'.base_url().'assets/images/'.$row['Img_Produit'].'"
								class="img-thumbnail" /><br />
								<h4>'.$row['LibelleCourt'].'</h4>
								<h3 class="text-danger">'.$row['Prix'].'</h3>
								<input type="text" name="quantity" class="quantity" id="'.$row['NoProduit'].'">
								<button type="button" name="add_cart" class="btn 
								btn-success add_cart" data-productname="'.$row['LibelleCourt'].'" 
								data-price="'.$row['Prix'].'" data-productid="'.$row['NoProduit'].'" />Ajouter</button>
							</div>';
					}
					
					?>
				</div><!-- /div  3 -->
		</div><!-- /div  2 -->
	
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
					url:"<?php echo site_url('visiteur/addToCart')?>",
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

