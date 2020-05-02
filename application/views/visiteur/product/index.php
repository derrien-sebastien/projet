            <div class="container"><!--  div 1   -->
                <h2 align="center">Les Produits</h2>
                <a href="<?php echo base_url('index.php/cart'); ?>" class="cart-link" title="View Cart">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                    <span><?php echo $this->cart->total_items(); ?></span>
                </a>
                <div class="row"><!--  div 2   -->
                    <div class="col-lg-12"><!--  div 3  -->
                        <?php if(empty($products))
                            {foreach($product as $row) 
                                { ?>
                                    <div class="col-sm-4 col-lg-4 col-md-4"><!--  div 4   -->
                                        <div class="thumbnail"><!--  div 5  -->
                                        <?php echo '<img src="'.base_url().'assets/images/'.$row['Img_Produit'].'"
								                class="img-thumbnail" />'; ?>
                                            <div class="caption"><!--  div 6  -->
                                                <h4 class="pull-right">$<?php echo $row['Prix']; ?></h4>
                                                <h4><?php echo $row['LibelleCourt']; ?></h4>
                                                <p><?php echo $row['LibelleHTML']; ?></p>
                                            </div><!--  /div   6-->
                                            <div class="atc"><!--  div  7 -->
                                                <a href="<?php echo base_url('index.php/Products/addToCart/'.$row['NoProduit']); ?>" class="btnSubmit">Ajouter au panier</a>
                                            </div><!--  /div  7 -->
                                        </div><!--  /div 5   -->
                                    </div><!--  /div 4  -->
                        <?php } }else{ ?>
                        <p>Produit(s) non trouvé(s)...</p>
                        <?php } ?>      
                    </div><!--  /div 3  -->
                </div><!--  /div 2  -->
            </div><!--  /div 1   -->
