<?php
//donné entrée 
//$urlRedirect
//$provenance
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
$password=array(	
	'name'=>'password',
	'type'=>'password',	
	'id'=>'password',
	'placeholder'=>'Mot de passe'				
);
$style=array('class'=>'btnSubmit btn-lg btn-primary');
///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
if (isset($provenance))
{
	echo form_open('visiteur/validationCommande');
}
else
{
	echo form_open('visiteur/seConnecter');
}
echo '<body id="bodyLogin">';
echo '<div class="containerLogin">';
echo '<img src="'.base_url().'assets/img_site/utilisateur.svg">';
echo '<h4>Saisissez votre adresse mail</h4>';
echo '</br>';
echo '<h4>---------------Nouveau sur notre site ? ---------------</h4>';
echo '<h4>Laisser le mot de passe vide</h4>';
echo validation_errors();
echo form_hidden($hidden);			
echo form_label('','txtEmail');
echo '<div style="color:rgba(193, 193, 193);" class="form_input">';
echo form_input($email); 
echo '</div>';
echo form_label('','password');
echo '<div style="color:rgba(193, 193, 193);" class="form_input">';
echo form_input($password);
echo '</div>';
echo '<div>';
echo '<a class="lien" href="';
echo site_url('Visiteur/oublieMotDePasse');
echo '">Mot de passe oublié ?</a>';
echo '</div>';
echo '<div class="form_submit">';
echo '</br>';
echo form_submit('submit', 'Envoyer',$style);
echo '</div>';
echo '</div>';
echo '</div>';
echo form_close();		
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>