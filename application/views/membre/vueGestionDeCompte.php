<?php

////////////////////////////// Déclaration de nos Variables ////////////////////////////

$txtNom=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtNom',
    'class'     =>  'form-control'
);
$txtPrenom=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtPrenom',
    'class'     =>  'form-control'
);
$txtAdresse=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtAdresse',
    'class'     =>  'form-control'
);
$txtCp=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtCp',
    'class'     =>  'form-control'
);
$txtVille=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtVille',
    'class'     =>  'form-control'
);
$txtTelF=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtTelF',
    'class'     =>  'form-control'
);
$txtTelP=array(
    'type'      =>  'infoCompte',
    'name'      =>  'txtTelP',
    'class'     =>  'form-control'
);
$submit=array(
    'name'      =>  'submit',
    'value'     =>  'AJOUTER',
    'class'     =>  'btn btn-primary'
);
///////////////////////// Variables déjà connu ? On réassigne... //////////////////////// 

if(isset($Personne->Nom))
{
    $txtNom['value']    =   $Personne->Nom;
}
if(isset($Personne->Prenom))
{
    $txtPrenom['value'] =    $Personne->Prenom;
}  
if(isset($Personne->Adresse))
{
    $txtAdresse['value']=   $Personne->Adresse;
}
if(isset($Personne->CodePostal))
{
    $txtCp['value']     =   $Personne->CodePostal;
}
if(isset($Personne->Ville))
{
    $txtVille['value']  =   $Personne->Ville;
}
if(isset($Personne->TelFixe))
{
    $txtTelF['value']   =   $Personne->TelFixe;
}
if(isset($Personne->TelPortable))
{
    $txtTelP['value']   =   $Personne->TelPortable;
}

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////

echo form_open('Membre/infosCompte');   
echo '<br>';
    echo '<div class="container-fluid">';
        echo '<h1 class="encadre">Vos informations</h1>';
        echo '<h4 align="center"> Ci-joint les informations relatifs à votre compte vous pouvez compléter les informations et/ou les modifier à tout moment.</h4>';
        echo '<h3 align="center">Valider en cliquant sur le bouton AJOUTER en bas de page</h3>';            
        echo '<table class="table-responsive" align="center">'; 
            echo '<tr>';
                echo '<td>';
                    echo form_label('Nom');
                echo '</td>';
                echo '<td>';
                    echo form_input($txtNom);                
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Prénom');
                echo '</td>';
                echo '<td>';
                    echo form_input($txtPrenom);                
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Adresse');
                echo '</td>';
                echo '<td>';
                    echo form_input($txtAdresse);                
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Code postal');
                echo '</td>';
                echo '<td>';
                    echo form_input($txtCp);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';                
                    echo form_label('Ville');
                echo '</td>';
                echo '<td>';
                    echo form_input($txtVille);            
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Téléphone fixe');
                echo '</td>';
                echo '<td>';
                        echo form_input($txtTelF);                
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Téléphone portable &emsp;');
                echo '</td>';
                echo '<td>';
                        echo form_input($txtTelP);                
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                echo '</td>';
                echo '<td>';
                    echo form_submit($submit);              
                echo '</td>';
            echo '</tr>';
echo '</table>';
echo '</div>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>
<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->