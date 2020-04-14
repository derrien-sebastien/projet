<?php
echo form_open ('visiteur/catalogueEvenement');
echo '<table>';
echo '<tr><td>Image</td><td>&nbsp;&nbsp; Description &nbsp;&nbsp;</td><td>Tarif HT &nbsp;&nbsp;&nbsp;&nbsp;</td><td>Tarif TTC&nbsp;&nbsp;</td><td>&nbsp;Ajouter au panier&nbsp;</td></tr>';
foreach ($LesProduits as $UnProduit):
    $Tarif=($UnProduit->PRIXHT+(($UnProduit->PRIXHT*$UnProduit->TAUXTVA)/100));
    $InfoBalise=array(
     'type'=>'number',
     'name'=>$UnProduit->NOPRODUIT,
     'value'=>0   
    );
    echo'<tr><td>';
    echo img($UnProduit->NOMIMAGE.".jpg");
    echo'</td><td>&nbsp;';
    echo $UnProduit->LIBELLE;
    echo'</td><td>';
    echo $UnProduit->PRIXHT;
    echo'</td><td>';
    echo $Tarif;
    echo'</td><td>';
    echo form_input($InfoBalise);
    echo '</td></tr>';
endforeach; 
echo '</table>';
echo form_submit('valider','envoyer' );
echo form_close();


