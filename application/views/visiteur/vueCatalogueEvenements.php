<?php
echo '<br>';
echo '<div class="container">';
echo    '<h1 class="encadre">Catalogue des évènements scolaires</h1>';
echo '</div>';
echo '<div class="container">';
echo    '<h2 class="souligne"><i class="glyphicon glyphicon-euro"></i>Nos produits actuellement en vente </h2>';
echo        '<div class="row">';
echo        '<div class="col-lg-12">';
        if(!empty($lesEvenementsMarchands))
        {
            foreach($lesEvenementsMarchands as $unEvenementMarchand)
            {   
                $NoEvenement  = $unEvenementMarchand->NoEvenement;
                $Annee      = $unEvenementMarchand->Annee;
                $adress     = "visiteur/EvenementMarchand/$NoEvenement/$Annee";
                $libEven    = $unEvenementMarchand->TxtHTMLEntete; 
echo            '<div class="col-sm-4 col-lg-4 col-md-4">';
echo                '<div class="thumbnail">';
echo                    '<a href="';
echo                        site_url($adress);
echo                        '"><img src="'.base_url().'assets/images/'.$unEvenementMarchand->ImgEntete.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; 
echo                    '</a>';
echo                    '<div class="atc" align="center">';
echo                        '<button class="btn btn-primary">'.anchor($adress,$libEven,array('class'=>'btn-primary')).'</button>';
echo                    '</div>';
echo                '</div>';
echo            '</div>';
            }
        }
        else
        { 
echo        '<p>Aucune vente en cours</p>';
        }       
echo    '</div>';
echo        '</div>';
echo            '</div>';
echo                '<div class="container">';
echo                    '<h2 class="souligne"><i class="glyphicon glyphicon-film"></i>Nos évènements scolaires</h2>';
echo                    '<div class="row">';
echo                        ' <div class="col-lg-12">';
                                if(!empty($lesEvenementsNonMarchands))
                                {
                                    foreach($lesEvenementsNonMarchands as $unEvenementNonMarchand)
                                    { 
echo                                    '<div class="col-sm-4 col-lg-4 col-md-4">';
echo                                        '<div class="thumbnail">';
echo                                            '<img src="'.base_url().'assets/images/'.$unEvenementNonMarchand->ImgEntete.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; 
echo                                            '<div class="atc" align="center">';
echo                                                '<h3><i class="glyphicon glyphicon-search:before"></i>'.anchor('visiteur/EvenementMArchand/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,$unEvenementNonMarchand->TxtHTMLEntete,array('class'=>'btn-primary')).'</h3>';
echo                                            '</div>';
echo                                        '</div>';
echo                                    '</div>';
                                    } 
                                }
                                else
                                { 
echo                                '<p>Aucun évènement en cours</p>';
                                }       
echo                        '</div>';
echo                    '</div>';
echo                '</div>';
?>