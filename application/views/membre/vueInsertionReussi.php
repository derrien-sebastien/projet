<?php
////////////////////////////// Déclaration de nos Variables ////////////////////////////

$txtNom=array(
    'type'=>'text',
    'name'=>'txtNom'
);
$txtPrenom=array(
    'type'=>'text',
    'name'=>'txtPrenom'
);
$txtAdresse=array(
    'type'=>'text',
    'name'=>'txtAdresse'
);
$txtCp=array(
    'type'=>'text',
    'name'=>'txtCp'
);
$txtVille=array(
    'type'=>'text',
    'name'=>'txtVille'
);
$txtTelF=array(
    'type'=>'text',
    'name'=>'txtTelF'
);
$txtTelP=array(
    'type'=>'text',
    'name'=>'txtTelP'
);

///////////////////////// Variables déjà connu ? On réassigne... //////////////////////// 

if(isset($Personne->Nom))
{
    $txtNom['value']=$Personne->Nom;
}
if(isset($Personne->Prenom))
{
    $txtPrenom['value']=$Personne->Prenom;
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
if(isset($Personne->TelFixe))
{
    $txtTelF['value']=$Personne->TelFixe;
}
if(isset($Personne->TelPortable))
{
    $txtTelP['value']=$Personne->TelPortable;
}

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////

echo '<div class=container>';
echo    '<h1 class="encadre">Vos informations</h1>';
echo    '<h1 align="center">Insertion réussie !</h1>';
echo    form_open('membre/infosCompte','class="form-horizontal" name="form"');               
echo    '<table class="table" align=center>'; 
echo        '<tr>';
echo            '<td>';
echo                form_label('Nom :',"txtNom");
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtNom);                
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<br>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Prénom :','txtPrenom');
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtPrenom);                
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<br>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Adresse :','txtAdresse');
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtAdresse);                
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<br>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Code postal :','txtCp');
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtCp);
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<br>';
echo        '<tr>';
echo            '<td>';                
echo                form_label('Ville :','txtVille');
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtVille);                
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<br>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Téléphone fixe :','txtTelF');
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtTelF);                
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<br>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Téléphone portable ?','txtTelP');
echo            '</td>';
echo            '<td>';
echo                '<span class="marge">';
echo                    form_input($txtTelP);                
echo                '</span>';
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo            '</td>';
echo            '<td>';
echo                form_submit('submit', 'AJOUTER','class="btn btn-primary"');              
echo            '</td>';
echo        '</tr>';
echo    '</table>';
echo    form_close();
echo '</div>';
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>
<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->