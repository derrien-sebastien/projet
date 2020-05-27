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
    'name'      =>  'modif',
    'value'     =>  'modif',
    'checked'   =>  TRUE,
);
$submit=array(
    'name'      =>  'existant',
    'value'     =>  'envoyer',
    'class'     =>  'btn btn-primary'
);
$selected='';
////////////////////////////////////////////////////////////////////////
//////////////////////////////  PROVENANCE  ////////////////////////////
/////////////////////////////   FORMULAIRE  ////////////////////////////
////////////////////////////////////////////////////////////////////////
echo '</br>';
if($Provenance==='modifier')
{
    echo '<div class="container-fluid">';
        echo "<h1 class='encadre'>Choissisez un evenement à modifier</h1>";
    echo '</div>';
    echo form_open('Administrateur/modifierEvenement');
    echo "<input type='hidden' name='Provenance' value='".$Provenance."'>"; 
}
elseif($Provenance=='commande')
{
    echo '<div class="container-fluid">';
        echo "<h1>Choissisez un evenement pour voir les commandes associées</h1>";
    echo '</div>';
    echo form_open('Administrateur/selectionCommande');
    echo "<input type='hidden' name='Provenance' value='".$Provenance."'>";  
}
elseif($Provenance=='ajouter')
{
    echo '<div class="container-fluid">';
        echo "<h1 class='encadre'>Pour pré-remplir le formulaire </h1>";
    echo '</div>';
    $donnees['Provenance']='ajouter';
    echo form_open('Administrateur/ajouterEvenement',$donnees);
}
elseif($Provenance=='activer')
{
    echo form_open('Administrateur/changerLEtatDunEvenement');
    echo '<div class="container-fluid">';
        echo "<h1 class='encadre'>Choissisez un evenement pour en changer l'état</h1>";
    echo '</div>';
}
else
{
    echo form_open('Administrateur/formulaireEvenement');
}
echo '<div align="center">';
    echo '<div class="drop">';
        echo form_label('<h4>Choisissez :</h4>','evenement');
        echo form_dropdown('evenement',$evenement,$selected,'class="form-control selectpicker" data-size="8"');
        if($Provenance=='commande')
        {    
            echo form_label('selectionnez pour modifier la commande &nbsp&nbsp '); 
            echo form_checkbox($commande);
        }
        echo '<div align="center">';
            echo form_submit($submit);
        echo '</div>';
    echo '</div>';
echo '</div>';
echo form_close();

//////////////////////////////  FIN DU FORMULAIRE ///////////////////////////////////////

?>
