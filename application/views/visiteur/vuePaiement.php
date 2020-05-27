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
$submit=array(
    'value'          =>  'Envoyer',
    'class'          =>  'btn btn-primary'
);
echo '<h3>Vous avez choisi de payer par carte bancaire veuillez confirmer</h3>';
echo form_open($serveurOK);
echo form_hidden($hidden);
echo form_submit($submit);
echo form_close();
?>