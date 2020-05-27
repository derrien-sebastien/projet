<?php
    /*données d'entrée:
    -$evenement
    -$lesProduit
    -$produitDeL'evenement
    -$Provenance 

    donnée de sortie:
    -provenance
    -noEvenement
    -imgEntete
    -imgPiedDePage
    -anneeEvenement
    -dateMiseEnLigne
    -dateMiseHorsLigne
    -texteEntete
    -texteCorps
    -textePied
    -txtImgEntete
    -supImgEntete 
    -txtImgPiedDePage 
    -supImgPiedPage 
    -emailInfo 
    -enCours 
    -ajoutProduit
    -dateRemiseProduit
    -produit
    -submit

    */
    //echo "<h1>inserez un nouvel evenement</h1>";
    //echo validation_errors(); 
    $hidden=array(
        'provenance'=>  $Provenance    
    );
    if ($Provenance =='modifier')
    {
        $hidden['anneeEvenement']   =   $evenement->Annee;
    }
    if (isset($evenement->NoEvenement))
    {
        $hidden['noEvenement']      =   $evenement->NoEvenement;
        $hidden['imgEntete']        =   $evenement->ImgEntete;
        $hidden['imgPiedDePage']    =   $evenement->ImgPiedDePage;
    }
    $anneeEvenement=array(
        'type'      =>  'number',
        'name'      =>  'anneeEvenement',
        'value'     =>  '2020',
        'class'     =>  'form-control'    
    );
    if(isset($evenement->Annee))
    {
        $anneeEvenement['value']    =   $evenement->Annee;
    }
    $dateMiseEnLigne=array(
        'type'      =>  'date',
        'name'      =>  'dateMiseEnLigne',
        'class'     =>  'form-control'
    );
    if(isset($evenement->DateMiseEnLigne))
    {
        $dateMiseEnLigne['value']   =   $evenement->DateMiseEnLigne;
    }
    $dateMiseHorsLigne=array(
        'type'      =>  'date',
        'name'      =>  'dateMiseHorsLigne',
        'class'     =>  'form-control'
    );
    if(isset($evenement->DateMiseHorsLigne))
    {
        $dateMiseHorsLigne['value'] =   $evenement->DateMiseHorsLigne;
    }
    $texteEntete=array(
        'id'        =>  'summernote',
        'type'      =>  'text',
        'name'      =>  'texteEntete',
        'class'     =>  'form-control'
    );
    if (isset($evenement->TxtHTMLEntete))
    {
        $texteEntete['value']       =   $evenement->TxtHTMLEntete;
    }
    $texteCorps=array(
        'id'        =>  'summernote1',
        'type'      =>  'text',
        'name'      =>  'texteCorps',
        'class'     =>  'form-control'
    );
    if (isset($evenement->TxtHTMLCorps))
    {
        $texteCorps['value']        =   $evenement->TxtHTMLCorps;
    }
    $textePied=array(
        'id'        =>  'summernote2',
        'type'      =>  'text',
        'name'      =>  'textePied',
        'class'     =>  'form-control'
    );
    if (isset($evenement->TxtHTMLPiedDePage))
    {
        $textePied['value']         =   $evenement->TxtHTMLPiedDePage;
    }
    $txtImgEntete=array(
        'type'      =>  'file',
        'name'      =>  'txtImgEntete',
        'id'        =>  'txtImgEntete',
        'class'     =>  'btn btn-primary'
    );
    $supImageEntete=array(
        'name'      =>  'supImgEntete',
        'value'     =>  'on'
    );
    $txtImgPiedDePage=array(
        'type'      =>  'file',
        'name'      =>  'txtImgPiedDePage',
        'id'        =>  'txtImgPiedDePage',
        'class'     =>  'btn btn-primary'
    );
    $supImgPiedPage=array(
        'name'      =>  'supImgPiedPage',
        'value'     =>  'on'
    );
    $emailInfo=array(
        'id'        =>  'summernote3',
        'type'      =>  'text',
        'name'      =>  'emailInfo',
        'class'     =>  'form-control'
    );
    if (isset($evenement->EmailInformationHTML))
    {
        $emailInfo['value']         =   $evenement->EmailInformationHTML;
    }
    $encours=array(
        'name'      =>  'enCours',
        'value'     =>  '1'
    );
    $ajouterProduit=array(
        'name'      =>  'ajoutProduit',
        'value'     =>  'oui'
    );
    $dateRemiseProduit=array(
        'type'      =>  'date',
        'name'      =>  'dateRemiseProduit'
    );
    $options=array(
        '//'        =>  'Aucun produit selectionné',
        '//'        =>  'Nouveau produit'
    );

    foreach ($lesProduits as $unProduit)
    {
        $produit            =   $unProduit->Annee.'/'.$unProduit->NoEvenement.'/'.$unProduit->NoProduit;
        $options[$produit]  =   $unProduit->LibelleCourt;
    }

    $submit=array(
        'name'      =>  'submit',
        'value'     =>  'envoyer',
        'class'     =>  'btn btn-primary'
    );

/////////////////////////////   FORMULAIRE  ////////////////////////////

echo '<div class="container-fluid">';
echo    "<h1 class='encadre'>Création d'évènement</h1>";
echo '</div>';
echo '</br>';
echo '<div class="container">';
echo    form_open_multipart('Administrateur/formulaireEvenement');
echo    form_hidden($hidden);
echo '<table class="table table-striped">';// voir avec renan type de table souhaité 
if ($Provenance=='ajouter')
{
    echo '<tr>';
        echo '<td>';
            echo form_label('Année :','AnneeEvenement' );// pourquoi ne pas utilisé annee en cour ?            
        echo "</td>";
        echo "<td>";
            echo form_input($anneeEvenement);
        echo"</td>";
    echo"</tr>";
    echo "<br>";
}
    echo "<tr>";
        echo "<td>";
            echo form_label('Date de mise en ligne :','DateMiseEnLigne');
        echo"</td>";
        echo "<td>";
            echo form_input($dateMiseEnLigne);
        echo"</td>";
    echo"</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('Date de mise hors ligne :','DateMiseHorsLigne');
        echo "</td>";
        echo "<td>";
            echo form_input($dateMiseHorsLigne);
        echo"</td>";
    echo"</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo"<td>";
            echo form_label("Texte de l'entête de l'évènement :",'TexteEntete'); 
        echo "</td>";
        echo"<td>";
            echo form_textarea($texteEntete); 
        echo"</td>";
    echo"</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo"<td>";
            echo form_label("Descriptif de l'évènement :",'TexteCorps');
        echo "</td>";
        echo "<td>";
            echo form_textarea($texteCorps);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label("Texte du pied de page de l'évènement :",'TextePied');
        echo "</td>";
        echo "<td>";
            echo form_textarea($textePied);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label("Image de l'entête :",'ImgEntete');
        echo "</td>";
        echo "<td>";
            echo form_input($txtImgEntete); 
            if (isset($evenement->ImgEntete))
            {           
                if ($evenement->ImgEntete!='')
                {
                    echo '<p><h4>Image actuellement choisie :</h4>';
                    echo'<img class="pull-left" width="150" src="'.base_url().'assets/images/'.$evenement->ImgEntete.'"class="img-thumbnail" />'; 
                }
            }
        echo "</td>";
        echo "<td>";
            echo form_checkbox($supImageEntete);
            echo "Supprimer l'image";
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('Image du pied de page:','txtImgPiedDePage');
        echo"</td>";
        echo "<td>";
            echo form_input($txtImgPiedDePage);
            if(isset($evenement->ImgPiedDePage))
            {
                if ($evenement->ImgPiedDePage!='') 
                {
                    echo '<p><h4>Image actuellement choisie : </h4>';
                    echo '<img class="pull-left" width="150" src="'.base_url().'assets/images/'.$evenement->ImgPiedDePage.'"class="img-thumbnail" />';
                }
            }
        echo "</td>";
        echo "<td>";
            echo form_checkbox($supImgPiedPage);
            echo "Supprimer l'image";
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('Information à joindre dans le mail:','EmailInfo');
        echo "</td>";
        echo "<td>";
            echo form_textarea($emailInfo);            
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label("Si vous souhaitez que l'évènement soit activé immédiatement coché",'EnCours');
        echo "</td>";
        echo "<td>";
            echo form_checkbox($encours);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo 'Produit';
        echo "</td>";
    echo "</tr>";
    echo '</br>';
    echo "<tr>";
        echo "<td>";
            echo form_label('Si cet évènement comptient des produits coché','AjoutProduit');
        echo "</td>";
        echo "<td>";
         echo form_checkbox($ajouterProduit);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('A quel date les produits seront remis au client : ');
        echo "</td>";
        echo "<td>";
            echo form_input($dateRemiseProduit);
        echo "</td>";
    echo "</tr>";
    echo "</br>";
    if ($Provenance=='modifier')
    {
        if(isset($produitDeLEvenement[0]))
        {
            echo "<tr>";
                echo "<td>";
                    echo "Les produits présent dans la base de données";
                echo "</td>";
            echo "</tr>";
            foreach ($produitDeLEvenement as $produitEvenement)
            {
                echo "<tr>";
                    echo "<td>";
                        echo $produitEvenement->LibelleCourt;
                    echo "</td>";
                echo "</tr>";
            } 
        }
    }   
    
    echo "<tr>";
        echo "<td>";
            echo form_label('Choisissez un/ou des produits à ajouter (Nouveau Produit si vous souhaiter le créer) ','produit');
        echo "</td>";
        echo "<td>";
            echo 
            form_multiselect('produit[]', $options);
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>";
            echo form_submit($submit);
        echo "</td>\n";
    echo "</tr>";
echo    '</table>';
echo    form_close();
echo '</div>';
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>

<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->


<script>
    $(document).ready(function()
    {
        $('#summernote').summernote({ lang: 'fr-FR' });
    });

    $(document).ready(function() 
    {
        $('#summernote1').summernote({ lang: 'fr-FR' });
    });

    $(document).ready(function() 
    {
        $('#summernote2').summernote({ lang: 'fr-FR' });
    });

    $(document).ready(function() 
    {
        $('#summernote3').summernote({ lang: 'fr-FR' });
    });
</script>;
