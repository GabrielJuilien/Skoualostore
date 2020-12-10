<html>
<?php include("head.php")?>
<link rel="stylesheet" href="css/command.css"/>
<body>
  <?php include("top.php")?>
  <div id="content">
    <p class="title">Commande confirmée</p>
    <?php
    if (!isset($_SESSION['ID_Client'])) {
      ?>
      Vous devez être connecté pour passer commande.
      <?php
      exit();
    }

    if (empty($_SESSION['cart'])) {
      ?>
      Vous devez avoir un panier pour commander.
      <?php
      exit();
    }

    $date = date("Y-m-d H:m:s");
    $req = $bdd->prepare('INSERT INTO commandes(ID_Client, Date_Commande) VALUES (?, ?)');
    $req->bindParam(1, $_SESSION['ID_Client']);
    $req->bindParam(2, $date);
    $req->execute();


    $req = $bdd->query('SELECT ID_Commande FROM commandes WHERE ID_Client="'.$_SESSION['ID_Client'].'"');
    $command = $req->fetch();

    foreach($_SESSION['cart'] as $cart_item) {
      $req = $bdd->query('INSERT INTO detailscommandes(ID_Commande, ID_Produit, Quantite) VALUES ('.$command['ID_Commande'].', '.$cart_item[0].', '.$cart_item[1].')');
    }

    $_SESSION['cart'] = array();
    ?>
    Commande confirmée. <a href="index.php" style="text-decoration: underline;">Retour à l'accueil.</a>
  </div>
</body>
</html>
