<div align=center>
    <h2>Connexion réussie !</h2>
</div>
    <div class="container">
        <h2 align='center' class='textBlanc'>Nos Evenements Marchands </h2>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="item">
                    <?php 
                        foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                            echo "<font color=black size=7><center>$unEvenementMarchand->TxtHTMLEntete</center></font>";
                        endforeach;
                    ?>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        </br>
        </br>
        <div class="container">
            <h2 align='center' class='textBlanc'>Nos Evenements Non Marchands</h2>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
            </br>
            </br>
            <div > 
               <?php
                    foreach ($lesEvenementsNonMarchands as $unEvenementNonMarchand):
                        echo "<font color=black size=7><center>$unEvenementNonMarchand->TxtHTMLEntete</center></font>";
                    endforeach;  
               ?>
            </div>
            <a class="left carousel-control" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" data-slide="next">
               <span class="glyphicon glyphicon-chevron-right"></span>
               <span class="sr-only">Next</span>
            </a>
        </div>     
    </div>
</br>
</br>
<p align='center'>Afin d'afficher plus de détails sur un évènement, cliquer sur son titre</p>
</br>
</br>