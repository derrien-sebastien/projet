
	<div class="containerLogin">
		<img src="<?php echo base_url(); ?>assets/images/utilisateur.svg" >
		<h3>Saisissez votre adresse email</h1>
		<?php
			$email=array(	'name'=>'txtEmail',
							'type'=>'email',
							'id'=>'txtEmail',
							'placeholder'=>'Email',
							'value'=>set_value('txtEmail')
						);
			$style=array('class'=>'btnSubmit');

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
		<div class="form_submit">
			<?php 
				echo '</br>';
				echo form_submit('submit', 'Envoyer',$style);
				echo form_close();
			?>
		</div>
	</div>

