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
	if(isset($produit))
	{
		$hidden['noEvenement']=$produit->NoEvenement;
		$hidden['annee']=$produit->Annee;
		$hidden['noProduit']=$produit->NoProduit;
		$hidden['img_Produit']=$produit->Img_Produit;
		$hidden['imgTicket']=$produit->ImgTicket;
	}
}
elseif($provenance=='modifierEvenement'||$provenance=='ajouterEvenement')
{
	$hidden['noEvenement']=$NoEvenement;
	$hidden['annee']=$Annee;
}
$annee=array(
	'name'=>'annee',
	'type'=>'number',
	'value'=>'2020'
);

if(isset($evenement))
{
	
	foreach ($evenement as $unEvenement)
	{
		$noEvenement[$unEvenement->NoEvenement]=$unEvenement->TxtHTMLEntete;
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
	'name'=>'prix',
	'min'=>'1'
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
	'name'=>'stock',
	'min'=>'1'
);
if (isset($produit->Stock))
{
	$stock['value']=$produit->Stock;
}
$numeroOrdreApparition=array(
	'type'=>'number',
	'placeholder'=>'1.0',
	'step'=>'1',
	'name'=>'numeroOrdreApparition',
	'min'=>'0'
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
	'value'=>'1',
	'max'=>'1',
	'min'=>'0'
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
echo "<h1>Inserez un nouveau Produit</h1>";
echo form_open_multipart('Administrateur/formulaireProduit');
echo form_hidden($hidden);
echo "<table>";
if ($provenance=='ajouter')
{
	echo "<tr>";
		echo "<td>";
			echo form_label("Année de l'evenement", 'annee');
		echo "</td>";
		echo "<td>";
			echo form_input($annee);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('Selectionnez un evenement ', 'noEvenment');
		echo "</td>";
		echo "<td>";
			echo form_dropdown('noEvenement',$noEvenement);
		echo "</td>";
	echo "</tr>";	
}
	echo "<tr>";
		echo "<td>";
			echo form_label('Description du produit: ', 'libelleHTML');
		echo "</td>";
		echo "<td>";
			echo form_textarea($libelleHtml);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('Intitulé du produit: ','libelleCourt');
		echo "</td>";
		echo "<td>";
			echo form_textarea($libelleCourt);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('Prix: ','prix');
		echo "</td>";
		echo "<td>";
			echo form_input($prix);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('image du produit: ','img_Produit');
		echo "</td>";
		echo "<td>";
			echo form_input($img_Produit);
			if(isset($produit->Img_Produit))
			{
				if($produit->Img_Produit!='')
				{
					echo 'Image actuellement choisie : ';
					echo'<img class="pull-left" width="150" src="'.base_url().'assets/images/'.$produit->Img_Produit.'"class="img-thumbnail" />';
				}
			}
			echo "</td>";	
			echo "<td>";
				echo form_checkbox($supImgProduit);
				echo " Supprimer l'image ";
			echo "</td>";
		echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('Taille du stock: ','stock');
		echo "</td>";
		echo "<td>";
			echo form_input($stock);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label("Numero d'ordre d'aparition: ",'numeroOrdreApparition');
		echo "</td>";
		echo "<td>";
			echo form_input($numeroOrdreApparition);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('Edition de ticket neccesaire 0)non 1)oui: ','etreTicket');
		echo "</td>";
		echo "<td>";
			echo form_input($etreTicket);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo form_label('Image  du ticket : ','ImgTicket');
		echo "</td>";
		echo "<td>";
			echo form_input($imgTicket);
		echo "</td>";
	echo "</tr>";
	if (isset($produit->ImgTicket))
	{
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
	echo "<tr>";
		echo"<td>";
			echo form_label('souhaitez vous inserer un autre produit ?','autre');
		echo "</td>";
		echo "<td>";
			echo form_checkbox($autre);
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo"<td>";
			echo form_submit($submit);			
		echo "</td>";
	echo "</tr>";
echo "</table>";
echo form_close();
?>

<script>
$(document).ready(function()
    {
        $('#summernote').summernote({ lang: 'fr-FR' });
    });

</script>