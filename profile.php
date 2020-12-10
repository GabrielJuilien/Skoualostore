<html>
<?php include("head.php")?>
<link rel="stylesheet" href="css/profile.css"/>
<body>
  <?php include("top.php")?>
  <div id="content">
    <p class="title">Profil utilisateur</p>
    <?php
    if (!isset($_SESSION['ID_Client'])) { ?>
      <p>Vous devez être connecté pour consulter votre profil. <a href="login.php" style="text-decoration: underline;">Connexion</a></p>
      <?php
    }
    else {
      $req = $bdd->prepare('SELECT * FROM clients WHERE ID_Client = ?');
      $req->bindParam(1, $_SESSION['ID_Client']);
      $req->execute();
      if (empty($req)) {
        ?>
        <p>Il semblerait qu'il y ai eu une erreur avec votre profil. <a href="index.php?action=disconnect">Déconnexion</a></p>
        <?php
      }
      else {
        $user = $req->fetch();
        ?>
        <table>
          <tr>
            <td class="label">
              Nom d'utilisateur
            </td>
            <td>
              <?php echo $user['Login_Client']; ?>
            </td>
          </tr>
          <tr>
            <td class="label">
              Nom - Prénom
            </td>
            <td>
              <?php echo $user['Nom_Client']." - ".$user['Prenom_Client']; ?>
            </td>
          </tr>
          <tr>
            <td class="label">
              Date de naissance
            </td>
            <td>
              <?php echo $user['DDN_Client']; ?>
            </td>
          </tr>
          <tr>
            <td class="label">
              Adresse
            </td>
            <td>
              <?php echo $user['Adresse_Client']."\n".$user['CP_Client']." ".$user['Ville_Client']; ?>
            </td>
          </tr>
        </table>
        <p class="title">Commandes passées</p>
        <table>
          <?php
          $req = $bdd->query('SELECT * FROM commandes LEFT JOIN detailscommandes ON detailscommandes.ID_Commande = commandes.ID_Commande');
          while($req->fetch()) {
            ?>
            <tr>
              <td>N° de commande : <?php echo $req['ID_Commande']; ?></td>
              <td>Date : <?php echo $req['Date_Commande']; ?></td>
            </tr>
            <?php
          }
          ?>

        </table>
        <?php
      }
    }
    ?>
  </div>
</body>
</html>
