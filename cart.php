<html>
<link rel="stylesheet" href="css/cart.css"/>
<?php include("head.php")?>
<?php
if (isset($_GET['action'])) {
  if ($_GET['action'] == "add" && isset($_GET['item'])) {
    $req = $bdd->prepare('SELECT ID_Produit FROM produits WHERE ID_Produit = ?');
    $req->bindParam(1, $_GET['item'], PDO::PARAM_INT);
    $req->execute();
    if (!empty($req)) {
      $item = $req->fetch();

      if (isset($_GET['quantity']) && $_GET['quantity'] > 0)
      $cart_item = array($item['ID_Produit'], $_GET['quantity']);
      else
      $cart_item = array($item['ID_Produit'], 1);

      if(!isset($_SESSION['cart']))
      $_SESSION['cart'] = array($cart_item);
      else {
        for($i = 0; $i < count($_SESSION['cart']); $i++) { //Trying to find an entry with same ID
          if ($_SESSION['cart'][$i][0] == $cart_item[0]) { //If a similar entry is found, update quantity
            $_SESSION['cart'][$i][1] += $cart_item[1];
            $cart_item = NULL;
          }
        }

        if ($cart_item != NULL) //If no similar entry was found
        array_push($_SESSION['cart'], $cart_item);
      }
    }
  }
  else if ($_GET['action'] == "set" && isset($_GET['quantity']) && isset($_GET['item'])) {
    if ($_GET['quantity'] > 0) {
      for($i = 0; $i < count($_SESSION['cart']); $i++) { //Trying to find an entry with same ID
        if ($_SESSION['cart'][$i][0] == $_GET['item']) { //If a similar entry is found, update quantity
          $_SESSION['cart'][$i][1] = $_GET['quantity'];
        }
      }
    }
    else {
      for($i = 0; $i < count($_SESSION['cart']); $i++) { //Trying to find an entry with same ID
        if ($_SESSION['cart'][$i][0] == $_GET['item']) { //If a similar entry is found, update quantity
          array_splice($_SESSION['cart'], $i, 1);
        }
      }
    }
  }
}
?>
<body>
  <?php include("top.php")?>
  <div id="content">
    <p class="title">
      Panier
    </p>
    <?php
    if (isset($_SESSION['cart'])) {
      $total_price = 0;
      ?>
      <table>
        <?php
        foreach ($_SESSION['cart'] as $cart_item) {
          $req = $bdd->prepare('SELECT * FROM produits WHERE ID_Produit = ?');
          $req->bindParam(1, $cart_item[0]);
          $req->execute();
          $item = $req->fetch();
          if ($item['Tag'] == "promotion") $total_price += $item['Prix_Produit'] * $cart_item[1] * ( 1 - $item['Valeur_Tag'] / 100);
          else $total_price += $item['Prix_Produit'] * $cart_item[1];
          ?>
          <tr>

            <td>
              <a href="store.php?item=<?php echo $item['ID_Produit']; ?>"><img src="<?php echo $item['Image_Produit']; ?>" class="item-image"></a>
            </td>
            <td>
              <div class="item-name">
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
            </td>
            <td>
              <div class="quantity-selector">
                <form action="cart.php" method="get">
                  <input type="hidden" name="action" value="set">
                  <input type="hidden" name="item" value="<?php echo $item['ID_Produit']; ?>">
                  Quantité :
                  <select name="quantity">
                    <?php
                    for ($i = 0; $i < 10; $i++) { ?>
                      <option value="<?php echo $i; ?>" <?php if($cart_item[1] == $i) echo "selected=\"selected\""; ?>><?php echo $i; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <button type="submit">Modifier</button>
                </form>
              </div>
            </td>
          </tr>
        <?php }
        ?>
        <tr>
          <td>
            <p class="title"> Prix total : </p>
          </td>
          <td>
            <?php echo round($total_price, 2)." €"; ?>
          </td>
          <td>
            <?php if (isset($_SESSION['ID_Client'])) { ?>
              <a href="command.php"><button>Commander</button></a>
              <?php
            }
            else {
              ?>
              <a href="login.php"><button>Commander</button></a>
              <?php
            }
            ?>
          </td>
        </table>
        <?php
      }
      else { ?>
        Votre panier est bien vide ! Souhaitez vous le remplir avec ...
        <?php
        $req = $bdd->query('SELECT * FROM categories ORDER BY RAND() LIMIT 1');
        $categorie = $req->fetch();
        ?>
        des <a style="text-decoration: underline;" href="store.php?categorie=<?php echo $categorie["ID_Categorie"]; ?>"><?php echo $categorie['Nom_Categorie']; ?></a> ?
      <?php } ?>
    </div>
  </body>
  <?php include("footer.php")?>
  </html>
