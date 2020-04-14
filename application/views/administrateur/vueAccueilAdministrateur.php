<!DOCTYPE html">
<html lang="fr">
  <head>
    <meta charset="utf-8" />
  </head>
  
  <body>
  <div id="conteneur">    
    <h1 id="header"><a title="Colored Design - Accueil"><span>Bienvenu sur l'accueil administrateur</h1></span></a></h1>

    <nav>
      <div id="menu">
          <ul>
        <li><a href="<?php echo site_url('administrateur/ajouterEvenement')?>">Ajouter un Evenement</a></li>
        <li><a href="<?php echo site_url('administrateur/modifierEvenement')?>">Modifier un Evenement</a></li>
        <li><a href="<?php echo site_url('administrateur/ajouterProduit')?>">Ajouter un Produit</a></li>
        <li><a href="<?php echo site_url('administrateur/modifierProduit')?>">Modifier un Produit</a></li>
      </ul>
</div>
    </nav>
    
    <div id="contenu">
      <h2>Comment fonctionne notre site</h2>
      <p>Tout d'abord une rapide présentation :
          sur le menu de gauche vous pouvez voir les possiblités que vous offre le site en tant qu'administrateur
          
      </p>
    </div>
    
    
  </div>
  </body>
</html>
