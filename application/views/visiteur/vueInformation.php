<?php

////////////////////////////// Déclaration de nos Variables ////////////////////////////

            $txtNom=array(
                'type'  =>  'text',
                'name'  =>  'txtNom'
            );
            $txtPrenom=array(
                'type'  =>  'text',
                'name'  =>  'txtPrenom'
            );
            $txtAdresse=array(
                'type'  =>  'text',
                'name'  =>  'txtAdresse'
            );
            $txtCp=array(
                'type'  =>  'text',
                'name'  =>  'txtCp'
            );
            $txtVille=array(
                'type'  =>  'text',
                'name'  =>  'txtVille'
            );
            $txtTelF=array(
                'type'=>'text',
                'name'=>'txtTelF'
            );
            $txtTelP=array(
                'type'=>'text',
                'name'=>'txtTelP'
            );
            $submit=array(
                'name'=>'submit',
                'value'=>'Soumettre',
                'class'=>'btn btn-primary'
            );
            $js=['onClick' => 'GereChkbox();'];

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
            if(isset($Personne->TelPortable))
            {
                $txtTelP['value']=$Personne->TelPortable;
            }
            if(isset($Personne->TelFixe))
            {
                $txtTelF['value']=$Personne->TelFixe;
            }

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////

echo '<h2 align="center">Vos informations en notre possession</h2>';
echo form_open('visiteur/infosCompte','class="form-horizontal" name="form"');               
echo '<table class="table-bordered td" align="center">'; 
echo    '<tr>';
echo        '<td>';
echo            form_label('Nom :',"txtNom");
echo        '</td>';
echo        '<td>';
echo            '<span class="marge">';
echo                form_input($txtNom);                
echo            '</span>';
echo        '</td>';
echo    '</tr>';
echo    '<br>';
echo    '<tr>';
echo        '<td>';
echo            form_label('Prénom :','txtPrenom');
echo        '</td>';
echo        '<td>';
echo            '<span class="marge">';
echo                form_input($txtPrenom);                
echo            '</span>';
echo        '</td>';
echo    '</tr>';
echo    '<br>';
echo    '<tr>';
echo        '<td>';
echo            form_label('Adresse :','txtAdresse');
echo        '</td>';
echo        '<td>';
echo            '<span class="marge">';
echo                form_input($txtAdresse);                
echo            '</span>';
echo        '</td>';
echo    '</tr>';
echo    '<br>';
echo    '<tr>';
echo        '<td>';
echo            form_label('Code postal :','txtCp');
echo        '</td>';
echo        '<td>';
echo            '<span class="marge">';
echo                form_input($txtCp);
echo            '</span>';
echo        '</td>';
echo    '</tr>';
echo    '<br>';
echo    '<tr>';
echo        '<td>';                
echo            form_label('Ville :','txtVille');
echo        '</td>';
echo        '<td>';
echo            '<span class="marge">';
echo                form_input($txtVille);                
echo            '</span>';
echo        '</td>';
echo    '</tr>';
echo    '<br>';
echo    '<tr>';
echo        '<td>';
echo            form_label('Téléphone portable (optionnel) :','txtTelP');
echo        '</td>';
echo        '<td>';
echo            '<span class="marge">';
echo                form_input($txtTelP);                
echo            '</span>';
echo        '</td>';
echo    '</tr>';
echo    '<tr>';
echo        '<td>';
echo            'Confirmer vous ces informations ?';
echo        '</td>';
echo        '<td align="center">';
echo            form_checkbox('connu','1',FALSE,$js);
echo            'oui';
echo            form_checkbox('nonConnu','2',FALSE,$js);
echo            'non';
echo        '</td>';
echo    '</tr>';
echo    '<tr>';
echo        '<td align="center">';
echo        '</td>\n';
echo        '<td align="center">';
echo            form_submit($submit);
echo        '</td>\n';
echo    '</tr>';
echo '</table>';
echo form_close(); 

//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>

<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->


<script type="text/javascript"> function GereChkbox() 
{ 
    if(document.getElementById($connu).checked) 
    {   
        document.getElementById($nonConnu).disabled = "disabled"; 
        document.getElementById($connu).disabled = ""; 
    } 
    else if(document.getElementById($nonConnu).checked) 
    { 
        document.getElementById($connu).disabled = "disabled"; 
        document.getElementById($nonConnu).disabled = ""; 
    } 
    else 
    { 
        document.getElementById($connu).disabled = ""; 
        document.getElementById($nonConnu).disabled = ""; 
    } 
} </script>        
        