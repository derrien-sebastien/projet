
<h1 id="encadre">Catalogue de nos évènements scolaires</h1>

<div class="container">
    <h2 id="souligne"><i class="glyphicon glyphicon-euro"></i> Nos produits en ventes </h2>
    <div class="row">
        <div class="col-lg-12">
            <?php if(!empty($lesEvenementsMarchands))
                {
                    foreach($lesEvenementsMarchands as $unEvenementMarchand)
                    {   
                        $NoEvenement  = $unEvenementMarchand->NoEvenement;
                        $Annee      = $unEvenementMarchand->Annee;
                        $adress     = "visiteur/EvenementMarchand/$NoEvenement/$Annee";
                        $libEven    = $unEvenementMarchand->TxtHTMLEntete ?>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <?php echo '<img src="'.base_url().'assets/images/'.$unEvenementMarchand->ImgEntete.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; ?>
                                <div class="atc" align="center"><!--  div  7 -->
                                    <?php echo '<h3><i class="glyphicon glyphicon-search:before"></i>'.anchor($adress,$libEven,array('class'=>'btn-primary')).'</h3>';?>
                                </div>
                            </div>
                        </div>
            <?php   }
                }
                else
                { ?>
                    <p>Aucune vente en cours</p>
        <?php   } ?>      
        </div>
    </div>
</div>
<div class="container">
    <h2 id="souligne"><i class="glyphicon glyphicon-film"></i> Nos évènements scolaires</h2>
    <div class="row">
        <div class="col-lg-12">
            <?php if(!empty($lesEvenementsNonMarchands))
            {foreach($lesEvenementsNonMarchands as $unEvenementNonMarchand)
                { ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <?php echo '<img src="'.base_url().'assets/images/'.$unEvenementNonMarchand->ImgEntete.'"class="img-thumbnail" style="width: 250px; height: 200px;"/>'; ?>
                            <div class="atc" align="center"><!--  div  7 -->
                                <?php echo '<h3><i class="glyphicon glyphicon-search:before"></i>'.anchor('visiteur/EvenementMArchand/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,$unEvenementNonMarchand->TxtHTMLEntete,array('class'=>'btn-primary')).'</h3>';?>
                            </div>
                        </div>
                    </div>
            <?php } }else{ ?>
                <p>Aucun évènement marchand en cours</p>
            <?php } ?>      
        </div>
    </div>
</div>
