<?php
$hidden=array(
    'evenement'=>$evenement->Annee.'/'.$evenement->NoEvenement
);
$activer=array(
'name'=>'activer'
);
if($evenement->EnCours==1)
{
    $activer['checked']=true;
}
$submit=array(
    'name'=>'submit',
    'value'=>'envoyer'
);
echo form_open('Administrateur/changerLEtatDunEvenement');
echo form_hidden($hidden);
echo "<h1>changer d'état</h1>";
echo '<br>';
echo '</br>';
echo "vous avez choisi d'activer ou de desactiver l'evenement : ";
echo '</br>';
echo $evenement->TxtHTMLEntete;
echo '</br>';
echo '</br>';
echo  form_label('activation/deshactivation','activer');
echo '';
echo form_checkbox($activer);
echo '</br>';
echo form_submit($submit);
