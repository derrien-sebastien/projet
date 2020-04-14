
<html>
	<body>
		<div align=center>
			<h1>Souhaitez-vous ajouter cette adresse mail ?</h1>
		</div>
		</br>
		<div align=center>
			<?php
				$mdp=array(
					'type'=>'password',
					'name'=>'password'
				);
				$mdp2=array(
					'type'=>'password',
					'name'=>'password2'
				);
				echo validation_errors();
				echo form_open('visiteur/inscription');
				echo '<table><tr><td>';
				echo form_label('Adresse mail : ','txtEmail');
				echo '</td><td>';
				echo form_input('txtEmail', set_value('txtEmail'));
				echo '</td></tr><td>';
				echo '</br>';
				//echo '</br>';
				echo form_label('Mot de passe (Facultatif) : ','password');
				echo '</td><td></br>';
				echo form_input($mdp);
				echo '</td></tr><td>';
				//echo '</br>';
				echo '</br>';
				echo form_label('Confirmer le mot de passe : ','password2');
				echo '</td><td></br>';
				echo form_input($mdp2);
				echo '</td></tr></table></br></br>';
				echo form_submit('submit', 'Envoyer');
				echo form_close();
			?>
		</div>
	</body>
</html>