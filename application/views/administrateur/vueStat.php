<?php 
$submit=array(
    'name'      =>  'submit',
    'value'     =>  'VALIDER',
    'class'     =>  'btn'
);
$hidden=array(
    'NoEvenement'=>$noEvenement,
    'Annee'=>$annee
);
echo form_open('Administrateur/statistrique');
echo form_hidden($hidden);
echo '<table>';
    echo '<tr>';
    echo '<td>';
    echo '</td>';
    echo '<td>';
    echo '</td>';
    echo '</tr>';
echo '</table>';
echo form_close();