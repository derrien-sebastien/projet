<body id="bodyLogin">
	<div class="containerLogin">
		<img src="<?php echo base_url(); ?>assets/img_site/utilisateur.svg" >
		<h3>Saisissez votre adresse mail</h1>
		<?php
			$email=array(	'name'=>'txtEmail',
							'type'=>'email',
							'id'=>'txtEmail',
							'placeholder'=>'Email',
							'value'=>set_value('txtEmail')
						);
			$password=array(	'name'=>'password',
								'type'=>'password',	
								'id'=>'password',
								'placeholder'=>'Mot de passe'				
							);
			$style=array('class'=>'btnSubmit btn-lg btn-primary');

			echo "Première connexion ? Laisser le mot de passe vide";
			echo '</br>';
			echo '</br>';
			echo validation_errors();
			echo form_open('visiteur/seConnecter');
			echo form_label('','txtEmail');
		?>
		<div class="form_input">
			<?php 
				echo form_input($email); 
			?>
		</div>
		<?php
			echo form_label('','password');
		?>
		<div class="form_input">
			<?php 
				echo form_input($password);
			?>
		</div>
		<div class="form_submit">
			<?php 
				echo '</br>';
				echo form_submit('submit', 'Envoyer',$style);
				echo form_close();
			?>
		</div>
	</div>
		
