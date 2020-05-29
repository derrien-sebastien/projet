<?php
echo '</br>';
$memoireEvenement=0;
$MMC=1;//Memoire Modification Commande
foreach($donneesLigne as $uneLigne)
{
    if($uneLigne['evenement']->EnCours==0)
    {
        $MMC=0;
    }
    if($uneLigne['ligneCommande']->Payer>0)
    {
        $MMC=0;
    }
}
$submit=array(
    'name'=>'modification',
    'value'=>'Modifier'
);
if($MMC!=0)
{
    echo form_open('membre/modificationCommande');
}
echo '<div class="container-fluid">';
    echo '<h1 class="encadre">Votre commande n°'.$noCommande.'</h1>';
echo'</div>';


foreach($donneesLigne as $uneLigne)
{   
    $quantite=array(
        'name'=>'Qty',
        'type'=>'number'
    );
    if(isset($uneLigne['ligneCommande']->Quantite))
    {
        $quantite['value']=$uneLigne['ligneCommande']->Quantite;
    }
    if($uneLigne['ligneCommande']->NoEvenement!=$memoireEvenement)
    {
        $memoireEvenement=$uneLigne['ligneCommande']->NoEvenement;
        echo '<div class="container-fluid">';
            echo '<h4 class="encadre">'.$uneLigne['evenement']->TxtHTMLEntete.'</h4>';
        echo'</div>';
        //voir saut de ligne decalage ou juste encadrer du txt a reflechir
    }



    echo '<table align="center">';
        echo '<tr>';
            if(!isset($uneLigne['produit']->Img_Produit))
            {
                echo '<td align="center">';
                    echo '<img src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" width="250"/>'; 
                echo '</td>';
            }
            else
            {
                echo '<td align="center">';
                    echo '<img src="'.base_url().'assets/images/'.$uneLigne['produit']->Img_Produit.'"class="img-thumbnail" width="250"/>';
                echo '</td>';
            }
            echo '<td>';
            if(isset($uneLigne['produit']->LibelleCourt))
            {
            
                    echo form_label('Produit commandé');
                    echo'</br>';
                    echo $uneLigne['produit']->LibelleCourt;
        
                
            }
            echo'</br>';
            if(isset($uneLigne['produit']->Prix))
            {
            
                    echo form_label("Prix d'un produit");
                    echo '</br>';
                    echo $uneLigne['produit']->Prix;

            }
            echo'</br>';
            if(isset($uneLigne['ligneCommande']->Quantite))
            {
            
                    echo form_label("Quantité commandée");
                    echo '</br>';
                    if($MMC!=0)
                    {
                        echo form_input($quantite);
                    }
                    else
                    {
                        echo $uneLigne['ligneCommande']->Quantite;
                    }
                    echo'</br>';
                    echo form_label('total pour cet article');
                    echo $uneLigne['produit']->Prix*$uneLigne['ligneCommande']->Quantite;

            }
            echo '</td>';
        echo '</tr>';
    echo'</table>';
    $donnee=$uneLigne['ligneCommande'];
}
echo '<table>';
    echo '<tr>';
        echo '<td>';
        if(isset($donnee->ModePaiement))
        {
                echo form_label('Vous avez choisi de payer par ');
            echo'</td>';
            echo '<td>';
                echo $donnee->ModePaiement;
        }
        echo'</td>';
        echo '<td>';
        echo'&nbsp;';
        if(isset($donnee->MontantTotal))
        {
                echo form_label("Pour un montant total de");
            echo'</td>';
            echo '<td>';
                echo $donnee->MontantTotal;
        } 
        if(isset($donnee->MontantTotal) && isset($donnee->ResteAPayer))
        {
                echo form_label("vous avez regler");
            echo'</td>';
            echo '<td>';
                echo $donnee->MontantTotal-$donnee->ResteAPayer;
        } 
        echo'</td>';
    echo '</tr>';
echo'</table>';
 
if($MMC!=0)
{
    echo form_submit($submit);    
    echo form_close();
}