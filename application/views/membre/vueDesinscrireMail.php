<?php

////////////////////////////// Déclaration de nos Variables ////////////////////////////

$data = array(
	'name'    => 'newsletter',
	'checked' =>  TRUE,
	'style'   => 'margin:10px'
);
$submit=array(
	'name'=>'submit',
	'value'=>'TRANSMETTRE',
	'class'=>'btn btn-primary'
);

///////////////////////// Variables déjà connu ? On réassigne... //////////////////////// 
echo form_open('membre/actif');
	echo '</br>';
	echo '<div class="container-fluid">';
		echo '<h1 class="encadre">Newsletter</h1>';
		echo '<br>';
		echo '<div align="center">';
			echo form_checkbox($data);
			if($actif=='oui')
			{
				echo form_label('Pour vous désinscrire de la Newsletter et ne plus recevoir de mail de notre part cocher la case et confirmer');	
			}
			else
			{
				echo form_label('Pour recevoir nos mails cocher la case et confirmer');	
			}
		echo '</div>';
		echo '<div align="center">';
			echo form_submit($submit);
		echo '</div>';
	echo '</div>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>
