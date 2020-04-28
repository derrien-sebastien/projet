<?php
/*données d'entrée:
	-$NoEvenement
	-$Annee
	-$produit
	-$provenance 
	-$evenement (liste evenement de l'annee)
donnée de sortie:
	-'provenance'
	-'noEvenenment'
	-'annee'
	-'noProduit'
	-'libelleHTML'
	-'libelleCourt'
	-'prix'
	-'img_Produit'
	-'supImgProduit'
	-'stock'
	-'numeroOrdreApparition'
	-'etreTicket'
	-'ImgTicket'
	-'supImgTicket'
	-'autreProduit'
	-'submit'
*/

$hidden=array(
	'provenance'=>$provenance
);
if ($provenance=='modifier')
{	
	$hidden['noEvenenment']=$produit->NoEvenement;
	$hidden['annee']=$produit->Annee;
	$hidden['noProduit']=$produit->NoProduit;
	$hidden['img_Produit']=$produit->Img_Produit;
	$hidden['imgTicket']=$produit->ImgTicket;
}
elseif($provenance=='modifierEvenement'||$provenance=='ajouterEvenement')
{
	$hidden['noEvenenment']=$NoEvenement;
	$hidden['annee']=$Annee;
}
$annee=array(
	'name'=>'annee',
	'type'=>'date'
);
$noEvenement=array(
	'1'=>'evenement non defini'
);
if(isset($evenement))
{
	foreach ($evenement as $unEvenement)
	{
		$noEvenement[$unEvenement->NoEvenement]=$unEvenement->LibelleCourt;
	}
}		
$libelleHtml=array(
	'id'=>'summernote',
	'name'=>'libelleHTML'
);
if (isset($produit->LibelleHTML))
{
    $libelleHtml['value']=$produit->LibelleHTML;
}
$libelleCourt=array(
	'name'=>'libelleCourt',
	'type'=>'text'
);
if (isset($produit->LibelleCourt))
{
    $libelleCourt['value']=$produit->LibelleCourt;
}
$prix=array(
	'type'=>'number',
	'placeholder'=>'1.0',
	'step'=>'0.01',
	'name'=>'prix'
);
if (isset($produit->Prix))
{
    $prix['value']=$produit->Prix;
}
$img_Produit=array(
	'type'=>'file',
	'name'=>'txtImg_Produit'
);
$supImgProduit=array(
	'type'=>'checkbox',
 	'name'=>'supImgProduit'
);
$stock=array(
	'type'=>'number',
	'placeholder'=>'1.0',
	'step'=>'1',
	'name'=>'stock'
);
if (isset($produit->Stock))
{
	$stock['value']=$produit->Stock;
}
$numeroOrdreApparition=array(
	'type'=>'number',
	'placeholder'=>'1.0',
	'step'=>'1',
	'name'=>'numeroOrdreApparition'
);
if (isset($produit->NumeroOrdreApparition))
{
	$numeroOrdreApparition['value']=$produit->NumeroOrdreApparition;
}
$etreTicket=array(
	'type'=>'number',	
	'placeholder'=>'1.0',
	'step'=>'1',
	'name'=>'etreTicket',
	'value'=>'1'
);
$imgTicket=array(
	'type'=>'file',
	'name'=>'txtImgTicket'
);
$supImgTicket=array(
	'type'=>'checkbox',
	'name'=>'supImgTicket'
);
$autre=array(
	'name'=>'autreProduit'
);
$submit=array(
	'name'=>'submit',
	'value'=>'envoyer'
);  


echo "<br>";           				
echo "<h1>inserez un nouveau Produit</h1>";
echo form_open_multipart('Administrateur/formulaireProduit');
echo form_hidden($hidden);
echo "<table>";
if ($provenance=='ajouter')
{
	echo "<tr>";
		echo "<td>";
			echo form_label("année de l'evenement", 'annee');
		echo "</td>";
		echo "<td>";
			echo form_input($annee);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('selectionnez un evenement ', 'noEvenment');
		echo "</td>";
		echo "<td>";
			echo form_dropdown('noEvenement',$noEvenement);
		echo "</td>";
	echo "</tr>";	
}
	echo "<tr>";
		echo "<td>";
			echo form_label('description du produit: ', 'libelleHTML');
		echo "</td>";
		echo "<td>";
			echo form_textarea($libelleHtml);
		echo "</td>";
	echo "</tr>";
	echo "<br>";
	echo "<tr>";
		echo "<td>";
			echo form_label('intitulé du produit: ','libelleCourt');
		echo "</td>";
		echo "<td>";
			echo form_textarea($libelleCourt);
		echo "</td>";
	echo "</tr>";
	echo "<br>\n";
	echo "<tr>";
		echo "<td>";
			echo form_label('prix: ','prix');
		echo "</td>";
		echo "<td>";
			echo form_input($prix);
		echo "</td>";
	echo "</tr>";
	echo "<br>\n";
	echo "<tr>";
		echo "<td>";
			echo form_label('image du produit: ','img_Produit');
		echo "</td>";
		echo "<td>";
			echo form_input($img_Produit);
		echo "</td>";
	 	echo "</tr>";
	if (isset($produit->img_Produit))
	{
		echo "<br>\n";
		echo "<tr>";
			echo "<td>";
				echo 'Image actuellement choisie : ';
				echo $produit->img_Produit;
			echo "</td>";	
			echo "<td>";
				echo form_checkbox($supImgProduit);
				echo " supprimer l'image ";
			echo "</td>";
		echo "</tr>";
	}
	echo "<br>\n";
	echo "<tr>";
		echo "<td>";
			echo form_label('Taille du stock: ','stock');
		echo "</td>";
		echo "<td>";
			echo form_input($stock);
		echo "</td>";
	echo "</tr>";
	echo "<br>\n";
	echo "<tr>";
		echo "<td>";
			echo form_label("Numero d'ordre d'aparition: ",'numeroOrdreApparition');
		echo "</td>";
		echo "<td>";
			echo form_input($numeroOrdreApparition);
		echo "</td>";
	echo "</tr>";
	echo "<br>\n";
	echo "<tr>";
		echo "<td>";
			echo form_label('edition de ticket neccesaire 0)non 1)oui: ','etreTicket');
		echo "</td>";
		echo "<td>";
			echo form_input($etreTicket);
		echo "</td>";
	echo "</tr>";
	echo "<br>\n";
	echo "<tr>";
		echo "<td>";
			echo form_label('image du produit : ','ImgTicket');
		echo "</td>";
		echo "<td>";
			echo form_input($imgTicket);
		echo "</td>";
	echo "</tr>";
	if (isset($produit->ImgTicket))
	{
		echo "<br>\n";
		echo "<tr>";
			echo "<td>";
				echo 'Image actuellement choisie : ';
				echo $produit->ImgTicket;
			echo "</td>";
			echo "<td>";
				echo form_checkbox($supImgTicket);			
				echo "supprimer l'image";
			echo "</td>";
		echo"</tr>";
	}
	echo "<br>\n";
	echo "<tr>";
		echo"<td>";
			echo form_label('souhaitez vous inserer un autre produit ?','autre');
		echo "</td>";
		echo "<td>";
			echo form_checkbox($autre);
		echo "</td>";
	echo "</tr>";
	echo "<br>\n";
	echo "<tr>";
		echo"<td>";
			echo form_submit($submit);			
		echo "</td>";
	echo "</tr>";
echo "</table>";
echo form_close();

echo "<script>
$(document).ready(function() {
    $('#summernote').summernote();
});
</script>";
?>