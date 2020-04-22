</br>
<?php
/*if (isset($_POST['Evenement']))
{
    $AncienEvenement=explode("/",$_POST['Evenement']);
    $Donnees['Annee']=$AncienEvenement['0'];
    $Donnees['NoEvenement']=$AncienEvenement['1'];
    $Donnees['DateMiseEnLigne']=$AncienEvenement['2'];
    $Donnees['DateMiseHorsLigne']=$AncienEvenement['3'];
    $Donnees['TxtHTMLEntete']=$AncienEvenement['4'];
    $Donnees['TxtHTMLCorps']=$AncienEvenement['5'];
    $Donnees['TxtHTMLPiedDePage']=$AncienEvenement['6'];
    $Donnees['ImgEntete']=$AncienEvenement['7'];
    $Donnees['ImgPiedDePage']=$AncienEvenement['8'];
    $Donnees['EmailInformationHTML']=$AncienEvenement['9'];
}*/
//echo "<h1>inserez un nouvel evenement</h1>";
//echo validation_errors(); 
$hidden=array(
    'Provenance'=>$Provenance    
);
if (isset($evenement->NoEvenement))
{
    $hidden['NoEvenement']=$evenement->NoEvenement;
    $hidden['ImgEntete']=$evenement->ImgEntete;
    $hidden['ImgPiedDePage']=$evenement->ImgPiedDePage;
}
$anneeEvenement=array(
    'type'=>'number',
    'name'=>'AnneeEvenement',
    'value'=>$evenement->Annee
);
$dateMiseEnLigne=array(
    'type'=>'date',
    'name'=>'DateMiseEnLigne',
    'value'=>$evenement->DateMiseEnLigne
);
$dateMiseHorsLigne=array(
    'type'=>'date',
    'name'=>'DateMiseHorsLigne',
    'value'=>$evenement->DateMiseHorsLigne
);
$texteEntete=array(
    'id'=>'summernote',
    'type'=>'text',
    'name'=>'TexteEntete'
);
if (isset($evenement->TxtHTMLEntete))
{
    $texteEntete['value']=$evenement->TxtHTMLEntete;
}
$texteCorps=array(
    'id'=>'summernote1',
    'type'=>'text',
    'name'=>'TexteCorps'
);
if (isset($evenement->TxtHTMLCorps))
{
    $texteCorps['value']=$evenement->TxtHTMLCorps;
}
$textePied=array(
    'id'=>'summernote2',
    'type'=>'text',
    'name'=>'TextePied'
);
if (isset($evenement->TxtHTMLPiedDePage))
{
    $textePied['value']=$evenement->TxtHTMLPiedDePage;
}
$txtImgEntete=array(
    'type'=>'file',
    'name'=>'txtImgEntete'
);
$supImageEntete=array(
    'name'=>'supImgEntete',
    'value'=>'on'
);
$txtImgPiedDePage=array(
    'type'=>'file',
    'name'=>'txtImgPiedDePage'
);
$supImgPiedPage=array(
    'name'=>'supImgPiedPage',
    'value'=>'on'
);
$emailInfo=array(
    'id'=>'summernote3',
    'type'=>'text',
    'name'=>'EmailInfo'
);
$encour=array(
    'name'=>'EnCours',
    'value'=>'on'
);
$ajouterProduit=array(
    'name'=>'AjoutProduit',
    'value'=>'oui'
);
$option=array(
    '//'=>'Aucun produit selectionné',
    '//'=>'Nouveau produit'
);
foreach ($lesProduit as $unProduit):
    $option[$unProduit->Annee.'/'.$unProduit->NoEvenement.'/'.$unProduit->NoProduit]=$unProduit->LibelleCourt;
endforeach;
$submit=array(
    'name'=>'submit',
    'value'=>'envoyer'
);


echo form_open_multipart('Administrateur/formulaireEvenement');
echo form_hidden($hidden);

echo "<table>";
    echo"<tr>";
        echo "<td>";
            echo form_label('année:','AnneeEvenement' );            
        echo "</td>";
        echo "<td>";
            echo form_input($anneeEvenement);
        echo"</td>";
    echo"</tr>";
    echo "<br>";
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
                echo '<p><h4>Image actuellement choisie :</h4>'.$evenement->ImgEntete.'</p>';
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
            if (isset($evenement->ImgPiedDePage)) 
            {
                echo '<p><h4>Image actuellement choisie : </h4>'.$evenement->ImgPiedDePage.'</p>';
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
            if (isset($evenement->TxtHTMLEntete))
            {
                echo $evenement->EmailInformationHTML;
            }
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
            echo form_label('voulez vous ajouter un article','AjoutProduit');
        echo "</td>";
        echo "<td>";
         echo form_checkbox($ajouterProduit);
        echo "</td>";
    echo "</tr>";
    echo "<br>\n";
    echo "<tr>";
        echo "<td>";
            echo form_label('choisissez un/ou des produits :','produit');
        echo "</td>";
        echo "<td>";
            echo 
            form_dropdown('Produit', $options);
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>";
            echo form_submit($submit);
        echo "</td>\n";
    echo "</tr>";
echo "</table>";
echo form_close();
echo "<script>
$(document).ready(function() {
    $('#summernote').summernote();
});
</script>";
echo "<script>
$(document).ready(function() {
    $('#summernote1').summernote();
});
</script>";
echo "<script>
$(document).ready(function() {
    $('#summernote2').summernote();
});
</script>";
echo "<script>
$(document).ready(function() {
    $('#summernote3').summernote();
});
</script>";


?>