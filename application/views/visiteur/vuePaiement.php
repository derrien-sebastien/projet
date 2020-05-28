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
    'value'          =>  'Cliquez ici',
    'class'          =>  'btn btn-primary'
);
echo '<h3>Vous avez choisi de payer par carte bancaire.</h3>';
 echo 'votre commande numero : '.' tant';
 echo "d'un montant de :".'$montant';
echo'<h3> Pour être dirigé vers le site de la banque. Cliquer sur le bouton';
echo form_open($serveurOK);
echo form_hidden($hidden);
echo form_submit($submit);
echo form_close();
?>