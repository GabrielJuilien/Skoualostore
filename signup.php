<html>
  <?php include("head.php")?>
  <link rel="stylesheet" href="css/signup.css"/>
  <body>
    <?php include("top.php")?>
    <div id="content">
      <p class="title">Inscription</p>
      <?php
      if (isset($_SESSION['ID_Client'])) { ?>
        <p>
          Vous êtes déjà inscrit.
        </p>
        <?php
      }
      else { ?>
        <form action="signup_confirm.php" method="post" class="signup-form"><br />
          <table>
            <tr><td class="label">Nom : </td><td><input type="text" name="Nom_Client" pattern="[A-Za-z -]+"/><br /></td></tr>
            <tr><td class="label">Prenom : </td><td><input type="text" name="Prenom_Client" pattern="[A-Za-z -]+"/><br /></td></tr>
            <tr><td class="label">Date de naissance : </td><td><input type="date" name="DDN_Client"/><br /><br /></td></tr>

            <tr><td class="label">Adresse : </td><td><input type="text" name="Adresse_Client" pattern="[A-Za-z -]+"/><br /></td></tr>
            <tr><td class="label">Code postal : </td><td><input type="text" name="CP_Client" pattern="[0-9]{5}"/><br /></td></tr>
            <tr><td class="label">Ville : </td><td><input type="text" name="Ville_Client" pattern="[A-Za-z -]+"/><br /><br /></td></tr>

            <tr><td class="label">Login : </td><td><input type="text" name="Login_Client" pattern="[A-Za-z]{2,}"/><br /></td></tr>
            <tr><td class="label">Mot de passe : </td><td><input type="password" name="MDP_Client" pattern="[A-Za-z!?.;-_0-9]{5,32}"/><br /></td></tr>
            <tr><td class="label">Confirmation : </td><td><input type="password" name="MDP_Client_Confirmation" pattern="[A-Za-z!?.;-_0-9]{5,32}"/><br /><br /></td></tr>
            <tr><td class="label"></td><td><button type="submit">Inscription</button></td></tr>
          </table>
        </form>
        <?php
      }
       ?>
    </div>
  </body>
</html>
