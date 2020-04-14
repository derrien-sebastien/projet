<?php
$txtNom=array(
    'type'=>'text',
    'name'=>'txtNom'
);
if(isset($Personne->Nom))
{
    $txtNom['value']=$Personne->Nom;
}
$txtPrenom=array(
    'type'=>'text',
    'name'=>'txtPrenom'
);
if(isset($Personne->Prenom))
{
    $txtPrenom['value']=$Personne->Prenom;
}  
$txtAdresse=array(
    'type'=>'text',
    'name'=>'txtAdresse'
);
if(isset($Personne->Adresse))
{
    $txtAdresse['value']=$Personne->Adresse;
}
$txtCp=array(
    'type'=>'text',
    'name'=>'txtCp'
);
if(isset($Personne->CodePostal))
{
    $txtCp['value']=$Personne->CodePostal;
}
$txtVille=array(
    'type'=>'text',
    'name'=>'txtVille'
);
if(isset($Personne->Ville))
{
    $txtVille['value']=$Personne->Ville;
}
$txtTelF=array(
    'type'=>'text',
    'name'=>'txtTelF'
);
if(isset($Personne->TelFixe))
{
    $txtTelF['value']=$Personne->TelFixe;
}
$txtTelP=array(
    'type'=>'text',
    'name'=>'txtTelP'
);
if(isset($Personne->TelPortable))
{
    $txtTelP['value']=$Personne->TelPortable;
}







echo form_open('visiteur/infosCompte');

                
echo "<table>";
echo "<tr><td>";
echo form_label("Avez-vous un enfant scolariser dans l'établissement ?","enfant");
echo "</td><td><span class='marge'>";
echo form_checkbox("enfant", "enfant");
echo "</span></td><td>";
echo "<tr><td>";
echo 
form_label('Nom :',"txtNom");
echo "</td><td><span class='marge'>";
echo form_input($txtNom);                
echo "</span></td></tr><br><tr><td>";
echo form_label('Prénom :','txtPrenom');
echo "</td><td><span class='marge'>";
echo form_input($txtPrenom);                
echo "</span></td></tr><br><tr><td>";
echo form_label('Adresse :','txtAdresse');
echo "</td><td><span class='marge'>";
echo form_input($txtAdresse);                
echo "</span></td></tr><br><tr><td>";
echo form_label('Code postal :','txtCp');
echo "</td><td><span class='marge'>";
echo form_input($txtCp);                
echo "</span></td></tr><br><tr><td>";
echo form_label('Ville :','txtVille');
echo "</td><td><span class='marge'>";
echo form_input($txtVille);                
echo "</span></td></tr><br><tr><td>";
echo form_label('Téléphone fixe :','txtTelF');
echo "</td><td><span class='marge'>";
echo form_input($txtTelF);                
echo "</span></td></tr><br><tr><td>";
echo form_label('Téléphone portable ?','txtTelP');
echo "</td><td><span class='marge'>";
echo form_input($txtTelP);                
echo "</span></td></tr><br></br><tr><td>";
echo form_submit('submit', 'Ajouter');              
echo "</td></tr></table></form></br></br>";
echo "<p>Pour modifier votre mot de passe cliquez ici"; 
echo "<a href='";
echo site_url('visiteur/vueModifierMotDePasse');
echo "'><button type='submit' name='changeMdp' class='btn btn-primary btn-xs'>Modifier le mot de passe</button></a></p>";
                
?>
        
        
        