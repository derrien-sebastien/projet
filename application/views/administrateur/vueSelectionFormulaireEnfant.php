<?php
$selection=array(
    'un'=>'un élève',
    'plusieurs'=>'plusieurs élèves'
);
echo "<h1>combien d'eleves souhaitez vous créé?</h1>";
echo form_open('Administrateur/ajoutEleve');
echo form_dropdown('selection', $selection);
echo form_submit('submit','submit');
echo form_close();
