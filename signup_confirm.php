<?php
function genererChaineAleatoire($longueur) {
  $chaine = '';
  $listeCar = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYV';
  $max = strlen($listeCar);
  for ($i = 0; $i < $longueur; ++$i) {
    $chaine .= $listeCar[random_int(0, $max - 1)];
  }
  return $chaine;
}
?>
<html>
  <?php include("head.php")?>
  <link rel="stylesheet" href="css/signup.css"/>
  <body>
    <?php include("top.php")?>
    <div id="content">
      <?php
      if (empty($_POST['Nom_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de nom ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['Prenom_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de prénom ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['Adresse_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ d'adresse ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['CP_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de code postal ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['Ville_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de ville ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['DDN_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de date de naissance ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['Login_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ d'identifiant ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['MDP_Client'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de mot de passe ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (empty($_POST['MDP_Client_Confirmation'])) {
        ?>
        <p style="padding: 140px 0;">Le champ de confirmation du mot de passe ne peut être laissé vide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }

      if (!preg_match("#[A-Za-z -]{2,}#", $_POST['Nom_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ de nom invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (!preg_match("#[A-Za-z -]{2,}#", $_POST['Prenom_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ de prenom invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (!preg_match("#[A-Za-z -]{2,}#", $_POST['Adresse_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ d'adresse invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (!preg_match("#[0-9]{5}#", $_POST['CP_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ de code postal invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (!preg_match("#[A-Za-z -]{2,}#", $_POST['Adresse_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ d'adresse client invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (!preg_match("#[A-Za-z -]{2,}#", $_POST['Login_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ d'identifiant invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (!preg_match("#[A-Za-z!?.;-_]{5,32}#", $_POST['MDP_Client'])) {
        ?>
        <p style="padding: 140px 0;">Valeur du champ de mot de passe invalide.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }
      if (strcmp($_POST['MDP_Client'], $_POST['MDP_Client_Confirmation'])) {
        ?>
        <p style="padding: 140px 0;">Les mots de passe ne correspondent pas.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }

      $req = $bdd->prepare('SELECT * FROM clients WHERE Login_Client = ?');
      $req->bindParam(1, $_POST['Login_Client']);
      $req->execute();
      if ($user = $req->fetch()) {
        ?>
        <p style="padding: 175px 0;">Ce nom d'utilisateur est déjà utilisé.</p>
        <button><a href="signup.php">Retour</a></button>
        <?php
        exit();
      }

      $sel = genererChaineAleatoire(30);
      $empreinte = hash("sha256", $_POST["MDP_Client"].$sel);

      $req = $bdd->prepare('INSERT INTO clients (Nom_Client, Prenom_Client, Adresse_Client, CP_Client, Ville_Client, DDN_Client, Login_Client, Empreinte_Client, Sel_Client) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $req->bindParam(1, $_POST['Nom_Client'], PDO::PARAM_STR);
      $req->bindParam(2, $_POST['Prenom_Client'], PDO::PARAM_STR);
      $req->bindParam(3, $_POST['Adresse_Client'], PDO::PARAM_STR);
      $req->bindParam(4, $_POST['CP_Client'], PDO::PARAM_STR);
      $req->bindParam(5, $_POST['Ville_Client'], PDO::PARAM_STR);
      $req->bindParam(6, $_POST['DDN_Client'], PDO::PARAM_STR);
      $req->bindParam(7, $_POST['Login_Client'], PDO::PARAM_STR);
      $req->bindParam(8, $empreinte, PDO::PARAM_STR);
      $req->bindParam(9, $sel, PDO::PARAM_STR);
      $req->execute();
      ?>

      <p style="padding: 175px 0;">Votre inscription est complète. Vous pouvez maintenant vous <a href="login.php" style="text-decoration: underline;">connecter</a>.</p>
    </div>
  </body>
</html>
