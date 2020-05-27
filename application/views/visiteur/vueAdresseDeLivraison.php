<?php 
            
            $txtAdresse=array(
                'type'  =>  'text',
                'name'  =>  'txtAdresse',
                'class'=>'form-control'
            );
            $txtCp=array(
                'type'  =>  'text',
                'name'  =>  'txtCp',
                'class'=>'form-control'
            );
            $txtVille=array(
                'type'  =>  'text',
                'name'  =>  'txtVille',
                'class'=>'form-control'
            );
            $submit=array(
                'name'=>'submit',
                'value'=>'Soumettre',
                'class'=>'btn btn-primary'
            );

            $email=array(	
	            'name'			=>	'email',
	            'type'			=>	'email',
	            'id'			=>	'txtEmail'
            );

            if(isset($Personne->Email))
            {
                $email['value']=$Personne->Email;
            }
            if(isset($Personne->Adresse))
            {
                $txtAdresse['value']=$Personne->Adresse;
            }
            if(isset($Personne->CodePostal))
            {
                $txtCp['value']=$Personne->CodePostal;
            }
            if(isset($Personne->Ville))
            {
                $txtVille['value']=$Personne->Ville;
            }

echo '</br>';
echo '<h2 align="center">Afin de continuer votre(vos) achat(s) merci de compléter ce formulaire</h2>';
echo form_open('visiteur/formulaireLivraison');
echo '<div class="row justify-content-center" align="center">';          
    echo '<div class="col-3">';
        echo form_label('<img src="'.base_url().'assets/img_site/utilisateur.svg" height="100" width="100">',"txtEmail");
        echo form_input($email); 
        echo '<div class="form-group">';
            echo form_label('votre adresse de livraison ','txtAdresse');          
            echo form_input($txtAdresse);             
            echo form_label('Code postal','txtCp');            
            echo form_input($txtCp);              
            echo form_label('Ville','txtVille');            
            echo form_input($txtVille);
        echo '</div>';
        echo '</br>';
        echo '<div align="center">';
            echo form_submit($submit);
        echo '</div>'; 
    echo '</div>';   
echo '</div>';
echo form_close();       