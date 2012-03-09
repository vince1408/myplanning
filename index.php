<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gérez vos tâches !</title>
<?php
//Démarrage de session
session_start();


//On inclus les différents fichiers de connexion / fonctions
include("include/connect.inc.php");
include("include/function.inc.php");
include("include/queries.inc.php");

//Initialisation variables messages
$valid = "";
$error = "";
$info = "";
//tesst
//On teste si le navigateur client est un mobile
if (!isset ($_SESSION['mobile']))
		$_SESSION['mobile'] = detection_mobile(); //On appel la fonction de detection du navigateur
	if ($_SESSION['mobile'] == true) { //Version Mobile
		?>
		<!--<link rel="stylesheet" type="text/css" href="css/mymobileplanning.css" />-->
		<meta name="HandheldFriendly" content="true" />
		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=0.25" />
		<script src="js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jqtouch.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="javascript" charset="utf-8">
            var jQT = new $.jQTouch({
                icon: 'jqtouch.png',
                icon4: 'jqtouch4.png',
                addGlossToIcon: false,
                startupScreen: 'jqt_startup.png',
                statusBar: 'black-translucent',
                themeSelectionSelector: '#jqt #themes ul',
                preloadImages: []
            });
        </script>
		<?php
		}else{  //Version desktop
		?>
			<link href="css/myplanning.css" rel="stylesheet">
		<?php
		}
		?>

</head>
<body>
<div id="main">
<h1><span style="color:#45A747">My</span>Planning</h1>
<?php
// Deconnexion Utilisateur
if (!empty($_GET["logout"])&&($_GET["logout"] == 1)){
	$_SESSION = null;
	session_destroy();
	$valid .= " Vous êtes déconnecté. ";
	}
	
// Si le visiteur s'est identifié formule bonjour
if (isset($_SESSION["connect"]) && $_SESSION["connect"] == "1") 
{
	echo "<h2>Bonjour <span style=\"color:#45A747\">".$_SESSION["useremail"]."</span></h2>" ;
}

//affichage des messages
if (!empty($valid)){
	echo "<h2><span style=\"color:#45A747\">".$valid."</span></h2>";
	$valid = "";
}
if (!empty($error)){
	echo $error;
	$error = "";
}
if (!empty($info)){
	echo $info;
	$info = "";
}
	//Gestion des include
	//Création du tableau des tâches disponibles
	$pageok = array(1 => "login.php",
					2 => "maintask.php",
					3 => "usermanager.php",
					4 => "usertask.php");
	
	if (!empty($_GET["pageid"])&&(isset($pageok[$_GET["pageid"]]))){
		//Si ok on affiche la page en question
			include($pageok[$_GET["pageid"]]);
	}else{
		if (isset($_SESSION["connect"]) && $_SESSION["connect"] == "1") 
		{
			//On affiche les tâches
			include("maintask.php");
		}else{
			//Sinon on affiche le login
			include("login.php");
		}

	}
// Si le visiteur s'est identifié formule bonjour
if (isset($_SESSION["connect"]) && $_SESSION["connect"] == "1") 
{
?>
<p><a class="discret" href="?logout=1" >Déconnexion </a></p>
<?php
}
?>
<div id="footer">© Myplanning 2012</div>
</div>
<?php
	include("include/deconnect.inc.php");
?>
</body>
</html>
