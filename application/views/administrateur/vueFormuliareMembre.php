<?php
if (isset($admin))
{
    $hidden=array(
        'profil'=>'admin'
    );
}
else 
{
    $hidden=array(
        'profil'=>'membre'
    );  
}
$email=array(
    'name'=>'email'
);
$adresse=array(
    'name'=>'adresse'
);
$ville=array(
    'name'=>'ville'
);
$codePostal=array(
    'name'=>'codePostal',
    'type'=>'number',
    'minlength'=>5,
    'maxlength'=>5,
    'placeholder'=>'22400',
	'step'=>'10'
);
$telPortable=array(
    'name'=>'telPortable',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}',
    'value'=>'06.00.00.00.00.'
);
$telFixe=array(
    'name'=>'telPortable',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}',
    'value'=>'02.00.00.00.00.'
);

echo form_open('Administrateur/ajouterUnMembre');
echo '</br>';
if (isset($admin))
{
    echo '<h1>Ajouter un administrateur</h1>';
}
else 
{
    echo '<h1>Ajouter un membre</h1>';
}
echo form_hidden($hidden);
echo '<table>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Email : ','email');
        echo '</td>';
        echo '<td>';
            echo form_input($email);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Nom : ','nom');
        echo '</td>';
        echo '<td>';
            echo form_input($nom);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Prenom : ','prenom');
        echo '</td>';
        echo '<td>';
            echo form_input($prenom);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Adresse : ','adresse');
        echo '</td>';
        echo '<td>';
            echo form_input($adresse);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Ville : ','ville');  
        echo '</td>';
        echo '<td>';
            echo form_input($ville);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Code Postal : ','CodePostal');  
        echo '</td>';
        echo '<td>';
            echo form_input($codePostal);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Telephone portable : ','telPortable');  
        echo '</td>';
        echo '<td>';
            echo form_input($telPortable);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Telephone fixe : ','telFixe');  
        echo '</td>';
        echo '<td>';
            echo form_input($telFixe);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
echo '</table>';
echo 'une validation sera envoyer par mail '



