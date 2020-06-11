<?php
/*donnée d'entrée: lesProduits array table classe 
*/
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$submit=array(
    'name'      =>'submit',
    'value'     =>'Ajouter au panier',
    'class'     =>'btn'
    
);
$qty = array(
    'min'           =>  '0',
    'step'          =>  '1',
    'type'          =>  'number', 
    'name'          =>  'qty',
    'value'         =>  '1',
    'size'          =>  '5'
);  

echo '</br>';
echo '</br>';
echo "<thead>\n";
    echo '<div class="container-fluid" align="center" width="80%">';// div 1
        echo '<tr>';
            echo '<td>';
                echo '<div align="center">';
                    echo '<h1>'.$unEvenementMarchand['TxtHTMLEntete'].'</h1>';
                echo '</div>';
            echo '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>';
                echo '<h2>'.$unEvenementMarchand['TxtHTMLCorps'].'</h2>';
            echo '</td>';
        echo '</tr>';
    echo '</div>';// fin div 1
echo "</thead>";
echo "<tbody>";

echo '<div class="col-lg-12">';
////////////////////////////// Déclaration de nos Variables ////////////////////////////

    if(isset($lesProduits))
    {
        foreach($lesProduits as $unProduit)
        {
            $leNoProduit        = $unProduit->NoProduit;
            $libelle            = $unProduit->LibelleCourt;
            $libHTML            = $unProduit->LibelleHTML;
            $prix               = $unProduit->Prix;
            $image              = $unProduit->Img_Produit;  
            $leNoEvenement      = $unProduit->NoEvenement;
            $lAnnee             = $unProduit->Annee;
            $adress             = $leNoEvenement.'X'.$lAnnee.'X'.$leNoProduit;
            $hidden=array(
                'adress'=>$adress
            );
            echo '<div class="col-sm-3 col-lg-4 col-md-3">';
                echo '<div align="center">';           
                    echo '<h3 class="encadre" align="center">' .$libelle.'</h3>';
                    echo '</br>';
                    if(empty($image))
                    {
                        echo '<img class="pull-left" width="150" src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" />';
                    }
                    else
                    {
                        echo '<img class="pull-left" width="150" src="'.base_url().'assets/images/'.$image.'"class="img-thumbnail" />';
                    } 
                    echo '<div class="caption" align="right">';
                        echo '<h3>'.$libHTML.'</h3>';
                        echo '</br>';
                        echo '<h4>'.number_format($prix,2, ',',' ').'€</h4>';
                        echo '</br>';
    ///////////////////////////////   FORMULAIRE   //////////////////////////////////////// 
                        echo form_open('Visiteur/ajoutPanier');
                        echo form_hidden($hidden);
                        echo '<div align="center">';
                            echo form_input($qty);
                        echo '</div>';
                        echo '</br>';
                        echo '<div align="center">';
                            echo form_submit($submit);
                        echo '</div>';
                        echo form_close();
    //////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    } 
echo '</div>';
echo '</tbody>';
echo "<tfoot\n";
    echo '<div class="container">';
        echo '<tr>';
            echo '<td>';
                echo '<h2 align="center">'.$unEvenementMarchand['TxtHTMLPiedDePage'].'</h2>';
            echo '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>';
                echo '<h2 align="center">Cet évènement se termine le '.$unEvenementMarchand['DateMiseHorsLigne'].'</h2>';
            echo '</td>';
        echo '</tr>'; 
    echo '</div>';
echo '</tfoot\n'; 
echo form_close();
echo '</br>';
echo '<div align="center">';
    echo '<a href="';
        echo site_url('Visiteur/catalogueEvenement');
        echo '"><button class="btn">Retour au catalogue</button>';
    echo '</a>';
    echo '&emsp;';
    echo '<a href="';
        echo site_url('Visiteur/panier');
        echo '"><button class="btn">Voir le panier</button>';
    echo '</a>';
echo '</div>';
echo '</br>';
echo '</br>';
echo form_close();
?>
