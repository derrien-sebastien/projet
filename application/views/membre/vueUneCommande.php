<?php
echo '<section class="sectionCommande">';
    $memoireEvenement=0;
    $MMC=1;//Memoire Modification Commande
    $submit=array(
        'name'      =>  'modification',
        'value'     =>  'Modifier',
        'class'     =>  'btn btn-primary'
    );
    $submit2=array(
        'name'      =>  'modification',
        'value'     =>  'ANNULER COMMANDE',
        'class'     =>  'btn btn-primary'
    );
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
            'min'   =>  '0',
            'step'  =>  '1',
            'name'  =>  'Qty[]',
            'type'  =>  'number',
            'size'  =>  '5' 
        );
        $hidden=array(
            'NoCommande[]'=>$uneLigne['ligneCommande']->NoCommande,
            'NoProduit[]'=>$uneLigne['ligneCommande']->NoProduit, 
            'MontantTotal[]'=>$uneLigne['ligneCommande']->MontantTotal       
        );
        echo form_hidden($hidden);
        echo '<div class="row">';
            
                    echo '<div align="center">';
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
                    }
                        echo '<table class="tableCommande" cellpadding="0" cellspacing="0" border="0">';
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
                                        echo $uneLigne['produit']->LibelleCourt;  
                                }
                                if(isset($uneLigne['produit']->Prix))
                                {
                                        echo form_label("Prix d'un produit");
                                        echo $uneLigne['produit']->Prix;
                                }
                                if(isset($uneLigne['ligneCommande']->Quantite))
                                {
                                    echo form_label("Quantité commandée");
                                    if($MMC!=0)
                                    {
                                        echo form_input($quantite);
                                    }
                                    else
                                    {
                                    echo $uneLigne['ligneCommande']->Quantite;
                                }   
                                echo form_label('total pour cet article');
                                echo $uneLigne['produit']->Prix*$uneLigne['ligneCommande']->Quantite;
                            }
                            echo '</td>';
                        echo '</tr>';
                    echo'</table>';
                    $donnee=$uneLigne['ligneCommande'];
}
                    echo '<table class="tableCommande" cellpadding="0" cellspacing="0" border="0">';
                        echo '<tr>';
                            if(isset($donnee->ModePaiement))
                            {
                                echo '<td>';
                                    echo form_label('Mode de paiement ');
                                echo'</td>';
                                echo '<td>';
                                    echo $donnee->ModePaiement;
                                echo'</td>';
                            }
                            if(isset($donnee->MontantTotal))
                            {
                                echo '<td>';
                                    echo form_label("Pour un montant total de");
                                echo'</td>';
                                echo '<td>';
                                    echo $donnee->MontantTotal;
                                echo'</td>';
                            } 
                            if(isset($donnee->MontantTotal) && isset($donnee->ResteAPayer))
                            {
                                echo '<td>';
                                    echo form_label("vous avez regler");
                                echo'</td>';
                                echo '<td>';
                                    echo $donnee->MontantTotal-$donnee->ResteAPayer;
                                echo'</td>';
                            } 
                        echo '</tr>';
                    echo'</table>';

                    if($MMC!=0)
                    {
                        echo '<div align="center">';
                        echo '<button name="payementCb" class="btn btn-primary">PAYER EN LIGNE</button>&emsp;';
                            echo form_submit($submit);
                            echo '&emsp;';
                            echo form_submit($submit2); 
                        echo '</div>';   
                        echo form_close();
                    }
                echo '</div>';
        
    echo '</div>';
echo '</section>';