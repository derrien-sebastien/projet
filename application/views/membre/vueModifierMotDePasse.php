<?php

////////////////////////////// Déclaration de nos Variables ////////////////////////////

$password1=array(	
    'name'          =>  'password1',
    'type'          =>  'password2',	
    'id'            =>  'password1',
    'class'         =>  'form-control',
    'placeholder'	=>	'Ancien mot de passe'		
);

$password2=array(	
    'name'          =>  'password2',
    'type'          =>  'password2',	
    'id'            =>  'password2',
    'class'         =>  'form-control',
    'placeholder'	=>	'Nouveau mot de passe'				
);
$password3=array(	
    'name'          =>  'password3',
    'type'          =>  'password2',	
    'id'            =>  'password3',
    'class'         =>  'form-control',
    'placeholder'	=>	'Confirmer le nouveau mot de passe'					
);
$submit=array(
    'name'          => 'submit',
    'class'         => 'btn btn-primary',
    'value'         => "MODIFIER"
);
$style=array(
    'class'         =>  'btnSubmit btn-lg btn-primary'
);

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
echo form_open('membre/modificationMdp');
    echo '</br>';
    echo '<div class="container-fluid">';
        echo '<h1 class="encadre" align="center">Paramètre confidentiel de votre compte</h1>';
        echo '</br>';
        echo '<h2 align="center"> Saisissez votre ancien mot de passe</h2>';
        echo '<div align="center">';
            echo form_input($password1);
        echo '</div>';
        echo '<h2 align="center">Puis, saisissez deux mots de passe identiques</h2>';
        echo '<form onsubmit="return confirmationMotDePasse()" action="'.site_url('membre/ModificationMdp').'" method="post">';
        echo '<div align="center">';
            echo form_input($password2);
        echo '</div>';
        echo '<div align="center">';
            echo form_input($password3);
        echo '</div>';       
        echo '<div align="center">';
            echo form_submit($submit);
        echo '</div>';
    echo '</div>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>

<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->

<!-- <script>
    function confirmationMotDePasse()
    {
        var mdp = document.getElementById("password2").value;
        var confirmMdp = document.getElementById("password3").value;
        if(mdp == confirmMdp)
        {
            return true;
        }
        else
        {
            alert('Les mots de passe ne correspondent pas.');
            document.getElementById("password2").value = "";
            document.getElementById("password3").value = "";
            document.getElementById("password2").focus();
            return false;
        }
    }
</script> -->