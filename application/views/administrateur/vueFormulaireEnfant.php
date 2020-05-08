<?php
/*données entrée
    $selection
    $lesClasses
 données sortie 
    -nom
    -prenom
    -dateNaissance
    -classe
*/
$nom=array(
    'name'=>'nom[]'
);  
$prenom=array(
    'name'=>'prenom[]'
);
$dateNaissance=array(
    'name'=>'dateNaissance[]',
    'type'=>'date'
);
$classe=array(
    'sans'=>'aucune classe'
);
foreach($lesClasses as $uneClasse)
{
    $classe[$uneClasse['NoClasse']]=$uneClasse['Nom'];
}
echo "<h1>ajout d'élève</h1>";
echo form_open('Administrateur/ajoutEleve2');
echo '<table>';
    if ($selection=='plusieurs')
    {
       $nbEleves=25;      
    }
    else
    {
        $nbEleves=1; 
    }
    for ($i=1;$i<=$nbEleves;$i++):
    echo '<tr>';
        echo'<td>';
            echo form_label('Nom :','nom');
        echo '</td>';
        echo '<td>';
            echo form_input($nom);
        echo '</td>';
    if($selection=='un')
    {
        echo '</tr>';
        echo '<br>';
        echo '<tr>';
    }
        echo'<td>';
            echo form_label('Prenom :','prenom');
        echo '</td>';
        echo '<td>';
            echo form_input($prenom);
        echo '</td>';
    if($selection=='un')
    {
        echo '</tr>';
        echo '<br>';
        echo '<tr>';
    }
        echo'<td>';
            echo form_label('Date de naissance :');
        echo '</td>';
        echo '<td>';
            echo form_input($dateNaissance);
        echo '</td>';
    if($selection=='un')
    {
        echo '</tr>';
        echo '<br>';
        echo '<tr>';
    }
        echo'<td>';
            echo form_label('classe :');
        echo '</td>';
        echo '<td>';
            echo form_dropdown('classe[]',$classe);
        echo '</td>';
    echo '</tr>';
endfor;
echo '</table>';
echo form_submit('envoyer', 'envoyer');
