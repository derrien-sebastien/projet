<?php
	/* echo ul(array('Ajouter-Supprimer un produit','consulter panier')); */
?>
<h2>Menu</h2>
<?php
echo anchor('visiteur/accueil', 'Accueil');
echo "<br>";
echo anchor('visiteur/catalogueProduits','lister les produits commandables');
echo "<br>";
echo anchor('visiteur/panier', 'consultation du panier');
echo "<br>";
echo anchor('visiteur/viderPanier', 'suppression du panier');
?>




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