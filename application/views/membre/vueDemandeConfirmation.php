<?php
echo '<div>';
echo    '<H1>Veuillez confirmer que vous souhaitez vous désabonner de la newsletter</h1>';
echo form_open('Membre/...');
echo form_submit('annuler','annuler');
echo form_submit('confirmer','confirmer');
echo form_close();
echo '</div>';