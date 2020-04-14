<div class="container">
     <h2 align='center' class='textBlanc'>Nos Evenements Marchands </h2>
     <div id="myCarousel" class="carousel slide" data-ride="carousel">
          
               <?php 
               echo '<ol>';
               for ($i=0;$i<count($lesEvenementsMarchands);$i++) 
                    {
                         echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" class="';
                         if ($i==0)
                         {
                             echo 'active';
                         }
                         echo '"></li>';
                    }
                    echo '</ol>';
                    
                    $i=0;
                    echo '<div class="carousel-inner">';
                    foreach ($lesEvenementsMarchands as $unEvenementMarchand):
                         echo '<div class="item"';
                         if ($i==0)
                         {
                              echo 'active';
                         }
                         echo'>';
                         echo anchor('visiteur/lesProduitsEvenement/'.$unEvenementMarchand->NoEvenement.'/'.$unEvenementMarchand->Annee,"<font color=black size=7><center>".$unEvenementMarchand->TxtHTMLEntete.'</center></font>');
                         echo  '</div>';
                         $i++;
                    endforeach;
                    echo '</div>';
                    
               ?>
         
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
                         echo '<p>'.anchor('visiteur/voirUnEvenement/'.$unEvenementNonMarchand->NoEvenement.'/'.$unEvenementNonMarchand->Annee,"<font color=black size=7><center>".$unEvenementNonMarchand->TxtHTMLEntete."</center></font>").'</p>';
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