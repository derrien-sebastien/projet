<?php

if (isset($eleves['0']->Nom))
{
    if(isset($classe->Nom))//a modifier if $classe is object
    {
        echo '<h2>les eleves de la classe "'.$classe->Nom.'" sont :</h2>';
    
    }
    else
    {
        echo "<h2>les eleves sont : </h2>";
    }
    echo '</br>';
    echo '<table>';
    echo '<tr><td>';
    echo 'Nom';
    echo '</td><td>';
    echo 'Prenom';
    echo '</td><td>';
    echo 'Date de naissance';
    echo '</td></tr>';
    foreach ($eleves as $unEleve)
    {
        echo '<tr><td>';
        echo $unEleve->Nom;
        echo '</td><td>';
        echo $unEleve->Prenom;
        echo '</td><td>';
        echo $unEleve->DateNaissance;
        echo '</td></tr>'; 
    }
    echo '</table>';
    
}
else
{
    if(isset($classe->Nom))//a modifier if $classe is object
    {
        echo '<h2>'.$classe->Nom.'</h2>';
    
    }
    else
    {
        echo "<h2>classe introuvable </h2>";
    }
    echo "<h1>il n'y a pas d'eleve dans la classe</h1>";
}