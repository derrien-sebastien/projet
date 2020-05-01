<?php
/*
donnée entré
-$classe 
-$elvesDeLaClasse 
-$eleves
*/
//hidden classe suivante if provenance multiple

$lesEleves=array(
    '0'=>'selectionner pour ajouter'
);
foreach($eleves as $unEleve)
{
    $lesEleves[$unEleve->NoEnfant]=$unEleve->Nom.' '.$unEleve->Prenom;
}
$dateDebut=array(
    'type'=>'date',
    'name'=>'dateDebut'
);
$submit=array(
    'name'=>'modifications',
    'value'=>'envoyer les modifications'
);
$hidden=array(
    'classe'=>$classe->NoClasse
);
echo '<h1>modification des eleve de : ';
echo $classe->Nom;
echo '</h1></br>';
echo form_open_multipart('Administrateur/modifierClasse');
echo form_hidden($hidden);
echo '<table>';
echo '<tr><td>Nom</td><td>prenom</td><td>date de naissance</td><td>supprimer de la classe</td><td>date de sortie de la classe</td></tr>';
foreach($elevesDeLaClasse as $unEleve)
{
    $supprime=array(
        'name'=>'supprime[]',
        'value'=>$unEleve->NoEnfant
    );
    $dateFin=array(
        'name'=>$unEleve->NoEnfant,
        'type'=>'date'
    );
    echo '<tr><td>';
    echo $unEleve->Nom;
    echo '</td><td>';
    echo $unEleve->Prenom;
    echo '</td><td>';
    echo $unEleve->DateNaissance;
    echo '</td><td>';
    echo form_checkbox($supprime);
    echo '</td><td>';
    echo form_input($dateFin);
    echo '</td></tr>';
}
echo '</table>';
echo '<h1>ajouter des élèves</h1>';
echo '<table>';
    echo '<tr>';
        echo '<td>';
            echo form_label('selection multiple possible','selection');
        echo '</td>';
        echo '<td>';
            echo form_multiselect('selection[]', $lesEleves);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label("date d'entré en classe pour les enfants selectionnés",'dateDebut');
        echo '</td>';
        echo '<td>';
            echo form_input($dateDebut);
        echo '</td>';
    echo '</tr>';
echo '</table>';
echo '</br>';
echo form_submit($submit);
echo form_close();