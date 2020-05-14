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
    'provenance'=>$Provenance    
);
if ($Provenance=='modifier')
{
    $hidden['anneeEvenement']=$evenement->Annee;
}
if (isset($evenement->NoEvenement))
{
    $hidden['noEvenement']=$evenement->NoEvenement;
    $hidden['imgEntete']=$evenement->ImgEntete;
    $hidden['imgPiedDePage']=$evenement->ImgPiedDePage;
}
$anneeEvenement=array(
    'type'=>'number',
    'name'=>'anneeEvenement',
    'value'=>'2020',    
);
if(isset($evenement->Annee))
{
    $anneeEvenement['value']=$evenement->Annee;
}
$dateMiseEnLigne=array(
    'type'=>'date',
    'name'=>'dateMiseEnLigne'
);
if(isset($evenement->DateMiseEnLigne))
{
    $dateMiseEnLigne['value']=$evenement->DateMiseEnLigne;
}
$dateMiseHorsLigne=array(
    'type'=>'date',
    'name'=>'dateMiseHorsLigne'
);
if(isset($evenement->DateMiseHorsLigne))
{
    $dateMiseHorsLigne['value']=$evenement->DateMiseHorsLigne;
}
$texteEntete=array(
    'id'=>'summernote',
    'type'=>'text',
    'name'=>'texteEntete'
);
if (isset($evenement->TxtHTMLEntete))
{
    $texteEntete['value']=$evenement->TxtHTMLEntete;
}
$texteCorps=array(
    'id'=>'summernote1',
    'type'=>'text',
    'name'=>'texteCorps'
);
if (isset($evenement->TxtHTMLCorps))
{
    $texteCorps['value']=$evenement->TxtHTMLCorps;
}
$textePied=array(
    'id'=>'summernote2',
    'type'=>'text',
    'name'=>'textePied'
);
if (isset($evenement->TxtHTMLPiedDePage))
{
    $textePied['value']=$evenement->TxtHTMLPiedDePage;
}
$txtImgEntete=array(
    'type'=>'file',
    'name'=>'txtImgEntete',
    'id'=>'txtImgEntete'
);
$supImageEntete=array(
    'name'=>'supImgEntete',
    'value'=>'on'
);
$txtImgPiedDePage=array(
    'type'=>'file',
    'name'=>'txtImgPiedDePage',
    'id'=>'txtImgPiedDePage'
);
$supImgPiedPage=array(
    'name'=>'supImgPiedPage',
    'value'=>'on'
);
$emailInfo=array(
    'id'=>'summernote3',
    'type'=>'text',
    'name'=>'emailInfo'
);
if (isset($evenement->EmailInformationHTML))
{
    $emailInfo['value']=$evenement->EmailInformationHTML;
}
$encours=array(
    'name'=>'enCours',
    'value'=>'1'
);
$ajouterProduit=array(
    'name'=>'ajoutProduit',
    'value'=>'oui'
);
$DateRemiseProduit=array(
    'type'=>'date',
    'name'=>'DateRemiseProduit'
);
$options=array(
    '//'=>'Aucun produit selectionné',
    '//'=>'Nouveau produit'
);

foreach ($lesProduits as $unProduit)
{
    $produit=$unProduit->Annee.'/'.$unProduit->NoEvenement.'/'.$unProduit->NoProduit;
    $options[$produit]=$unProduit->LibelleCourt;
}

$submit=array(
    'name'=>'submit',
    'value'=>'envoyer'
);

/////////////////////////////   FORMULAIRE  ////////////////////////////

echo '<div class="container">';
echo    "<h1 class='encadre'>Création d'un évènement</h1>";
echo '</div>';
echo '</br>';
echo '<div class="container">';
echo    form_open_multipart('Administrateur/formulaireEvenement');
echo    form_hidden($hidden);
echo '<table class="table table-striped">';
if ($Provenance=='ajouter')
{
    echo '<tr>';
        echo '<td>';
            echo form_label('année:','AnneeEvenement' );            
        echo "</td>";
        echo "<td>";
            echo form_input($anneeEvenement);
        echo"</td>";
    echo"</tr>";
    echo "<br>";
}
    echo "<tr>";
        echo "<td>";
            echo form_label('date de mise en ligne:','DateMiseEnLigne');
        echo"</td>";
        echo "<td>";
            echo form_input($dateMiseEnLigne);
        echo"</td>";
    echo"</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('date de mise hors ligne:','DateMiseHorsLigne');
        echo "</td>";
        echo "<td>";
            echo form_input($dateMiseHorsLigne);
        echo"</td>";
    echo"</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo"<td>";
            echo form_label("Texte de l'entete de l'evenement:",'TexteEntete'); 
        echo "</td>";
        echo"<td>";
            echo form_textarea($texteEntete); 
        echo"</td>";
    echo"</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo"<td>";
            echo form_label("descriptif de l'evenement:",'TexteCorps');
        echo "</td>";
        echo "<td>";
            echo form_textarea($texteCorps);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label("Texte du pied de page de l'evenement:",'TextePied');
        echo "</td>";
        echo "<td>";
            echo form_textarea($textePied);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label("Image d'entete:",'ImgEntete');
        echo "</td>";
        echo "<td>";
            echo form_input($txtImgEntete); 
            if (isset($evenement->ImgEntete))
            {           
                if ($evenement->ImgEntete!='')
                {
                    echo '<p><h4>Image actuellement choisie :</h4>'.$evenement->ImgEntete.'</p>';
                }
            }
        echo "</td>";
        echo "<td>";
            echo form_checkbox($supImageEntete);
            echo "supprimer l'image";
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('Image de pied de page:','txtImgPiedDePage');
        echo"</td>";
        echo "<td>";
            echo form_input($txtImgPiedDePage);
            if(isset($evenement->ImgPiedDePage))
            {
                if ($evenement->ImgPiedDePage!='') 
                {
                    echo '<p><h4>Image actuellement choisie : </h4>'.$evenement->ImgPiedDePage.'</p>';
                }
            }
        echo "</td>";
        echo "<td>";
            echo form_checkbox($supImgPiedPage);
            echo "supprimer l'image";
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('information a joindre dans le mail:','EmailInfo');
        echo "</td>";
        echo "<td>";
            echo form_textarea($emailInfo);            
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('en cours','EnCours');
        echo "</td>";
        echo "<td>";
            echo form_checkbox($encours);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('cet evenement comptient il des produit : ','AjoutProduit');
        echo "</td>";
        echo "<td>";
         echo form_checkbox($ajouterProduit);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('date de remise des produit : ');
        echo "</td>";
        echo "<td>";
            echo form_input($DateRemiseProduit);
        echo "</td>";
    echo "</tr>";
    echo "</br>";
    if ($Provenance=='modifier')
    {
        if(isset($produitDeLEvenement[0]))
        {
            var_dump($produitDeLEvenement);
            echo "<tr>";
                echo "<td>";
                    echo "les produits present sont :";
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
            echo form_label('choisissez un/ou des produits :','produit');
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
        $('#summernote').summernote();
    });

    $(document).ready(function() 
    {
        $('#summernote1').summernote();
    });

    $(document).ready(function() 
    {
        $('#summernote2').summernote();
    });

    $(document).ready(function() 
    {
        $('#summernote3').summernote();
    });
</script>;
