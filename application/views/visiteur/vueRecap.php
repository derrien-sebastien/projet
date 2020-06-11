<?php
//donnees entré
//'donneesCommandeGlobal' tableau 'noEvenement' 'annee' 'noProduit' 'quantite' 'imgProduit' 'libelle'  
//'totale'  
//'modeReglement' 
//'Regler'

$commentaire=array(
    'name'          =>  'commentaire',
    'type'          =>  'textarea',
    'class'         =>  'textarea-control',
);
$submit=array(
    'name'          => 'submit',
    'class'         => 'btn',
    'value'         => 'valider'
);
$hidden=array(
    
    'modeReglement' =>  $modeReglement,
    'total'         =>  $total
);
echo form_open('visiteur/finCommande');
echo form_hidden($hidden);
echo '<br>';
echo '<div class="container-fluid">';
    echo '<h1 class="encadre">Récpitulatif de votre commande</h1>';
    echo '<div align="center">';
        echo form_label("<h3><B>Si vous désirez être livré à une adresse differente de votre domicile veuillez l'indiquer en commentaire</B></h3>");
    echo '</div>';
    
            echo '<table class="tableCommande">';

        foreach($donneesCommandeGlobal as $unProduit)
        {
            echo '<tr>';
                if(!isset($unProduit['imgProduit']))
                {
                    echo '<td>';
                        echo '<img src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" width="75"/>'; 
                    echo '</td>';
                }
                else
                {
                    echo '<td>';
                        echo '<img src="'.base_url().'assets/images/'.$unProduit["imgProduit"].'"class="img-thumbnail" width="75"/>';
                    echo '</td>';
                }
                if(!isset($unProduit["libelle"]))
                {
                    echo '<td>';
                        echo form_label('Information non disponible.');                
                    echo '</td>';
                }
                else
                {
                    echo '<td>';
                        echo form_label($unProduit["libelle"]);                
                    echo '</td>';
                }
                if(!isset($unProduit["quantite"]))
                {
                    echo '<td>';
                        echo form_label('Information non disponible.');                
                    echo '</td>';
                }
                else
                {
                    echo '<td>';
                        echo form_label($unProduit["quantite"]);                
                    echo '</td>';
                }            
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
                echo form_label('Type de reglement choisie :&nbsp; ');
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
                echo form_label('ajouter un commentaire :');
            echo '</td>';
            echo '<td>';
                echo form_input($commentaire);
            echo '</td>';
        echo '</tr>';
    echo '</table>';
    
    if($modeReglement== 'Cheque/Espece')
    {
        if(isset($submit))
        {
            echo '<div align="center">';
                echo form_submit($submit);
            echo '</div>';
        }
    }
    elseif($modeReglement== 'Carte Bancaire')
    {
        if(isset($submit))
        {
            echo '<div align="center">';
                echo form_submit($submit);
            echo '</div>';
        }
    }
echo '</div>';

?>


