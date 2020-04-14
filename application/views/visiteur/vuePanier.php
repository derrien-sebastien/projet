
<body>
<div class="container"><br/>
	<h2>Catalogue </h2>
	<hr/>
	<div class="row">
		<div class="col-md-8">
			<h4>Nos Produits</h4>
			<div class="row">
			<?php foreach ($data->result() as $row) : ?>
				<div class="col-md-4">
					<div class="thumbnail">
						<img width="200" src="<?php echo base_url().'assets/images/'.$row->Img_Produit;?>">
						<div class="caption">
							<h4><?php echo $row->LibelleCourt;?></h4>
							<div class="row">
								<div class="col-md-7">
									<h4><?php echo ($row->Prix);?></h4>
								</div>
								<div class="col-md-5">
									<input type="number" name="quantity" id="<?php echo $row->NoProduit;?>" value="1" class="quantity form-control">
								</div>
							</div>
							<button class="add_cart btn btn-success btn-block" data-productid="<?php echo $row->NoProduit;?>" data-productname="<?php echo $row->LibelleCourt;?>" data-productprice="<?php echo $row->Prix;?>">Ajouter</button>
						</div>
					</div>
				</div>
			<?php endforeach;?>
                
            
			</div>

		</div>
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
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap2.0.js'?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.ajouterProduitAuPanier').click(function(){
			var NoProduit   = $(this).data("productid");
			var LibelleCourt  = $(this).data("productname");
			var Prix = $(this).data("productprice");
			var quantity   	  = $('#' + NoProduit).val();
			$.ajax({
				url : "<?php echo site_url('visiteur/ajouterProduitAuPanier');?>",
				method : "POST",
				data : {NoProduit: NoProduit, LibelleCourt: LibelleCourt, Prix: Prix, Stock: Stock},
				success: function(data){
					$('#detail_cart').html(data);
				}
			});
		});

		
		$('#detail_cart').load("<?php echo site_url('visiteur/chargerPanier');?>");

		
		$(document).on('click','.romove_cart',function(){
			var row_id=$(this).attr("id"); 
			$.ajax({
				url : "<?php echo site_url('visiteur/suppressionPanier');?>",
				method : "POST",
				data : {row_id : row_id},
				success :function(data){
					$('#detail_cart').html(data);
				}
			});
		});
	});
</script>
</body>
</html>