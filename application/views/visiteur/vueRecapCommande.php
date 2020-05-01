<?php
echo heading('RECAP COMMANDE ',2);
    echo br();
        foreach ($listeProduits as $unProduit) 
        {
            echo "1  " . $unProduit->id . " " . $unProduit->description . " " . $unProduit->prix . br();
        }
    echo br(2);
echo " Commande du " . $commande[0] . " N° " . $commande[1];
?>