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
                            
                            $hidden=array(
                                $i.'rowid'=>$produit['rowid'],
                                'produit[]'=>$produit['rowid']
                            );
                            
                            $qty=array(
                                'name'  =>$i.'qty',
                                'value' =>$produit['qty'],
                                'type'  =>'number'
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
                                echo '<td style="color:rgb(128, 122, 122);"align="center">Supprimer';
                                    echo '<a href="';
                                        echo site_url('Visiteur/removeItem/'.$produit['rowid'].'/'. $produit['id']);
                                        echo '" ><i class="glyphicon glyphicon-trash"></i>';
                                    echo '</a>';
                                echo '</td>';
                            echo '</tr>';
                            $totale=$totale+$produit['subtotal'];
                        } 
                        echo '<tr>';
                            echo '<td colspan="3"  align="center" style="color:rgb(128, 122, 122);">';
                                echo 'Montant total :';
                            echo '</td>';
                            echo '<td colspan="6" align="right"  style="color:rgb(128, 122, 122);">';
                                echo $totale;
                            echo '</td>';
                        echo '</tr>'; 
                        echo '</tbody>';
                        echo '</table>';
                        $hidden2['noEvenement']=$unEvenementMarchand['NoEvenement'];
                        $hidden2['annee']=$unEvenementMarchand['Annee'];
                        echo '<div align="center">';
                            echo '<button name="passerCommande" class="btn btn-primary">PASSER COMMANDE</button>';
                            echo " \n ";
                            echo '<button name="submit"class="btn btn-primary">METTRE A JOUR LE PANIER</button>';
                            echo " \n ";
                            echo '<button name="viderPanier"class="btn btn-primary">VIDER LE PANIER</button>';
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
                        echo '<button class="btn btn-primary">Retour au catalogue</button>';
                        echo '</div>';
                    }                     
            
        echo '</div>';
    echo '</div>'; 
echo '</div>';


?>
<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->

