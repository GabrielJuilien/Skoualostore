<html>
<?php include("head.php")?>
<link rel="stylesheet" href="css/command.css"/>
<body>
  <?php include("top.php")?>
  <div id="content">
    <p class="title">Récapitualtif commande</p>
    <?php if (!isset($_SESSION['ID_Client'])) {
      ?>
      Vous devez vous <a href="login.php" style="text-decoration: underline;">connecter</a> pour passer commande.
      <?php
      exit();
    }
    ?>
    Produits : <br /> <br />
    <table>
      <?php
      $total_price = 0;
      foreach ($_SESSION['cart'] as $cart_item) {
        $req = $bdd->prepare('SELECT * FROM produits WHERE ID_Produit = ?');
        $req->bindParam(1, $cart_item[0]);
        $req->execute();
        $item = $req->fetch();
        ?>
        <tr>
          <td>
            <div class="item-name">
              <?php echo $item['Nom_Produit']; ?>
            </div>
          </td>
          <td>
            <div class="item-price">
              <?php
              if ($item['Tag'] == "promotion") {
                ?>
                  <?php $item_price = round($item['Prix_Produit'] / 100 *  (100 - $item['Valeur_Tag']), 2); ?>
                <?php
              }
              else { ?>
                  <?php $item_price =  round($item['Prix_Produit'], 2); ?>
                <?php
              }
              echo $item_price." €";
              ?>
            </div>
          </td>
          <td>
            x <?php echo $cart_item[1]; ?>
          </td>
          <td>
            <?php echo $cart_item[1] * $item_price . " €";
            $total_price += $cart_item[1] * $item_price;
            ?>
          </td>
        </tr>
        <?php
      }
      ?>
      <tr><td>Total</td><td></td><td></td><td> <?php echo $total_price. " €"; ?></td></tr>
    </table>
    <?php $req = $bdd->query('SELECT * FROM clients WHERE ID_Client="'.$_SESSION['ID_Client'].'"');
    $user = $req->fetch();
    ?><br />
    Adresse de livraison :<br /><br />
    M / Mme <?php echo $user['Nom_Client']." ".$user['Prenom_Client']; ?><br />
    <?php echo $user['Adresse_Client']; ?><br />
    <?php echo $user['CP_Client']." ".$user['Ville_Client']; ?><br /><br />
    <a href="save_command.php"><button>Commander</button></a><br /><br />
  </div>
</body>
</html>
