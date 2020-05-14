<?php
/*
partage de la vue en deux div 
a gauche l'ajout d'un eleve 
a droite liste deroulante des eleve 


donner d'entré :
 -liste eleve 
 -liste classe 
donner sortie 
    nom prenom date naissance adresse mailParent

//dopdown classe date debut 
    */

$nom=array(
 'name'=>'nom'
);

$prenom=array(
    'name'=>'prenom'
);
   
$dateNaissance=array(
    'name'=>'dateNaissance',

);
   
$email1=array(
    'name'=>'email[]',
    'type'=>'email'
);
$email2=array(
    'name'=>'email[]',
    'type'=>'email'
);
$email3=array(
    'name'=>'email[]',
    'type'=>'email'
);
$email4=array(
    'name'=>'email[]',
    'type'=>'email'
);
$classe=array(
    '0'=>'aucune classe'
);
foreach ($lesClasses as $uneClasse)
{
    $classe[$uneClasse['NoClasse']]=$uneClasse['Nom'];
}
$dateDebut=array(
    'name'=>'dateDebut',
    'type'=>'date'
);
$envoyer=array(
    'name'=>'envoyer',
    'value'=>'envoyer'
);
$nomParent1=array(
    'name'=>'nomParent[]'
);
$prenomParent1=array(
    'name'=>'PrenomParent[]'
);
$adresseParent1=array(
    'name'=>'adresseParent[]'
);
$villeParent1=array(
    'name'=>'villeParent[]'
);
$cpParent1=array(
    'name'=>'cpParent[]',
    'type'=>'number',
    'minlength'=>5,
    'maxlength'=>5,
	'step'=>'10'
);
$telFixe1=array(
    'name'=>'telFixe[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'
);
$telPort1=array(
    'name'=>'telPortable[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'    
);
$nomParent2=array(
    'name'=>'nomParent[]'
);
$prenomParent2=array(
    'name'=>'PrenomParent[]'
);
$adresseParent2=array(
    'name'=>'adresseParent[]'
);
$villeParent2=array(
    'name'=>'villeParent[]'
);
$cpParent2=array(
    'name'=>'cpParent[]',
    'type'=>'number',
    'minlength'=>5,
    'maxlength'=>5,
	'step'=>'10'
);
$telFixe2=array(
    'name'=>'telFixe[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'
);
$telPort2=array(
    'name'=>'telPortable[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'    
);
$nomParent3=array(
    'name'=>'nomParent[]'
);
$prenomParent3=array(
    'name'=>'PrenomParent[]'
);
$adresseParent3=array(
    'name'=>'adresseParent[]'
);
$villeParent3=array(
    'name'=>'villeParent[]'
);
$cpParent3=array(
    'name'=>'cpParent[]',
    'type'=>'number',
    'minlength'=>5,
    'maxlength'=>5,
	'step'=>'10'
);
$telFixe3=array(
    'name'=>'telFixe[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'
);
$telPort3=array(
    'name'=>'telPortable[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'    
);
$nomParent4=array(
    'name'=>'nomParent[]'
);
$prenomParent4=array(
    'name'=>'PrenomParent[]'
);
$adresseParent4=array(
    'name'=>'adresseParent[]'
);
$villeParent4=array(
    'name'=>'villeParent[]'
);
$cpParent4=array(
    'name'=>'cpParent[]',
    'type'=>'number',
    'minlength'=>5,
    'maxlength'=>5,
	'step'=>'10'
);
$telFixe4=array(
    'name'=>'telFixe[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'
);
$telPort4=array(
    'name'=>'telPortable[]',
    'type'=>'tel',
    'pattern'=>'[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}'    
);
$infoClasse=array();
if ($provenance=='modifier')
{
    $nom['value']=$info['nom'];
    $prenom['value']=$info['prenom'];
    $dateNaissance['value']=$info['dateNaissance'];
    $infoClasse['0']=$info['classe'];
    $dateDebut['value']=$info['dateDebut'];
    $email1['value']=$info['email1'];
    $nomParent1['value']=$info['nomParent1'];
    $prenomParent1['value']=$info['prenomParent1'];
    $adresseParent1['value']=$info['adresseParent1'];
    $villeParent1['value']=$info['villeParent1'];
    $cpParent1['placeholder']=$info['cpParent1'];
    $telFixe1['value']=$info['telFixeParent1'];
    $telPort1['value']=$info['telPortParent1'];
    $email2['value']=$info['email2'];
    $nomParent2['value']=$info['nomParent2'];
    $prenomParent2['value']=$info['prenomParent2'];
    $adresseParent2['value']=$info['adresseParent2'];
    $villeParent2['value']=$info['villeParent2'];
    $cpParent2['placeholder']=$info['cpParent2'];
    $telFixe2['value']=$info['telFixeParent2'];
    $telPort2['value']=$info['telPortParent2'];
    $email3['value']=$info['email3'];
    $nomParent3['value']=$info['nomParent3'];
    $prenomParent3['value']=$info['prenomParent3'];
    $adresseParent3['value']=$info['adresseParent3'];
    $villeParent3['value']=$info['villeParent3'];
    $cpParent3['placeholder']=$info['cpParent3'];
    $telFixe3['value']=$info['telFixeParent3'];
    $telPort3['value']=$info['telPortParent3'];
    $email4['value']=$info['email4'];
    $nomParent4['value']=$info['nomParent4'];
    $prenomParent4['value']=$info['prenomParent4'];
    $adresseParent4['value']=$info['adresseParent4'];
    $villeParent4['value']=$info['villeParent4'];
    $cpParent4['placeholder']=$info['cpParent4'];
    $telFixe4['value']=$info['telFixeParent4'];
    $telPort4['value']=$info['telPortParent4'];
    $hidden=array(
        'noEnfant'=>$info['noEnfant']
    );
}
echo '<div id="gauche">';
    echo '</br>';
    echo '</br>';
    echo '</br>';
    
    if ($provenance=='ajouter')
    {
        echo '<h1>ajouter un élève</h1>';
        echo form_open('Administrateur/ajoutMultipleEnfant');
    }
    elseif($provenance=='modifier')
    {
        echo "<h1>modification d'un élève</h1>";
        echo form_open('Administrateur/modificationEnfant');
        echo form_hidden($hidden);
    }
        echo '<table>';
            echo'<tr>';
                echo '<td>';
                    echo form_label('Nom','nom');
                echo '</td>';
                echo '<td>';
                    echo form_input($nom);
                echo '</td>';
            echo'</tr>';
            echo'<tr>';
                echo '<td>';
                    echo form_label('Prenom','prenom');
                echo '</td>';
                echo '<td>';
                    echo form_input($prenom);
                echo '</td>';
            echo'</tr>';
            echo'<tr>';
                echo '<td>';
                    echo form_label('Date de naissance','dateNaissance');
                echo '</td>';
                echo '<td>';
                    echo form_input($dateNaissance);
                echo '</td>';
            echo'</tr>';
            echo'<tr>';
                echo '<td>';
                    echo form_label('Classe','classe');
                echo '</td>';
                echo '<td>';
                    echo form_dropdown('classe',$classe,$infoClasse);
                echo '</td>';
            echo'</tr>';
            echo'<tr>';
                echo '<td>';
                    echo form_label('Email du premier responsable legale','email1');
                echo '</td>';
                echo '<td>';
                    echo form_input($email1);
                echo '</td>';
            echo'</tr>';
            echo '<tr>';//test
            echo '<td>';
            echo '</td>';
            echo '<td class="parent1">';
            echo '<table>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Nom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($nomParent1);
                echo '</td>';
                echo '<td>';
                    echo form_label('Prenom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($prenomParent1);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Adresse : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($adresseParent1);
                echo '</td>';
                echo '<td>';
                    echo form_label('Ville : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($villeParent1);
                echo '</td>';
                echo '<td>';
                    echo form_label('Code postale : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($cpParent1);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('téléphone fixe : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telFixe1);
                echo '</td>';
                echo '<td>';
                    echo form_label('téléphone Portable : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telPort1);
                echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</td>';
            echo '</tr>';//fin test
            echo'<tr>';
                echo '<td>';
                    echo form_label('Email du deuxieme responsable legale','email1');
                echo '</td>';
                echo '<td>';
                    echo form_input($email2);
                echo '</td>';
            echo'</tr>';
            echo '<tr>';//test
            echo '<td>';
            echo '</td>';
            echo '<td class="parent2">';
            echo '<table>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Nom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($nomParent2);
                echo '</td>';
                echo '<td>';
                    echo form_label('Prenom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($prenomParent2);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Adresse : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($adresseParent2);
                echo '</td>';
                echo '<td>';
                    echo form_label('Ville : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($villeParent2);
                echo '</td>';
                echo '<td>';
                    echo form_label('Code postale : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($cpParent2);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('téléphone fixe : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telFixe2);
                echo '</td>';
                echo '<td>';
                    echo form_label('téléphone Portable : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telPort2);
                echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</td>';
            echo '</tr>';//fin test
            echo'<tr>';
                echo '<td>';
                    echo form_label('Email du troisieme responsable legale','email1');
                echo '</td>';
                echo '<td>';
                    echo form_input($email3);
                echo '</td>';
            echo'</tr>';
            echo '<tr>';//test
            echo '<td>';
            echo '</td>';
            echo '<td class="parent3">';
            echo '<table>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Nom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($nomParent3);
                echo '</td>';
                echo '<td>';
                    echo form_label('Prenom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($prenomParent3);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Adresse : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($adresseParent3);
                echo '</td>';
                echo '<td>';
                    echo form_label('Ville : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($villeParent3);
                echo '</td>';
                echo '<td>';
                    echo form_label('Code postale : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($cpParent3);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('téléphone fixe : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telFixe3);
                echo '</td>';
                echo '<td>';
                    echo form_label('téléphone Portable : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telPort3);
                echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</td>';
            echo '</tr>';//fin test
            echo'<tr>';
                echo '<td>';
                    echo form_label('Email du quatrieme responsable legale','email1');
                echo '</td>';
                echo '<td>';
                    echo form_input($email4);
                echo '</td>';
            echo'</tr>';
            echo '<tr>';//test
            echo '<td>';
            echo '</td>';
            echo '<td class="parent4">';
            echo '<table>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Nom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($nomParent4);
                echo '</td>';
                echo '<td>';
                    echo form_label('Prenom : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($prenomParent4);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Adresse : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($adresseParent4);
                echo '</td>';
                echo '<td>';
                    echo form_label('Ville : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($villeParent4);
                echo '</td>';
                echo '<td>';
                    echo form_label('Code postale : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($cpParent4);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('téléphone fixe : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telFixe4);
                echo '</td>';
                echo '<td>';
                    echo form_label('téléphone Portable : ');
                echo '</td>';
                echo '<td>';
                    echo form_input($telPort4);
                echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</td>';
            echo '</tr>';//fin test
        echo '</table>';
        echo form_submit($envoyer);
    echo form_close();
echo '</div>';



$options=array();
foreach($lesEnfants as $unEnfant)
{
    $options[$unEnfant->NoEnfant]=$unEnfant->Nom.'  '.$unEnfant->Prenom;
}
$envoyer=array(
    'name'=>'envoyer',
    'value'=>'envoyer'
);
$css=array(
    'id'=>'dropdownHaut'
);

echo '<div id="droite">';
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo '<h1>liste des élèves</h1>';
    echo form_open('Administrateur/modificationEnfant');
        echo form_dropdown('enfant',$options,$css);
        echo form_submit($envoyer);
    echo form_close();
echo '</div>';