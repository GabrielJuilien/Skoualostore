<div id="top">
  <img src="img/banner.png" class="banner-img"/>
  <a href="cart.php" ><img src="img/cart.png" style="right: 0; position: fixed; width: 6.25%;"></a>
  <nav>
    <ul>
      <li class="menu-static">
        <a href="index.php">Accueil</a>
      </li>
      <li class="menu-folding">
        <a href="store.php">Produits</a>
        <ul class="menu-fold">
          <?php
          $req = $bdd->query('SELECT ID_Categorie, Nom_Categorie FROM categories ORDER BY Nom_Categorie ASC');
          while ($categorie = $req->fetch()) {
            ?>
            <li><a href="store.php?categorie=<?php echo $categorie['ID_Categorie']; ?>"><?php echo $categorie['Nom_Categorie']; ?></a></li>
            <?php
          }
          ?>
        </ul>
      </li>
      <?php
      if (isset($_SESSION['ID_Client'])) { ?>
        <li class="menu-static">
          <a href="profile.php">Profil</a>
        </li>
        <li class="menu-static">
          <a href="index.php?action=disconnect">Déconnexion</a>
        </li>
        <?php }
        else { ?>
        <li class="menu-static">
          <a href="login.php">Connexion</a>
        </li>
      <?php } ?>
    </ul>
  </nav>
</div>
