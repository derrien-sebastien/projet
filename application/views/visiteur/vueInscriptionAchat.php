<h2 align="center">Afin de poursuivre votre(vos) achat(s) merci de remplir ce formulaire</h2>
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
                echo form_label('Téléphone portable (optionnel) :','txtTelP');
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
            echo "<td align=center>";
                echo form_submit('submit', 'Soumettre','class="btn btn-primary"');              
            echo "</td>";
        echo "</tr>";
    echo "</table>";
echo "</form>";
