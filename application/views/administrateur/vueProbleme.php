<?php
/* probleme lier a la base de donnée a solutionner par l'admin 
// - enfant sans etre correspondant 
// - etre corespondant inactif 
// - classe sans eleve 
// - 

$données d'entrée:

-$enfantSansCorrepondant
-$lesClassesSansEnfant


$données de sortie:

-enfantsSC[]:   -mail
                -noEnfant
-


controleur a crée :
//-modifCorrespondantEnfant (modif base de donnée etre correspondant)
*/

if (isset($enfantSansCorrepondant))
{
    $LenfantSC=array(

    );
    $inputEnfantSC=array(

    );
    echo "<H1>les enfants suivant n'ont pas de correspondant</h1>";
    echo form_open('Administrateur/modifCorrespondantEnfant');
    echo'<table>';
    echo '<tr><td>nom&emsp;</td><td>prenom&emsp;</td><td>date de naissance&emsp;</td><td>entrez un mail de correspondant</td></tr>';
    foreach($enfantSansCorrepondant as $unEnfant)
    {        
        $nom=$unEnfant->Nom;
        $prenom=$unEnfant->Prenom;
        $dateNaiss=$unEnfant->DateNaissance;        
        $inputEnfantSC['name']=$unEnfant->NoEnfant;
        echo '<tr><td>';
        echo form_label($nom);
        echo '&emsp;</td><td>';
        echo form_label($prenom);
        echo '&emsp;</td><td>';
        echo form_label($dateNaiss);
        echo '&emsp;</td><td>';
        echo form_input($inputEnfantSC);
        echo '</td></tr>';      
    }  
    echo '</table>';
    echo form_submit('submit', 'submit');
    echo form_close();
}
if(isset($classesSansEnfants))
{
    echo form_open('Administrateur/AjouterEleve');    
    echo '<table>';
    echo '<tr><td>classe&emsp;</td><td>nombre d\'eleve&emsp;</td><td>modifier&emsp;</td></tr>';
    foreach($classesSansEnfants as $classe)
    {
        if($classe->NbEleves)
        {
            $ajouter=array(
                'name'=>$classe->Noclasse,
                'value'=>1
            );
            echo '<tr><td>';
            echo $classe->nom;
            echo '&emsp;</td><td>';
            echo $classe->nbEleves;
            echo '&emsp;</td><td>';
            echo form_checkbox($ajouter);
            echo '&emsp;</td></tr>';        
        }
    }    
    echo '</table>';
    echo form_submit('ajouter', 'ajouter');
    echo form_close();  
}
