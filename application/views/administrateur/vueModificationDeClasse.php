<?php
/*
donnée entré
-$classe 
-$elvesDeLaClasse 
-$eleves
*/
echo '<h1>modification des eleve de :';
echo $classe->Nom;
echo '</h1></br>';
echo form_open_multipart('Administrateur/modifierClasse');
echo form_hidden('classe', $classe->NoClasse);
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
echo '<h1>ajouter des eleves</h1>';
echo 'selection multiple possible';
$lesEleves=array(
    '0'=>'selectionner pour ajouter'
);
foreach($eleves as $unEleve)
{
    $lesEleves[$unEleve->NoEnfant]=$unEleve->Nom.' '.$unEleve->Prenom;
}
echo form_multiselect('selection[]', $lesEleves);
echo '</br>';
$submit=array(
    'name'=>'modifications',
    'value'=>'envoyer les modifications'
);
echo form_submit($submit);
echo form_close();