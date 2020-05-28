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
    'type'  =>  'date',
    'name'  =>  'dateDebut'
);
$submit=array(
    'name'  =>  'modifications',
    'value' =>  'envoyer les modifications',
    'class' =>  'btn btn-primary'
);
$hidden=array(
    'classe'=>$classe->NoClasse
);
echo form_open_multipart('Administrateur/modifierClasse');
echo form_hidden($hidden);
echo '<h1>Modification des élèves de : ';
echo $classe->Nom;
echo '</h1></br>';
echo '<table>';
    echo '<tr>';
        echo '<td>';
            echo 'Nom';
        echo '&emsp;</td>';
        echo '<td>';
            echo 'Prénom';
        echo '&emsp;</td>';
        echo '<td>';
            echo 'Date de naissance';
        echo '&emsp;</td>';
        echo '<td>';
            echo 'Supprimer de la classe';
        echo '&emsp;</td>';
        echo '<td>';
            echo 'Date de sortie de la classe';
        echo '</td>';
    echo '</tr>';
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
        echo '<tr>';
            echo '<td>';
                echo $unEleve->Nom;
            echo '</td>';
            echo '<td>';
                echo $unEleve->Prenom;
            echo '</td>';
            echo '<td>';
                echo $unEleve->DateNaissance;
            echo '</td>';
            echo '<td>';
                echo form_checkbox($supprime);
            echo '</td>';
            echo '<td>';
                echo form_input($dateFin);
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';
echo '</br>';
echo '<h1>Ajouter des élèves</h1>';
echo '<table>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Selection multiple possible','selection');
        echo '</td>';
        echo '<td>';
            echo form_multiselect('selection[]', $lesEleves);
        echo '</td>';
    echo '</tr>';
    echo '</br>';
    echo '<tr>';
        echo '<td>';
            echo form_label("Date d'entrée en classe pour les enfants selectionnés",'dateDebut');
        echo '</td>';
        echo '<td>';
            echo form_input($dateDebut);
        echo '</td>';
    echo '</tr>';
echo '</table>';
echo '</br>';
echo form_submit($submit);
echo form_close();