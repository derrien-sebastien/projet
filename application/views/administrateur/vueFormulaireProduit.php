</br>
<?php
if (isset($_POST['Produit']))
			{
				$AncienEvenement=explode("/",$_POST['Produit']);
  				$Donnees['Annee']=$this->input->post('AnneeEvenement');
   				$Donnees['NoEvenement']=$this->input->post('NoEvenement');
    			$Donnees['libelleHTML']=$AncienEvenement['2'];
    			$Donnees['libelleCourt']=$AncienEvenement['3'];
    			$Donnees['prix']=$AncienEvenement['4'];
    			$Donnees['img_Produit']=$AncienEvenement['5'];
    			$Donnees['stock']=$AncienEvenement['6'];
    			$Donnees['numeroOrdreApparition']=$AncienEvenement['7'];
    			$Donnees['etre_Ticket']=$AncienEvenement['8'];
    			$Donnees['ImgTicket']=$AncienEvenement['9'];
            }	             				
echo "<h1>inserez un nouveau Produit</h1>";
//echo validation_errors(); 
echo form_open_multipart('Administrateur/formulaireProduit');
if (isset($Donnees['NoEvenement']))
{
    echo "<input type='hidden' name='NoEvenement' value='".$Donnees['NoEvenement']."'>";
    echo "<input type='hidden' name='Annee' value='".$Donnees['Annee']."'>";
    echo "<input type='hidden' name='img_Produit' value='".$Donnees['img_Produit']."'>";
    echo "<input type='hidden' name='ImgTicket' value='".$Donnees['ImgTicket']."'>";
}
echo "<table>\n";
echo "<tr><td><label for='libelleHTML'>description du produit: </label></td>
<td><textarea  id='summernote'  name='libelleHTML' value=''/>";
if (isset($Donnees['libelleHTML']))
{
    echo $Donnees['libelleHTML'];
}
echo "</textarea> </td></tr>";
echo "<br>\n";
echo "<tr><td><label for='libelleCourt'>intitulé du produit: </label></td>
<td><textarea type='text' name='libelleCourt' value=''/>";
if (isset($Donnees['libelleCourt']))
{
    echo $Donnees['libelleCourt'];
}
echo"</textarea></td></tr>";
echo "<br>\n";
echo "<td><label for='prix'>prix: </label></td>
<td><input type='number' placeholder='1.0' step='0.01' name='prix' value='";
echo $Donnees['prix'];
echo"'/></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='img_Produit'> image du produit:</label></td>
<td><input type='file' name='img_Produit' ></td><td>";
if (isset($Donnees['img_Produit']))
{
     echo '<p>Image actuellement choisie : '.$Donnees['img_Produit'].'</p>';
}
echo "</td><td><input type='checkbox' name='supImgProduit' /> supprimer l'image</td></tr>";
echo "<br>\n";
echo "<tr><td><label for='stock'>Taille du stock: </label></td>
<td><input type='number' placeholder='1.0' step='1' name='stock' value='";
echo $Donnees['stock'];
echo"'/></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='numeroOrdreApparition'>Numero d'ordre d'aparition: </label></td>
<td><input type='number' placeholder='1.0' step='1' name='numeroOrdreApparition' value='";
echo $Donnees['numeroOrdreApparition'];
echo"'/></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='etreTicket'>edition de ticket neccesaire 0)non 1)oui: </label></td>
<td><input type='number' placeholder='1.0' step='1' name='etreTicket' value='1'/></td></tr>";
echo "<br>\n";
echo "<tr><td><label for='ImgTicket'> image du produit:</label></td>
<td><input type='file' name='ImgTicket' ></td><td>";
if (isset($Donnees['ImgTicket']))
{
     echo '<p>Image actuellement choisie : '.$Donnees['ImgTicket'].'</p>';
}
echo "</td><td><input type='checkbox' name='supImgTicket' /> supprimer l'image</td></tr>";
echo "<br>\n";
echo "<tr><td><input type='submit' name='submit' value='envoyer'></td><td></td>\n";
echo "</tr></table>";
echo "</form>";
echo "<script>
$(document).ready(function() {
    $('#summernote').summernote();
});
</script>";
?>