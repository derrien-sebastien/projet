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
    'value'     =>  'envoyer'
);

if($evenement->EnCours==1)
{
    $activer['checked']=true;
}

/////////////////////////////// FORMULAIRE   ////////////////////////////////////////
echo '<div>';
echo    form_open('Administrateur/changerLEtatDunEvenement');
echo    form_hidden($hidden);
echo    "<h1>changer d'état</h1>";
echo    '<br>';
echo    '</br>';
echo    "vous avez choisi d'activer ou de desactiver l'evenement : ";
echo    '</br>';
echo    $evenement->TxtHTMLEntete;
echo    '</br>';
echo    '</br>';
echo    form_label('activation/deshactivation','activer');
echo    '';
echo    form_checkbox($activer);
echo    '</br>';
echo    form_submit($submit);
echo '</div>'

//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>