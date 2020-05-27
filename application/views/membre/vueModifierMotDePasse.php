<?php

////////////////////////////// Déclaration de nos Variables ////////////////////////////

$password=array(	
    'name'          =>  'password',
    'type'          =>  'password',	
    'id'            =>  'password',
    'class'         =>  'form-control'				
);
$password2=array(	
    'name'          =>  'password2',
    'type'          =>  'password',	
    'id'            =>  'password2',
    'class'         =>  'form-control'				
);
$style=array(
    'class'         =>  'btnSubmit btn-lg btn-primary'
);

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
echo '</br>';
echo '<div class="container-fluid">';
echo    '<h1 class="encadre" align="center">Paramètre confidentiel de votre compte</h1>';
echo    '</br>';
echo    '<h3 align="center">Afin de modifier votre mot de passe saisissez deux mots de passe identiques</h3>';
echo    form_open('membre/modificationMdp','class="form-horizontal" name="form"');
echo    '<form onsubmit="return confirmationMotDePasse()" action="'.site_url('membre/ModificationMdp').'" method="post">';
echo        '<table align="center">';
echo            '<tr>';
echo                '<td>';
echo                    form_label('Saisissez votre nouveau mot de passe :','password'); 
echo                '</td>';
echo                '<td>';
echo                    '<div style="color:#fff;" class="form_input">'; 
echo                        form_input($password);
echo                    '</div>';
echo                '</td>';
echo            '</tr>';
echo            '<tr>';
echo                '<td>';
echo                    form_label('Confirmer le nouveau mot de passe :','password2'); 
echo                '</td>';
echo                '<td>';
echo                    '<div style="color:#fff;" class="form_input">'; 
echo                        form_input($password2);
echo                    '</div>';
echo                '</td>';
echo            '</tr>';
echo        '</table>';
echo        '</br>';
echo        '<p align="center">';
echo        '<input type="submit" name="submit" value="Modifier" class="btn btn-primary"></p>';
echo    form_close();
echo '</div>';

//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>

<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->

<script>
    function confirmationMotDePasse()
    {
        var mdp = document.getElementById("password").value;
        var confirmMdp = document.getElementById("password2").value;
        if(mdp == confirmMdp)
        {
            return true;
        }
        else
        {
            alert('Les mots de passe ne correspondent pas.');
            document.getElementById("password").value = "";
            document.getElementById("password2").value = "";
            document.getElementById("password").focus();
            return false;
        }
    }
</script>