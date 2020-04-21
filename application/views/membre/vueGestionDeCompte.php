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

echo form_open('membre/infosCompte','class="form-horizontal" name="form"');               
    echo "<table class='table-bordered td' align=center>";
        echo "<tr>";
            echo "<td>";
                echo form_label("Avez-vous un enfant scolariser dans l'établissement ?","enfant");
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_checkbox("enfant", "enfant");
                echo "</span>";
            echo "</td>";  
        echo "<tr>";
            echo "<td >";
                echo form_label('Nom :',"txtNom");
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtNom);                
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<br>";
        echo "<tr>";
            echo "<td>";
                echo form_label('Prénom :','txtPrenom');
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtPrenom);                
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<br>";
        echo "<tr>";
            echo "<td>";
                echo form_label('Adresse :','txtAdresse');
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtAdresse);                
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<br>";
        echo "<tr>";
            echo "<td>";
                echo form_label('Code postal :','txtCp');
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtCp);
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<br>";
        echo "<tr>";
            echo "<td>";                
                echo form_label('Ville :','txtVille');
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtVille);                
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<br>";
        echo "<tr>";
            echo "<td>";
                echo form_label('Téléphone fixe :','txtTelF');
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtTelF);                
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<br>";
        echo "<tr>";
            echo "<td>";
                echo form_label('Téléphone portable ?','txtTelP');
            echo "</td>";
            echo "<td>";
                echo "<span class='marge'>";
                    echo form_input($txtTelP);                
                echo "</span>";
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>";
            echo "</td>";
            echo "<td>";
                echo form_submit('submit', 'Ajouter','class="btn btn-dark"');              
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>";
                echo "<p>Pour modifier votre mot de passe cliquez ici";              
            echo "</td>";
            echo "<td>";
                echo "<a href='";
                echo site_url('membre/ModificationMdp');
                    echo "'><button type='submit' name='changeMdp' class='btn btn-dark btn-xs'>Modifier le mot de passe</button></a></p>";     
            echo "</td>";
        echo "</tr>";
    echo "</table>";
echo "</form>";