
<body>
<div class="container">
	<br/>
	<div class="col-lg-6 col-md-6">
		<div class="table-responsive">
			<h2>Catalogue </h2>
		
			<?php foreach ($produits->result() as $row)
			{
				echo '
					<div class="col-md-4" style="padding:16px;
						background-color:#f1f1f1; border:1px solid #ccc;
						margin-bottom:16px; height:400px" align="center">
						<img src="'.base_url().'assets/images/'.$row->Img_Produit.'"
							class="img-thumbnail" /><br />
						<h4>'.$row->LibelleCourt.'</h4>
						<h3 class="text-danger">'.$row->Prix.'</h3>
					
							<input type="text" name="quantity" class="quantity" id="'.$row->NoProduit.'"/>
						
						<button type="button" name="add_cart" class="btn 
							btn-success add_cart" data-productname="'.$row->LibelleCourt.'" 
							data-price="'.$row->Prix.'" data-productid="'.$row->NoProduit.'" />Ajouter
						</button>
					</div>';
			}?>
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div id="cart_details">
			<h3 align="center">Cart is Empty</h3>
		</div>

	</div>
				<!-- <div class="col-md-4">
					<div class="thumbnail">
						<img width="200" src="<?php /* echo base_url().'assets/images/'.$row->Img_Produit; */?>">
						<div class="caption">
							<h4><?php /* echo $row->LibelleCourt; */?></h4>
							<div class="row">
								<div class="col-md-7">
									<h4><?php /* echo ($row->Prix); */?></h4>
								</div>
								<div class="col-md-5">
									<input type="number" name="quantity" id="<?php /* echo $row->NoProduit; */?>" value="1" class="quantity form-control">
								</div>
							</div>
							<button onClick='.add_cart' class="add_cart btn btn-primary btn-block" data-productid="<?php /* echo $row->NoProduit; */?>" data-productname="<?php echo $row->LibelleCourt;?>" data-productprice="<?php echo $row->Prix;?>">Ajouter</button>
						</div>
					</div>
				</div>
			
                
            
			</div> -->

		<!-- synthese panier -->

		<!-- </div>
		<div class="col-md-4">
			<h4>Votre Panier</h4>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Produit choisi</th>
						<th>Prix du produit</th>
						<th>Quantité choisie</th>
						<th>Votre Total</th>
						<th>Vos Actions</th>
					</tr>
				</thead>
				<tbody id="detail_cart">

				</tbody>
				
			</table>
			<button class='btn-primary'><a href="<?php /* echo site_url('visiteur/commande') */?>">PASSER COMMANDE</button>
		</div>
	</div>
</div> -->
</body>
</html>
<script type="text/javascript" src="<?php /* echo base_url().'assets/js/jquery-3.2.1.js' */?>"></script>
<script type="text/javascript" src="<?php /* echo base_url().'assets/js/bootstrap2.0.js' */?>"></script>
<script type="text/javascript">
	$(document).ready(function{
		$('.add_cart').click(function(){
			var NoProduit   = $(this).data("productid");
			var LibelleCourt  = $(this).data("productname");
			var Prix = $(this).data("price");
			var quantity   	  = $('#' + NoProduit).val();
			if(quantity) != '' && quantity > 0)
			{
				$.ajax({
					url :"<?php echo site_url('visiteur/ajouterProduitAuPanier');?>",
					method :"POST",
					data :{NoProduit: NoProduit, LibelleCourt: LibelleCourt, Prix: Prix, quantity:quantity},
					success:function(data)
					{
						alert("Produit ajouté au panier");
						$('#cart_details').html(data);
						$('#' + NoProduit).val('');
					}
				});
			}
			else
			{
				alert("Saisissez une quantité");
			}
		});

		
		$('#detail_cart').load("<?php /* echo site_url('visiteur/chargerPanier'); */?>");

		
		$(document).on('click','.romove_cart',function(){
			var row_id=$(this).attr("id"); 
			$.ajax({
				url : "<?php /* echo site_url('visiteur/suppressionPanier'); */?>",
				method : "POST",
				data : {row_id : row_id},
				success :function(data){
					$('#detail_cart').html(data);
				}
			});
		});
	});
</script> 
<?php
/* echo '<p>'.anchor('visiteur/catalogueEvenement','Retour à la liste de nos évènements').'</p>'; */
?>
