<?php
/*
	Donnees entrées
		-	$site
		-	$rang
		-	$id
	 	-	$total
		-	$cmd
		-	$porteur
		-	$repondreA
		-	$retour
		-	$effectue
		-	$annule
		-	$refuse
		-	$dateT
		-	$hmac
		-	$serveurOK
*/
$attribut=array(
	'id'=> 'leFormulaire'
);

echo form_open($serveurOK,$attribut);
echo form_hidden($hidden);
echo form_close();
?>
<script>
	document.getElementById('leFormulaire').submit();
</script>