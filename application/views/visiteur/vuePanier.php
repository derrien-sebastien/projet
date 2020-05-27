<?php
$totale=0;

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
                /* echo form_open('Visiteur/majPanier'); */
                    if($this->cart->total_items() > 0)
                    {
                        /* $i=0 */
                        foreach($this->cart->contents() as $produit)
                        { 
                            
                            /* $hidden=array(
                                $i.'rowid'
                            ); */
                            echo '<tr>';
                                echo '<td align="center">';
                                    echo '<img src="'.base_url().'assets/images/'.$produit["image"].'"class="img-thumbnail" width="75"/>';
                                echo '</td>';
                                echo '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["name"].'</td>';
                                echo '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["price"].'€</td>';       
                                echo '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["qty"].'</td>';
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
                    }
                    else
                    { 
                        echo '<tr>';
                            echo '<td colspan="6" style="color:rgb(128, 122, 122);"align="center"><p> Aucun Produit</p></td>';
                        echo '</tr>';
                    }                      
                echo '</tbody>';
            echo '</table>';
            if($this->cart->total_items() > 0)
            {
                echo '<div align="center">';
                    echo '<a href="';
                        echo site_url('Visiteur/passerCommande');
                        echo '"><button class="btn btn-primary">PASSER COMMANDE</button>';
                    echo '</a>';
                    echo " \n ";
                    echo '<a href="';
                        echo site_url('Visiteur/viderPanier/'.$unEvenementMarchand['NoEvenement'].'/'.$unEvenementMarchand['Annee']);               
                    echo '"><button class="btn btn-primary">VIDER LE PANIER</button>';
                    echo '</a>';
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

