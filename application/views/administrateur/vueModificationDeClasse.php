<?php
/*
donnée entré
-$classe 
-$elvesDeLaClasse 
-$eleve
*/
echo '<h1>modification des eleve de :';
echo $classe->Nom;
echo '</h1></br>';
echo form_open('Administrateur/modifierClasse');
echo '<table>';
echo '<tr><td>Nom</td><td>prenom</td><td>date de naissance</td><td>supprimer de la classe</td><td>date de sortie de la classe</td></tr>';
foreach($elvesDeLaClasse as $unEleve)
{
    $supprime=array(
        'name'=>'supprime',
        'value'=>$unEleve->NoEnfant
    );
    $dateFin=array(
        'name'=>$unEleve->NoEnfant,
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

echo     


echo '</table>';
