<html>
 <head>
 <meta charset="utf-8">
 <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
 </head>
 <body>
 <div id="container">
 <form action="verification.php" method="POST">
 <h1>Bienvenue sur le VPN d'Ynov !</h1>
 <input type="submit" id='submit' value='Se Connecter au VPN' >
 <?php
 if(isset($_GET['erreur'])){
 $err = $_GET['erreur'];
 if($err==1 || $err==2)
 echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
 }
 ?>
 </form>
 </div>
 </body>
</html>