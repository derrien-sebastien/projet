<?php
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$email=array(	
    'name'        =>  'txtEmail',
    'type'        =>  'email',
    'id'          =>  'txtEmail',
    'placeholder' =>  'Email',
    'value'       =>  set_value('txtEmail')
);
$style=array(
    'class'       =>  'btnSubmit btn-lg btn-primary'
  );
///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
echo form_open('visiteur/oublieMotDePasse'); 
  echo '<body id="bodyLogin">';
    echo '<div class="containerLogin">';
      echo '<img src="';
        echo base_url('assets/img_site/cadenas.svg'); 
      echo '">'; 
      echo '<p> Aide avec le mot de passe</p>';
      echo '<h4>Saisissez votre adresse mail</h4>';
      echo form_open('visiteur/oublieMotDePasse'); 
      echo '<div style="color:rgba(#2b2b2b);" align="center" class="form_input">';
        echo form_input($email); 
      echo '</div>';
      echo '<div class="form_submit">';
        echo '</br>';
        echo form_submit('submit', 'Envoyer',$style);
      echo '</div>';
    echo '</div>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>
