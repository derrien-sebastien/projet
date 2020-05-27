<?php

//////////////////////////////  Déclaration de nos Variables ////////////////////////////

$hidden=array(
    'evenement' =>  $evenement->Annee.'/'.$evenement->NoEvenement
);
$activer=array(
    'name'      =>  'activer'
);
$submit=array(
    'name'      =>  'submit',
    'value'     =>  'envoyer',
    'class'     =>  'btn btn-primary'
);

if($evenement->EnCours==1)
{
    $activer['checked']=true;
}

/////////////////////////////// FORMULAIRE   ////////////////////////////////////////
echo form_open('Administrateur/changerLEtatDunEvenement');
    echo '<div class="container-fluid">';
        echo '<h2 class="encadre" align="center">Activer/Désactiver un évènement</h2>';
        echo '<div>';
            echo form_hidden($hidden);
            echo "<h1>changer d'état</h1>";
            echo '<br>';
            echo '</br>';
            echo "vous avez choisi d'activer ou de desactiver l'evenement : ";
            echo '</br>';
            echo $evenement->TxtHTMLEntete;
            echo '</br>';
            echo '</br>';
            echo form_label('activation/deshactivation','activer');
            echo '';
            echo form_checkbox($activer);
            echo '</br>';
            echo form_submit($submit);
        echo '</div>';
    echo '</div>';
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>