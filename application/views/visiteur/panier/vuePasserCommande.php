<?php echo form_open('visiteur/ajouterProduitAuPanier'); 
$i=1;

foreach 
($LesProduits as $UnProduit):

?>

<label name=<?php echo $UnProduit->LibelleCourt ?>><?php echo $UnProduit->LibelleCourt ?></label>
<?php echo '<p>'.img($UnProduit->Img_Produit).'<p>';?>
<?php echo $UnProduit->Prix;?>
</br>
<input type='number' name='<?php echo $i ?>' value='0'>
</br>
</br>
<?php $i++; ?>
<?php endforeach; ?>
<input type='submit' name='envoyer' value='Passer Commande'

