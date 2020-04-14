<head>
    <style>
        body { background-color: #5f5c5c; }
    </style>
</head>
<body>
<div id="login">
	<h1>Saisissez votre adresse mail</h1>
		<?php
			$email=array(	'name'=>'txtEmail',
							'type'=>'email',
							'id'=>'txtEmail',
							'placeholder'=>'votre email',
							'value'=>set_value('txtEmail')
						);
			$password=array(	'name'=>'password',
								'type'=>'password',	
								'id'=>'password',
								'placeholder'=>'votre mot de passe'				
							);
			echo "Première connexion ? Laisser le mot de passe vide";
			echo '</br>';
			echo '</br>';
			echo validation_errors();
			echo form_open('visiteur/seConnecter');
			echo form_label('adresse email','txtEmail');
			echo form_input($email);
			echo '</br>';
			echo '</br>';
			echo form_label('mot de passe ','password');
			echo form_input($password);
			echo '</br>';
			echo form_submit('submit', 'Envoyer');
			echo form_close();
		?>
	</div>
</body>
