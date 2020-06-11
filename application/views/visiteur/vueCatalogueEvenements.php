<?php
echo '<br>';
echo '<div class="container-fluid">';
    echo '<h1 class="encadre">Catalogue</h1>';
echo '</div>';
echo '<div class="container-fluid">';
    echo '<h2 class="souligne"><i class="glyphicon glyphicon-euro"></i>Nos produits actuellement en vente </h2>';
    echo '<div class="row">';
        echo '<div class="col-lg-12">';
            if(!empty($lesEvenementsMarchands))
            {
                foreach($lesEvenementsMarchands as $unEvenementMarchand)
                {   
                    $NoEvenement  = $unEvenementMarchand->NoEvenement;
                    $Annee      = $unEvenementMarchand->Annee;
                    $adress     = "Visiteur/EvenementMarchand/$NoEvenement/$Annee";
                    $libEven    = $unEvenementMarchand->TxtHTMLEntete; 
                    echo '<div class="col-sm-4 col-lg-4 col-md-4">';
                        echo '<div align="center">';
                            if(!isset($unEvenementMarchand->ImgEntete))
                            {
                                echo '<a title="voir évènement" href="';
                                    echo site_url($adress);
                                    echo '"><img src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; 
                                echo '</a>';
                            }
                            else
                            {
                                echo '<a title="voir évènement" href="';
                                    echo site_url($adress);
                                    echo '"><img src="'.base_url().'assets/images/'.$unEvenementMarchand->ImgEntete.'"class="img-thumbnail" alt="Image absente." style="width: 250px; height: 200px;"/>'; 
                                echo '</a>';
                            }
                            echo '<div class="atc" align="center">';
                                echo '<button class="btn"><h4>'.anchor($adress,$libEven).'</h4></button>';
                            echo '</div>';
                            echo'</br>';
                        echo '</div>';
                    echo '</div>';
                }
            }
            else
            { 
                echo '<p>Aucune vente en cours</p>';
            }       
        echo '</div>';
    echo '</div>';
echo '</div>';
echo '<div class="container-fluid">';
    echo '<h2 class="souligne"><i class="glyphicon glyphicon-film"></i>Nos évènements scolaires</h2>';
    echo '<div class="row">';
        echo '<div class="col-lg-12">';
            if(!empty($lesEvenementsNonMarchands))
            {
                foreach($lesEvenementsNonMarchands as $unEvenementNonMarchand)
                { 
                    $NoEvenement  = $unEvenementNonMarchand->NoEvenement;
                    $Annee      = $unEvenementNonMarchand->Annee;
                    $adress     = "Visiteur/EvenementNonMarchand/$NoEvenement/$Annee";
                    $libEven    = $unEvenementNonMarchand->TxtHTMLEntete; 
                    echo '<div class="col-sm-4 col-lg-4 col-md-4">';
                        echo '<div align="center">';
                            if(!isset($unEvenementNonMarchand->ImgEntete))
                            {
                                echo '<a title="voir évènement" href="';
                                    echo site_url($adress);
                                    echo '"><img src="'.base_url().'assets/img_site/Pas_dimage_disponible.svg'.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; 
                                echo '</a>';
                            }
                            else
                            {
                                echo '<a title="voir évènement" href="';
                                    echo site_url($adress);
                                    echo '"><img src="'.base_url().'assets/images/'.$unEvenementNonMarchand->ImgEntete.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; 
                                echo '</a>';
                            }
                            echo '<div class="atc" align="center">';
                                echo '<button class="btn ">'.anchor($adress,$libEven).'</button>';
                            echo '</div>';
                            echo '</br>';
                        echo '</div>';
                    echo '</div>';
                } 
            }
            else
            { 
                echo '<p>Aucun évènement en cours</p>';
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