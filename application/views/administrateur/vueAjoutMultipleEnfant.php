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
////////////////////////////// PREMIERE - Déclaration de nos Variables ////////////////////////////
        $nom=array(
        'name'=>'nom'
        );
        $prenom=array(
            'name'=>'prenom'
        );
        $dateNaissance=array(
            'name'=>'dateNaissance'
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
        $infoParent=array(
            'name'=>'infoParent'
        );
        $envoyer=array(
            'name'=>'envoyer',
            'value'=>'envoyer'
        );

/////////////////////////////// PREMIER - FORMULAIRE   ////////////////////////////////////////

echo '<div id="gauche">';
echo    '</br>';
echo    '</br>';
echo    '</br>';
echo    '<h1>ajouter un élève</h1>';
echo    form_open('Administrateur/ajoutMultipleEnfant');
echo    '<table>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Nom','nom');
echo            '</td>';
echo            '<td>';
echo                form_input($nom);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Prenom','prenom');
echo            '</td>';
echo            '<td>';
echo                form_input($prenom);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Date de naissance','dateNaissance');
echo            '</td>';
echo            '<td>';
echo                form_input($dateNaissance);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Classe','classe');
echo            '</td>';
echo            '<td>';
echo                form_dropdown($classe);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Email du premier responsable legale','email1');
echo            '</td>';
echo            '<td>';
echo                form_input($email1);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Email du deuxieme responsable legale','email1');
echo            '</td>';
echo            '<td>';
echo                form_input($email2);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Email du troisieme responsable legale','email1');
echo            '</td>';
echo            '<td>';
echo                form_input($email3);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('Email du quatrieme responsable legale','email1');
echo            '</td>';
echo            '<td>';
echo                form_input($email4);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('voulez vous renseigner les info sur les responsable legaux','infoParent');
echo            '</td>';
echo            '<td>';
echo                form_checkbox($infoParent);
echo            '</td>';
echo        '</tr>';
echo    '</table>';
echo    form_submit($envoyer);
echo    form_close();
echo '</div>';

//////////////////////////////  FIN DU PREMIER FORMULAIRE ///////////////////////////////////////


////////////////////////// DEUXIEME - Déclaration de nos Variables ////////////////////////////

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
    'id'=>'dropdown'
);

/////////////////////////////// DEUXIEME - FORMULAIRE   ////////////////////////////////////////

echo '<div id="droite">';
echo    '</br>';
echo    '</br>';
echo    '</br>';
echo    '<h1>liste des élèves</h1>';
echo    form_open('Administrateur/modificationEnfant');
echo    form_multiselect('enfant',$options,$css);
echo    form_submit($envoyer);
echo    form_close();
echo '</div>';

//////////////////////////////  FIN DU DEUXIEME FORMULAIRE ///////////////////////////////////////