<html>
  <?php include("head.php")?>
  <?php
  if (isset($_GET['action']) && !strcmp($_GET['action'], "disconnect")) {
    session_destroy();
    $_SESSION = array();
  }

  ?>
  <link rel="stylesheet" href="css/index.css"/>
  <body>
    <?php include("top.php")?>
    <div id="content">
    <?php
    //Promotions
    $req = $bdd->query('SELECT ID_Produit, Nom_Produit, Prix_Produit, Image_Produit, Valeur_Tag FROM produits WHERE Tag="promotion"  ORDER BY RAND() LIMIT 5');
    if ($item = $req->fetch()) { ?>

      <div id="promos">
          <p class="title">
            Promotions
          </p>
          <div class="items-container">
          <?php
          do {
          ?><div class="item"><a href="store.php?item=<?php echo $item['ID_Produit']; ?>">
            <img src="<?php echo $item['Image_Produit']; ?>" class="item-image">
            <div class="item-name">
              <?php echo $item['Nom_Produit']; ?>
            </div>
            <div class="item-price">
              <div class="previous">
                <?php echo $item['Prix_Produit']." €"; ?>
              </div>
              <div class="current">
                <?php echo round($item['Prix_Produit'] / 100 *  (100 - $item['Valeur_Tag']), 2)." €"; ?>
              </div>
              <div class="reduction">
                <?php echo $item['Valeur_Tag']." %"; ?>
              </div>
            </div>
            <br />
          </a></div>
          <?php
          } while($item = $req->fetch());?>
        </div>
      </div>
    <?php } ?>
    <hr />
    <?php
    //New products
    $req = $bdd->query('SELECT ID_Produit, Nom_Produit, Prix_Produit, Image_Produit,Tag, Valeur_Tag FROM produits WHERE DATEDIFF(NOW(), Date_Produit) < 4 ORDER BY RAND() LIMIT 5');
    if ($item = $req->fetch()) { ?>
         <div id="new-products">
           <p class="title">
             Nouveaux produits
           </p>
           <div class="items-container">
           <?php
           do {
             ?>
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
                 </div>
                 <br />
             </a></div>
             <?php
           } while ($item = $req->fetch());
           ?>
         </div>
       </div>
    <?php } ?>

    <hr />

    <?php
    //Categories
    $req = $bdd->query('SELECT ID_Categorie, Nom_Categorie FROM categories ORDER BY Nom_Categorie');
    if (!empty($req)) { ?>
      <div id="categories">
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
    <?php } ?>
  </div>
  </body>
  <?php include("footer.php")?>
</html>
