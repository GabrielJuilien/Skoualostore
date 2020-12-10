<html>
<?php include("head.php")?>
<link rel="stylesheet" href="css/signup.css"/>
<body>
  <?php include("top.php")?>
  <div id="content">
    <p class="title">Connexion</p>
    <?php
    if (isset($_POST['action']) && !strcmp($_POST['action'], "login")) {
      if (empty($_POST['Login_Form']) || empty($_POST['Password_Form'])) {
        ?>
        Identifiant ou mot de passe non-renseigné.
        <?php
        exit();
      }

      $req = $bdd->prepare('SELECT * FROM clients WHERE Login_Client = ?');
      $req->bindParam(1, $_POST['Login_Form']);
      $req->execute();

      if ($user = $req->fetch()) {
        if ($user['Empreinte_Client'] == hash("sha256", $_POST['Password_Form'].$user['Sel_Client'])) {
          $_SESSION['ID_Client'] = $user['ID_Client'];
          ?>
          Connexion réussie.
          <?php
          exit();
        }
        else {
          ?>
          Erreur de connexion. <a href="login.php" style="text-decoration: underline;">Réessayer</a>
          <?php
          exit();
        }
      }
      else {
        ?>
        Erreur de connexion. <a href="login.php" style="text-decoration: underline;">Réessayer</a>
        <?php
        exit();
      }
    }

    if (!isset($_SESSION['ID_Client'])) {
      ?>
      <form action="login.php" method="post">
        <input type="hidden" name="action" value="login">
        <table>
          <tr><td class="label">Identifiant : </td><td><input type="text" name="Login_Form"/><br /></td></tr>
          <tr><td class="label">Mot de passe : </td><td><input type="password" name="Password_Form"/><br /></td></tr>
          <tr><td></td><td><button type="submit">Connexion</button></td></tr>
          <tr><td></td><td>Pas encore inscrit ? <a href="signup.php" style="text-decoration: underline;">Inscription</a></td></tr>
        </table>
      </form>
      <?php
    }
    ?>
  </div>
</body>
</html>
