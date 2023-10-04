<?php
session_start();
include "header.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" href="style.css" media="screen" type="text/css" />
</head>

 <body>
<div class="login-register-container">

<?php
if (!isset($_SESSION['userID']) || !isset($_SESSION['username'])) {
?>
<div class="alert-container">
        <div class="alert-message">
          Vous n'êtes pas connecté.
        </div>
    </div>
	<?php
}?>

 <div id="container">
 <form>
 <h1>Bienvenue sur le VPN d'Ynov !</h1>
 <p>Ynov Virtual Private Network, est un service de réseau privé virtuel spécialement conçu pour répondre aux besoins de l'école Ynov. Développé pour garantir la sécurité et la confidentialité optimale de tous les membres de la communauté Ynov, comme les étudiants, les enseignants, et le personnel administratif.</p>
 
 <?php
 if (!isset($_SESSION['userID']) || !isset($_SESSION['username'])) {
?>
<p>Vous n'êtes pas encore connecté ! Vous n'avez donc pas accès aux différentes pages de ce site, veuilez vous connecter ou vous enregistrer.<p>
 <a href="../php_template/registerhtml.php" class="button">S'enregistrer</a>
<a href="../php_template/loginHtml.php" class="button">Se connecter</a>
<?php
}?>

</form>
 </div>
 </div>
 </body>
</html>
<?php
