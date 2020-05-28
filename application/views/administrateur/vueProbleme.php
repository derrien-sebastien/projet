<?php
/* probleme lier a la base de donnée a solutionner par l'admin 
// - enfant sans etre correspondant 
// - etre corespondant inactif 
// - classe sans eleve 
// - stock inferieur a 10 
// - est evenement qui devrait etre en cours mais le sont pas 

$données d'entrée:

-$enfantSansCorrespondant
-$lesClassesSansEnfant
-$stockLimite



$données de sortie:

-enfantsSC[]:   -mail
                -noEnfant
-


controleur a crée :
//-modifCorrespondantEnfant (modif base de donnée etre correspondant)
*/

//un choix possible en modification de classe a mettre en griser si un selectionner
echo '</br>';
if(isset($enfantSansCorrespondant['0']))
{
    $submit=array(
        'name'=>'submit',
        'value'=>'submit'
    );
    $LenfantSC=array();
    $inputEnfantSC=array();

    echo "<h1 class='encadre'>Enfants sans correspondant </h1>";
    echo form_open('Administrateur/modifCorrespondantEnfant');
    echo'<table>';
        echo '<tr>';
        echo '<td>';
            echo 'Nom&emsp;';
        echo '</td>';
        echo '<td>';
            echo 'Prénom&emsp;';
        echo '</td>';
        echo '<td>';
            echo 'Date de naissance&emsp;';
        echo '</td>';
        echo '<td>';
            echo 'Entrez un mail de correspondant';
        echo '</td>';
    echo '</tr>';
    foreach($enfantSansCorrespondant as $unEnfant)
    {        
        $nom=$unEnfant->Nom;
        $prenom=$unEnfant->Prenom;
        $dateNaiss=$unEnfant->DateNaissance;        
        $inputEnfantSC['name']=$unEnfant->NoEnfant;
        echo '<tr>';
            echo '<td>';
                echo form_label($nom);
            echo '&emsp;</td>';
            echo '<td>';
                echo form_label($prenom);
            echo '&emsp;</td>';
            echo '<td>';
                echo form_label($dateNaiss);
            echo '&emsp;</td>';
            echo '<td>';
                echo form_input($inputEnfantSC);
            echo '</td>';
        echo '</tr>';      
    }  
    echo '</table>';
    echo form_submit($submit);
    echo form_close();
}
if(isset($classesSansEnfants))
{ 
    $submit2=array(
        'name'=>'envoyer',
        'value'=>'envoyer'
    );
    echo "</br>";
    echo "<h1 class='encadre'>Classes qui sont à compléter </h1>";
    echo form_open('Administrateur/modifierClasse');    
    echo '<table>';
        echo '<tr>';
            echo '<td>';
                echo'classe&emsp;';
            echo '</td>';
            echo '<td>';
                echo 'nombre d\'eleve&emsp;';
            echo '</td>';
            echo '<td>';
                echo 'modifier&emsp;';
            echo '</td>';
        echo '</tr>';
    foreach($classesSansEnfants as $classe)
    { 
        $ajouter=array(
            'name'=>'classe',
            'value'=>$classe->NoClasse
        );
        echo '<tr>';
            echo '<td>';
                echo $classe->Nom;
            echo '&emsp;</td>';
            echo '<td>';
                echo $classe->NbEleves;
            echo '&emsp;</td>';
            echo '<td>';
                echo form_checkbox($ajouter);
            echo '&emsp;</td>';
        echo '</tr>';        
    }    
    echo '</table>';
    echo form_submit($submit2);
    echo form_close();  
}
if(isset($stockLimite))
{
    $submit3=array(
        'name'=>'submit',
        'value'=>'submit'
    );
    echo "<h1 class='encadre'>Produits dont le stock est trop limite</h1>";
    echo form_open('Administrateur/modifStockLimite');
    echo'<table>';
        echo '<tr>';
            echo '<td>';
                echo 'Nom du produit : ';
            echo '</td>';
            echo '<td>';
                echo 'Nom Evenement : ';
            echo '</td>';
            echo '<td>';
                echo 'taille du stock : ';
            echo '</td>';
        echo '</tr>';
        foreach ($stockLimite as $unProduit)
        {   
            $produit=$unProduit->Annee.'/'.$unProduit->NoEvenement.'/'.$unProduit->NoProduit;
            $stock=array(
                'name'=>'produit['.$produit.']',
                'value'=>$unProduit->Stock,
                'type'=>'number'
            );
            echo '<tr>';
            echo '<td>';
                echo $unProduit->LibelleCourt;
            echo '</td>';
            echo '<td>';
                echo $unProduit->TxtHTMLEntete;
            echo '</td>';
            echo '<td>';
                echo form_input($stock);
            echo '</td>';
            echo '</tr>';
        }
    echo '</table>';
    echo form_submit($submit3);
    echo form_close();
}
if(isset($evenementNormalementEnCours))
{
    $submit4=array(
        'name'=>'submit',
        'value'=>'submit'
    );
    echo "<h1 class='encadre'>Evènements qui devrait être actif </h1>";
    echo form_open('Administrateur/activation');
    echo'<table>';
        echo '<tr>';
            echo '<td>';
                echo 'Nom Evenement : ';
            echo '</td>';
            echo '<td>';
                echo 'activé ';
            echo '</td>';
        echo '</tr>';
        foreach($evenementNormalementEnCours as $unEvenement)
        {
            $evenement=$unEvenement->Annee.'/'.$unEvenement->NoEvenement;
            $activer=array(
                'name'=>'activer[]',
                'value'=>$evenement
            );
            echo '<tr>';
                echo '<td>';
                    echo $unEvenement->TxtHTMLEntete;
                echo '</td>';
                echo '<td>';
                    echo form_checkbox($activer);
                echo '</td>';
            echo '</tr>';
        }
    echo '</table>';
    echo form_submit($submit4);
    echo form_close();
}