<?php
echo "</br>";
echo form_open ('accueil/Catalogue');
echo '<table>';
echo '<tr><td>Image</td><td>&nbsp;&nbsp; Description Produit &nbsp;&nbsp;</td><td>Prix Produit &nbsp;&nbsp;&nbsp;&nbsp;</td><td>Tarif TTC&nbsp;&nbsp;</td><td>&nbsp;Ajouter au panier&nbsp;</td></tr>';
foreach ($lesProduits as $unProduit):
    $InfoBalise=array(
     'type'=>'number',
     'name'=>$unProduit->NoProduit,
     'value'=>''  
    );
    echo'<tr><td>';
    /* echo base_url().'assets/images/'.$unProduit->Img_Produit;.// a revoir pour la publicationde l'image  */
    echo'</td><td>&nbsp;';
    echo $unProduit->LibelleCourt;
    echo'</td><td>';
    echo $unProduit->Prix;
    echo'</td><td>';
    echo "total";
    echo'</td><td>';
    echo form_input($InfoBalise);
    echo '</td></tr>';
endforeach; 
echo '</table>';
echo form_submit('valider','envoyer' );
echo form_close();