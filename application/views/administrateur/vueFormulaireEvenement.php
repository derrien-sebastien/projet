</br>
<?php
if (isset($_POST['Evenement']))
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
}
//echo "<h1>inserez un nouvel evenement</h1>";
//echo validation_errors(); 
echo form_open_multipart('Administrateur/formulaireEvenement');
echo "<input type='hidden' name='Provenance' value='".$Provenance."'>";
if (isset($Donnees['NoEvenement']))
{
    echo "<input type='hidden' name='NoEvenement' value='".$Donnees['NoEvenement']."'>";
    echo "<input type='hidden' name='ImgEntete' value='".$Donnees['ImgEntete']."'>";
    echo "<input type='hidden' name='ImgPiedDePage' value='".$Donnees['ImgPiedDePage']."'>";
    
} 
echo "<table><tr>\n";
echo "<td><label for='AnneeEvenement'>année:</label></td>
<td><input type='number' name='AnneeEvenement' value='";
echo $Donnees['Annee'];
echo"'></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='DateMiseEnLigne'>date de mise en ligne:</label></td>
<td><input type='date' name='DateMiseEnLigne' value='";
echo $Donnees['DateMiseEnLigne'];
echo"'></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='DateMiseHorsLigne'>date de mise hors ligne:</label></td>
<td><input type='date' name='DateMiseHorsLigne' value='";
echo $Donnees['DateMiseHorsLigne'];
echo"'></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='TexteEntete'>Texte de l'entete de l'evenement:</label></td>
<td><textarea id='summernote' type='text' name='TexteEntete'>";
if (isset($Donnees['TxtHTMLEntete']))
{
    echo $Donnees['TxtHTMLEntete'];
}
echo"</textarea></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='TexteCorps'>descriptif de l'evenement:</label></td>
<td><textarea id='summernote1' type='text' name='TexteCorps' >";
if (isset($Donnees['TxtHTMLCorps']))
{
    echo $Donnees['TxtHTMLCorps'];
}
echo "</textarea></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='TextePied'>Texte du pied de page de l'evenement:</label></td>
<td><textarea id='summernote2' type='text' name='TextePied'>";
if (isset($Donnees['TxtHTMLPiedDePage']))
{
    echo $Donnees['TxtHTMLPiedDePage'];
}
echo "</textarea></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='ImgEntete'>Image d'entete:</label></td>
<td><input type='file' name='txtImgEntete'>";
if (isset($Donnees['ImgEntete']))
{
     echo '<p><h4>Image actuellement choisie :</h4>'.$Donnees['ImgEntete'].'</p>';
}
echo "</td><td><input type='checkbox' name='supImgEntete' /> supprimer l'image</td></tr>";
echo "<br>\n";
echo "<tr><td><label for='txtImgPiedDePage'> Image de pied de page:</label></td>
<td><input type='file' name='txtImgPiedDePage' >";
if (isset($Donnees['ImgPiedDePage'])) 
{
    echo '<p><h4>Image actuellement choisie : </h4>'.$Donnees['ImgPiedDePage'].'</p>';
}
echo "</td><td><input type='checkbox' name='supImgPiedPage' /> supprimer l'image</td></tr>";
echo "<br>\n";
echo "<tr><td><label for='EmailInfo'>information a joindre dans le mail:</label></td>
<td><textarea id='summernote3' type='text' name='EmailInfo'>";
if (isset($Donnees['TxtHTMLEntete']))
{
    echo $Donnees['EmailInformationHTML'];
}
echo "</textarea></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='EnCours'>en cours</label></td>
<td><input type='checkbox' name='EnCours' value=''/></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='AjoutProduit'>voulez vous ajouter un article</label></td>
<td><input type='checkbox' name='AjoutProduit' value='oui'/></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='produit'>choisissez:</label></td>
<td><select name='Produit'>
    <option value='/////////'>Aucun produit selectionné</option>
    <option value='/////////'>Nouveau produit</option>";
    foreach ($lesProduit as $unProduit):
        echo "<option value='";
        echo $unProduit->NoEvenement."/".$unProduit->NoProduit."/".$unProduit->LibelleHTML
        ."/".$unProduit->LibelleCourt."/".$unProduit->Prix."/".$unProduit->Img_Produit."/".$unProduit->Stock
        ."/".$unProduit->NumeroOrdreApparition."/".$unProduit->Etre_Ticket."/".$unProduit->ImgTicket;
        echo "'>";
        echo $unProduit->LibelleCourt;
        echo "</option>";
   endforeach; 
echo "</select></td></tr>";
echo "<tr><td><input type='submit' name='submit' value='envoyer'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
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