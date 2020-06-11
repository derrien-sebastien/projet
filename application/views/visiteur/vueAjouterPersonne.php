<?php
$email=array(
	'type'	=>	'email',
	'name'	=>	'txtEmail',
	'value' =>	set_value('txtEmail')
);
$mdp=array(
	'type'	=>	'password',
	'name'	=>	'password'
);
$mdp2=array(
	'type'	=>	'password',
	'name'	=>	'password2'
);
$submit=array(
	'name'              =>  'Envoyer',
	'value'             =>  'ENVOYER',
	'class'             =>  'btn'
);
echo '<div>';
echo 	'<h1>Souhaitez-vous ajouter cette adresse mail ?</h1>';
echo '</div>';
echo '</br>';
echo '<div align=center>';
echo 	validation_errors();
echo 	form_open('Visiteur/inscription');
echo 	'<table>';
echo 		'<tr>';
echo 			'<td>';
echo 				form_label('Adresse mail : ','txtEmail');
echo 			'</td>';
echo 			'<td>';
echo 				form_input($email);
echo 			'</td>';
echo 		'</tr>';
echo 		'<tr>';
echo 			'<td>';
echo 				'</br>';
echo 				form_label('Mot de passe (Facultatif) : ','password');
echo 			'</td>';
echo 			'<td>';
echo 				'</br>';
echo 				form_input($mdp);
echo 			'</td>';
echo 		'</tr>';
echo 		'<tr>';
echo 			'<td>';
echo 				'</br>';
echo 				form_label('Confirmer le mot de passe : ','password2');
echo 			'</td>';
echo 			'<td>';
echo 				'</br>';
echo 				form_input($mdp2);
echo 			'</td>';
echo 		'</tr>';
echo 	'</table>';
echo '</br></br>';
echo form_submit($submit);
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>

