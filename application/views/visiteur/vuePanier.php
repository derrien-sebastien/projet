<?php
$totale=0;

$hidden2=array(
    'arriver'       => 'vuePanier'
);

echo '<br>';
echo '<div class="container-fluid">';
    echo '<div class="row">';
        echo '<div class="col-lg-12" >';
            echo '<h1 class="encadre">Votre Panier</h1>';
            echo '<br>';
            echo '<table class="table table-dark">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<td align="center">Produit</td>';
                        echo '<td align="center">Libellé </td>';
                        echo '<td align="center">Prix </td>';
                        echo '<td align="center">Quantité</td>';
                        echo '<td align="center">Votre Total</td>';
                        echo '<td align="center">Vos Actions</td>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody class="table table-dark">';
                    if($this->cart->total_items() > 0)
                    {
                        echo form_open('Visiteur/retourPanier');
                        $i=0;
                        foreach($this->cart->contents() as $produit)
                        {
                            if(!isset($noEvenement))
                            {
                                    $noEvenement=$produit['noEvenement'];
                                    $annee=$produit['annee'];
                            }
                            
                            $hidden=array(
                                $i.'rowid'  =>$produit['rowid'],
                                'produit[]' =>$produit['rowid']
                            );
                            
                            $qty=array(
                                'min'       =>  '0',
                                'step'      =>  '1',
                                'name'      =>  $i.'qty',
                                'value'     =>  $produit['qty'],
                                'type'      =>  'number',
                                'size'      =>  '5' 
                            );
                            $i++;
                            echo form_hidden($hidden);
                            echo '<tr>';
                            if(!isset($produit['image']))
                            {
                                echo '<td align="center">';
                                    echo '<img src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" width="75"/>'; 
                                echo '</td>';
                            }
                            else
                            {
                                echo '<td align="center">';
                                    echo '<img src="'.base_url().'assets/images/'.$produit["image"].'"class="img-thumbnail" width="75"/>';
                                echo '</td>';
                            }
                                echo '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["name"].'</td>';
                                echo '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["price"].'€</td>';       
                                echo '<td style="color:rgb(128, 122, 122);" align="center">';
                                echo form_input($qty);
                                echo '</td>';
                                echo '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["subtotal"].'€</td>';
                                echo '<td style="color:rgb(128, 122, 122);"align="center">';
                                    echo '<a href="';
                                        echo site_url('Visiteur/enleverDuPanier/'.$produit['rowid'].'/'. $produit['id']);
                                        echo '" >Supprimer<i class="glyphicon glyphicon-trash"></i>';
                                    echo '</a>';
                                echo '</td>';
                            echo '</tr>';
                            $totale=$totale+$produit['subtotal'];
                        } 
                        echo '<tr>';
                            echo '<td colspan="6" style="color:rgb(128, 122, 122);">';
                                echo '<h4 colspan="5" align="right">Montant total :';
                                echo $totale.'</h4>';
                            echo '</td>';
                        echo '</tr>'; 
                        echo '</tbody>';
                        echo '</table>';
                        $hidden2['noEvenement']=$noEvenement;
                        $hidden2['annee']=$annee;
                        echo '<div align="center">';
                            echo '<button name="passerCommande" class="btn">PASSER COMMANDE</button>';
                            echo " \n ";
                            echo '<button name="submit"class="btn">METTRE A JOUR LE PANIER</button>';
                            echo " \n ";
                            echo '<button name="viderPanier"class="btn">VIDER LE PANIER</button>';
                        echo '</div>';
                        echo '</br>';
                        echo '</br>';
                        echo '<div align="center">';
                            echo '<button name="retourCatalogue" class="btn">RETOUR AU CATALOGUE</button>';
                            echo '&emsp;';
                            echo '<button name="retourEven"class="btn">RETOUR AUX PRODUITS</button>';
                            echo '</a>';
                        echo '</div>';
                        echo form_hidden($hidden2);
                        echo form_close();
                    }
                    else
                    { 
                        echo '<tr>';
                            echo '<td colspan="6" style="color:rgb(128, 122, 122);"align="center"><p> Aucun Produit</p></td>';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                        echo '<div align="center">';
                        echo '<a href="';
                            echo site_url('Visiteur/catalogueEvenement');
                            echo '"><button class="btn">Retour au catalogue</button>';
                        echo '</a>';
                        echo '</div>';
                    }                     
            
        echo '</div>';
    echo '</div>'; 
echo '</div>';
?>
</br>
</br>
</br>
</br>
</br>
</br>





