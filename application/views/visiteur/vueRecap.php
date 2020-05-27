<?php
//donnees entré
//'donneesCommandeGlobal' tableau 'noEvenement' 'annee' 'noProduit' 'quantite' 'imgProduit' 'libelle'  
//'totale'  
//'modeReglement' 
//'Regler'
//'noCommande' 

$commentaire=array(
    'name'  =>  'commentaire'
);
$submit=array(
    'name'  => 'submit',
    'class' => 'btn btn-primary',
    'value' => 'valider'
);
$hidden=array(
    'noCommande'=> $noCommande
);
echo form_open('visiteur/finCommande');
echo form_hidden($hidden);
echo '<table>';
    foreach($donneesCommandeGlobal as $unProduit)
    {
        echo '<tr>';
            echo '<td>';
            echo '<img src="'.base_url().'assets/images/'.$unProduit["imgProduit"].'"class="img-thumbnail" width="75"/>';
            echo '</td>';
            echo '<td>';
                echo form_label($unProduit["libelle"]);                
            echo '</td>';
            echo '<td>';
                echo form_label($unProduit["quantite"]);                
            echo '</td>';            
        echo '</tr>';
    }
    echo '<tr>';
        echo '<td>';
            echo form_label('Montant total :');
        echo '</td>';
        echo '<td>';
            echo form_label($total);
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo form_label('type de reglement :');
        echo '</td>';
        echo '<td>';
            echo form_label($modeReglement);
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo form_label('Déjà Réglé :');
        echo '</td>';
        echo '<td>';
            echo form_label($total-($total-$Regler));
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo form_label("si vous desirez etre livré à une adresse differente veuillez l'indiquer en commentaire");
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo form_label('ajouter un commentaire :');
        echo '</td>';
        echo '<td>';
            echo form_input($commentaire);
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo form_submit($submit);
        echo '</td>';
    echo '</tr>';
var_dump($noCommande);
echo '</table>';
