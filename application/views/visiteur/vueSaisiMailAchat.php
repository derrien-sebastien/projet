<?php
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$hidden=array(
	'urlRedirect'	=>	$urlRedirect
);
$email=array(	
	'name'			=>	'txtEmail',
	'type'			=>	'email',
	'id'			=>	'txtEmail',
	'placeholder'	=>	'Email',
	'value'			=>	set_value('txtEmail')
);
$style=array(
	'class'			=>	'btnSubmit btn-lg btn-primary'
);
///////////////////////////////   FORMULAIRE   //////////////////////////////////////// 
echo '<body id="bodyLogin">';
echo	'<div class="containerLogin">';
echo		'<img src="'.base_url().'assets/img_site/utilisateur.svg">';
echo		'<h4>Saisissez votre adresse mail</h4>';
echo 		'</br>';
echo 		'</br>';
echo 		validation_errors();
echo 		form_open('Visiteur/formulaireLivraison');
echo 		form_hidden($hidden);
echo 		form_label('','txtEmail');
echo		'<div style="color:rgba(193, 193, 193);" class="form_input">';
echo 			form_input($email); 
echo 		'</div>';
echo 		'<div class="form_submit">';
echo 			'</br>';
echo 			form_submit('submit', 'Envoyer',$style);
echo 		'</div>';
echo 	'</div>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>

