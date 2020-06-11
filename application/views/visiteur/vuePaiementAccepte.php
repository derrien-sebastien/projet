<?php
echo '<div class="container-fluid">';
    echo '<div align="center">';
    echo '<br>';
    echo '<br>';
        echo '<h2>Votre transaction a été acceptée</h2>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<h1>Nous vous remercions de votre confiance.</h1>';
        echo '<br>';
        echo '<div align="center">';
            echo '<a href="';
                echo site_url('Visiteur/catalogueEvenement');
                echo '"><button class="btn">Retour au catalogue</button>';
                echo '&emsp;';
                echo '<a href="';
                echo site_url('Membre/mesCommandes');
                echo '"><button class="btn">Voir vos commandes</button>';
            echo '</a>';
            echo '</a>';
        echo '</div>';
    echo '</div>';
echo '</div>';
?>