<?php
$hidden2=array(
  'NoEvenement'=>$noEvenement,
  'Annee'=>$annee
);
$memoireNoProduit=0;
$i=0;
$submit=array(
  'name'  =>'submit',
  'value' =>  'VALIDER',
  'class'=>  'btn btn-primary'
);
echo '<div class="container-fluid">';
  echo '<div class="row">';
    echo '<div class="col-lg-12" >';
    if(isset($produitsCommandes))
    {
      foreach($produitsCommandes as $unProduitCommander)
      {
        echo form_label('le produit '.$unProduitCommander->LibelleCourt.' a été commander '.$unProduitCommander->nbProduit.' fois');
        echo '</br>';
      }
    }
    if(isset($montantTotalCommandes))
    {
      echo form_label("le montant totale des commande pour cette evenement s'élève a : ".$montantTotalCommandes->MontantDesCommandes.'€');
      echo '</br>';
    }
    if(isset($montantPaye))
    {
      echo form_label("le montant déjà payé pour cette evenement s'élève a : ".$montantPaye->MontantPaye.'€');
      echo '</br>';
    }
      echo '<h1 class="encadre">Les commandes passées par les clients </h1>';
      echo'</br>';
      foreach($commandes as $commande)
      {
        echo '<div align="center">';
          echo 'Actuellement';
          echo '&nbsp;<h3>'.$commande->nbLignes.'</h3>&nbsp;Commandes en cours sur cette évènement';
        echo '</div>';
      } 
      echo '<h2 align="center">Ci-dessous, les commandes passées sur notre site.</h2>';
      echo form_open('Administrateur/commandesClients');
      echo form_hidden($hidden2);            
      foreach($ligneCommandes as $uneLigne)
      {
        
        if ($memoireNoProduit!=0 && $uneLigne->NoProduit!=$memoireNoProduit)
        {
          if($modif=='')
          {
            echo '</table>';
          }
          else
          {
              echo '</table>';
            echo '</div>';
            echo'<div align="center">';
              echo form_submit($submit);
            echo '</div>';
          }
        }
        if($uneLigne->NoProduit!=$memoireNoProduit)
        {
          echo '<h3 class="encadre">'.$uneLigne->LibelleCourt.'</h3>';
          if($modif=='')
          {
            echo '<table class="table table-bordered table-dark">';
          }
          else
          {
            echo '<div class="table-wrapper-scrollbarS scrollbarS">';
            echo '<table class="tableS tableS-bordered table-striped mb-0">';
          }
          echo'<thead>';
            echo '<tr>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Email</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Nom</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Prénom</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">N° Commande</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Quantité</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Total</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Payer</p>';
              echo '</th>';
              echo '<th class="thRecapCommande">';
                echo '<p align="center">Remis</p>';
              echo '</th>';
            echo '</tr>';
            echo '</thead>';
        }
        $hidden['noCommande['.$i.']']=$uneLigne->NoCommande;
        $hidden['noProduit['.$i.']']=$uneLigne->NoProduit; 
        $hidden['montantTotal['.$i.']']=$uneLigne->MontantTotal;   
        $hidden['noPersonne['.$i.']']=$uneLigne->NoPersonne;               
        $payer=array(
          'min'     =>  $uneLigne->Payer,
          'max'     =>  $uneLigne->MontantTotal,
          'step'    =>  '0.01',
          'type'    =>  'number',
          'name'    =>  'payer['.$i.']',
          'value'   =>  $uneLigne->Payer,
          'size'    =>  '5'
        );
        $remis=array(
          'min'     =>  $uneLigne->Remis,
          'max'     =>  $uneLigne->Quantite,
          'step'    =>  '1',
          'type'    =>  'number',
          'name'    =>  'remis['.$i.']',
          'value'   =>  $uneLigne->Remis,
          'size'    =>  '5'
        );
        echo '<tbody>';
          echo form_hidden($hidden);
          echo '<tr>';
            echo '<td class="tdRecapCommande" align="center">';
              echo $uneLigne->Email;
            echo'</td>';
            echo '<td class="tdRecapCommande" align="center">';
              echo $uneLigne->Nom;
            echo'</td>';
            echo '<td class="tdRecapCommande" align="center">';
              echo $uneLigne->Prenom;
            echo '</td>';
            echo '<td class="tdRecapCommande" align="center">';
              echo $uneLigne->NoCommande;
            echo '</td>';
            echo '<td class="tdRecapCommande" align="center">';
              echo $uneLigne->Quantite;
            echo '</td>';
            echo '<td class="tdRecapCommande" align="center">';
              echo $uneLigne->MontantTotal;
            echo '</td>';
            if($modif=='')
            {
              if($uneLigne->Payer != 0)
              {
                echo '<td class="tdRecapCommande" align="center">';
                  echo $uneLigne->Payer;
                echo '</td>';
              }
              else
              {
                echo '<td>';
                echo '</td>';
              }
            }
            else
            {
                echo '<td>';
                  echo form_input($payer);
                echo '</td>';
            }
            if($modif=='')
            {
              if($uneLigne->Remis != 0)
              {
                echo '<td class="tdRecapCommande" align="center">';
                  echo $uneLigne->Remis;
                echo '</td>';
              }
              else
              {
                echo '<td>';
                echo '</td>';
              }
            }
            else
            {
              /* if($uneLigne->Remis != $uneLigne->Quantite)
              {
                echo '<td class="tdRecapCommande" align="center">';
                  echo form_input($remis);
                echo '</td>';
              }
              else
              { */
                echo '<td>';
                  echo form_input($remis);
                echo '</td>';
              /* } */
            }
          echo '</tr>';
        echo '</tbody>';
        if($uneLigne->NoProduit!=$memoireNoProduit)
        {
          $memoireNoProduit=$uneLigne->NoProduit;
        }
        $i++;      
      }
      if($modif=='')
      {
        echo '</table>';
      }
      else
      {
          echo '</table>';
        echo '</div>';
        echo'<div align="center">';
          echo form_submit($submit);
        echo '</div>';
      } 
      echo form_close();            
    echo '</div>';
  echo '</div>';
echo '</div>';  
