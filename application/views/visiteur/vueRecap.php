<?php
//donnees entré
//'donneesCommandeGlobal' tableau 'noEvenement' 'annee' 'noProduit' 'quantite' 'imgProduit' 'libelle'  
//'totale'  
//'modeReglement' 
//'Regler'
//'noCommande' 

$commentaire=array(
    'name'      =>  'commentaire',
    'type'      =>  'textarea',
    'class'     =>  'textarea.form-control',
);
$submit=array(
    'name'  => 'submit',
    'class' => 'btn btn-primary',
    'value' => 'valider'
);
$hidden=array(
    'noCommande'=> $noCommande,
    'modeReglement'=>$modeReglement,
    'total'=>$total
);
echo form_open('visiteur/finCommande');
echo form_hidden($hidden);
echo '<br>';
echo '<div class="container-fluid">';
    echo '<h1 class="encadre">Récpitulatif de votre commande</h1>';
    echo '<div align="center">';
        echo form_label("<h3><B>Si vous désirez être livré à une adresse differente de votre domicile veuillez l'indiquer en commentaire</B></h3>");
    echo '</div>';
    echo '<table>';
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
        echo '<div align="center">';
            echo form_submit($submit);
        echo '</div>';
    }
    elseif($modeReglement== 'Carte Bancaire')
    {
        echo '<div align="center">';
            echo '<button name="payementCb" class="btn btn-primary">Redirection vers site payement en ligne</button>';
        echo '</div>';
    }
echo '</div>';

?>
