<html>
  <link rel="stylesheet" href="css/store.css"/>
  <?php include("head.php")?>
  <body>
    <?php include("top.php")?>

    <?php
    if (isset($_GET['item'])) { //Affichage de la page produit
      $req = $bdd->prepare('SELECT produits.ID_Produit, Nom_Produit, Prix_Produit, Image_Produit, Tag, Valeur_Tag, Description_Produit FROM produits LEFT JOIN notes ON notes.ID_Produit = produits.ID_Produit  LEFT JOIN clients ON clients.ID_Client = notes.ID_Client WHERE produits.ID_Produit = ?');
      $req->bindParam(1, $_GET['item']);
      $req->execute();

      if ($item = $req->fetch()) { //Si un produit correspond ?>
        <div id="content">
          <p class="title">
            <?php echo $item['Nom_Produit']; ?>
          </p>
          <table>
            <td>
          <img src="<?php echo $item['Image_Produit']; ?>" class="item-image">
        </td>
        <td>
          <div class="item-price">
            <?php
            if (isset($item['Tag']) && $item['Tag'] == "promotion") { ?>
                <div class="previous">
                  <?php echo $item['Prix_Produit']." €"; ?>
                </div>
                <div class="current">
                  <?php echo round($item['Prix_Produit'] / 100 *  (100 - $item['Valeur_Tag']), 2)." €"; ?>
                </div>
                <div class="reduction">
                  <?php echo $item['Valeur_Tag']." %"; ?>
                </div>
              <?php }
            else { ?>
                <div class="current">
                  <?php echo round($item['Prix_Produit'], 2)." €<br /><br /><br />"; ?>
                </div>
              <?php }
            ?>
          </div>
          <div id="item-description">
            <p>
              <?php echo $item['Description_Produit']; ?>
            </p>
          </div>
          <div class="quantity-selector">
            <form action="cart.php" method="get">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="item" value="<?php echo $item['ID_Produit']; ?>">
              Quantité :
              <select name="quantity">
                <?php
                for ($i = 0; $i < 10; $i++) { ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php
                }
                ?>
              </select>
              <button type="submit">Ajouter au panier</button>
            </form>
          </div>
        </td>
        </table>
        </div>
      <?php }
      else { //Sinon ?>
        <div id="content">
        </div>
      <?php }
    }
    else if (isset($_GET['categorie'])) {//Affichage de la catégorie
      if (!isset($_GET['page']) || $_GET['page'] < 1) $page = 1;
      else $page = $_GET['page'];

      $page_offset = 25 * ($page - 1);
      echo $page_offset;

      //Récupération du nom de la catégorie
      $req2 = $bdd->prepare('SELECT Nom_Categorie FROM categories WHERE ID_Categorie = ?');
      $req2->bindParam(1, $_GET['categorie']);
      $req2->execute();

      if ($categorie = $req2->fetch()) {  // Si la catégorie existe
        //Récupération des produits de la catégorie
        $req = $bdd->prepare('SELECT ID_Produit, Nom_Produit, Image_Produit, Prix_Produit, Tag, Valeur_Tag FROM produits WHERE ID_Categorie = :id_categorie LIMIT 25 OFFSET :page_offset');
        $req->bindParam(":id_categorie", $_GET['categorie'], PDO::PARAM_STR);
        $req->bindParam(":page_offset", $page_offset, PDO::PARAM_INT);
        $req->execute();

        if ($item = $req->fetch()) { ?>
          <div id="content">
            <p class="title">
              Produits dans la catégorie <?php echo $categorie['Nom_Categorie']; ?>
              <br />
            </p>
            <div class="items-container">
              <?php do { ?>
                <div class="item"><a href="store.php?item=<?php echo $item['ID_Produit']; ?>">
                <img src="<?php echo $item['Image_Produit']; ?>" class="item-image">
                    <div class="item-name">
                      <br />
                      <?php echo $item['Nom_Produit']; ?>
                    </div>
                    <div class="item-price">
                      <?php
                      if ($item['Tag'] == "promotion") {
                      ?>
                      <div class="previous">
                        <?php echo $item['Prix_Produit']." €"; ?>
                      </div>
                      <div class="current">
                        <?php echo round($item['Prix_Produit'] / 100 *  (100 - $item['Valeur_Tag']), 2)." €"; ?>
                      </div>
                      <div class="reduction">
                        <?php echo $item['Valeur_Tag']." %"; ?>
                      </div>
                      <?php
                       }
                       else { ?>
                         <div class="current">
                           <?php echo round($item['Prix_Produit'], 2)." €<br /><br /><br />"; ?>
                         </div>
                         <?php
                       }
                      ?>
                      <a href="cart.php?action=add&item=<?php echo $item['ID_Produit']; ?>"><img src="img/cart.png" class="add-to-cart"/></a>
                    </div>
                    <br />
                </a></div>
                <?php
              } while ($item = $req->fetch()); ?>
            </div>
          </div>
        <?php }
        else { //Si la catégorie est vide ?>
          <div id="content">
            <p class="title">
              Catégorie vide ... Et si vous repassiez plus tard ?
            </p>
          </div>
        <?php }
      }
      else { ?>
        <div id="content">
          <p class="title">
            Cette catégorie n'existe pas ...
          </p>
        </div>
      <?php }
    }
    else { //Affichage de la page de sélection de la catégorie
      $req = $bdd->query('SELECT ID_Categorie, Nom_Categorie FROM categories ORDER BY Nom_Categorie');
      if (!empty($req)) { ?>
        <div id="content">
            <br />
            <p class="title">
              Catégories
            </p>
            <table>
              <tr>
              <?php
              for ($i = 0; $categorie = $req->fetch(); $i++) {
                if ($i % 3 == 0 && $i != 0) {
                  ?>
                </tr><tr>
                  <?php
                }
                  ?>
                    <td><a href="store.php?categorie=<?php echo $categorie['ID_Categorie']; ?>"><?php echo $categorie['Nom_Categorie']; ?></a></td>
                  <?php
                }
              ?>
              </tr>
            </table>
        </div>
      <?php }
    }
    ?>
  </body>
  <?php include("footer.php")?>
</html>
