</br>
<?php
/*

*/
////////////////////////////// Déclaration de nos Variables ////////////////////////////

$evenement=array(
    '0/0'   =>  'Nouvel Evenement'
);
foreach ($lesEvenements as $unEvenement)
{
    $valeur=$unEvenement->Annee."/".$unEvenement->NoEvenement;
    $evenement[$valeur]=$unEvenement->Annee.'   '.$unEvenement->TxtHTMLEntete;
}
$commande=array(
    'name'  =>  'modif',
    'value' =>  'modif'
);
$submit=array(
    'name'  =>  'existant',
    'value' =>  'envoyer',
    'class' =>  'btn btn-primary'
);
$selected='';
////////////////////////////////////////////////////////////////////////
//////////////////////////////  PROVENANCE  ////////////////////////////
/////////////////////////////   FORMULAIRE  ////////////////////////////
////////////////////////////////////////////////////////////////////////
echo '</br>';
        if($Provenance==='modifier')
        {
echo        '<div class="container">';
echo            "<h1 class='encadre'>choissisez un evenement a modifier</h1>";
echo        '</div>';
echo        form_open('Administrateur/modifierEvenement');
echo        "<input type='hidden' name='Provenance' value='".$Provenance."'>"; 
        }
        elseif($Provenance=='commande')
        {
echo        '<div class="container">';
echo            "<h1>choissisez un evenement pour voir les commandes associé</h1>";
echo        '</div>';
echo        form_open('Administrateur/selectionCommande');
echo        "<input type='hidden' name='Provenance' value='".$Provenance."'>";  
        }
        elseif($Provenance=='ajouter')
        {
echo        '<div class="container">';
echo            "<h1 class='encadre'>Pour pré-remplir le formulaire </h1>";
echo        '</div>';
            $donnees['Provenance']='ajouter';
echo        form_open('Administrateur/ajouterEvenement',$donnees);
        }
        elseif($Provenance=='activer')
        {
            echo form_open('Administrateur/changerLEtatDunEvenement');
        }
        else
        {
echo        form_open('Administrateur/formulaireEvenement');
        }
echo '<div align="center">';

echo                '<div class="drop">';
echo                    form_label('<h4>Choisissez :</h4>','evenement');
echo                    form_dropdown('evenement',$evenement,$selected,'class="form-control selectpicker" data-size="8"');
            if($Provenance=='commande')
            {    
echo                    form_label('selectionnez pour modifier la commande &nbsp&nbsp '); 
echo                    form_checkbox($commande);
            }
echo                '<div align="center">';
echo                    form_submit($submit);
echo                '</div>';
echo    form_close();
echo '</div>';

//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>

<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->