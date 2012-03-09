<div id="logform">
<?php
if (!empty($_POST["logform"])){
//Connexion Utilisateur
	
	$useremail = $_POST["useremail"];
    $userpassword = md5($_POST["userpassword"]);
	$iduser = getUserID($connmysql,$useremail,$userpassword);
	$tusers = $iduser->fetch();
	if (!empty($tusers["iduser"])){
			$_SESSION['connect'] = 1;
			$_SESSION["iduser"] = $tusers["iduser"];
			$_SESSION["useremail"] = $tusers["useremail"];
			$_SESSION["userpassword"] = $tusers["userpassword"];
	}
	else
	{
        $connect = 0;//Si $_SESSION['connect'] n'existe pas, on donne la valeur "0".
		$error .= " Mauvais login / mot de passe.";
	}
	
}elseif (!empty($_POST["subform"])){
//Inscription Utilisateur
	
	if (!empty($_POST["useremail"]) && $_POST["useremail"] != "Monmail"){
		//Test mail
		$useremail = $_POST["useremail"];
			// Test mdp
			if ((!empty($_POST["userpassword"]) && !empty($_POST["userpassword2"]) ) && ($_POST["userpassword"] == $_POST["userpassword2"])){
				$userpassword = md5($_POST["userpassword"]);
				$resultat = addUserLight($connmysql,$useremail,$userpassword);
				$valid .= $resultat;
				//Connexion
				$iduser = getUserID($connmysql,$useremail,$userpassword);
				$tusers = $iduser->fetch();
				
				if (!empty($tusers["iduser"])){
					$_SESSION['newsub'] = 1;
					$_SESSION['connect'] = 1;
					$_SESSION["iduser"] = $tusers["iduser"];
					$_SESSION["useremail"] = $tusers["useremail"];
					$_SESSION["userpassword"] = $tusers["userpassword"];
				}
				
			}else{
				$error .= "Erreur les mots de passes ne correspondent pas";
			}
	}else{
		$error .= "Erreur Login ou Pass ne correspondent pas";
	}

}
//affichage des messages
if (!empty($valid)){
	echo "<h2><span style=\"color:#45A747\">".$valid."</span></h2>";
}
if (!empty($error)){
	echo $error;
}
if (!empty($info)){
	echo $info;
}
// Si le visiteur s'est identifié formule bonjour
if (isset($_SESSION["newsub"]) && $_SESSION["newsub"] == 1){
?>
<h2>Que voulez-vous faire ?</h2>
<a class="links" href="?pageid=2">Voir mon Planning</a>
<?php	 
}elseif (isset($_SESSION["connect"]) && $_SESSION["connect"] == 1){
// Sinon affiche le formulaire
		echo "<p>Vous êtes connecté, vous allez être redirigé vers la page d'accueil.</p>";
		header( "refresh:3;url=?pageid=2" ); 
}else{
?>
<?php 
	if (!empty($_GET["sub"])&&($_GET["sub"] == 1)) {
	//Inscription
?>
    <form name="subform" method="POST" action="?pageid=1">
    <fieldset>
    <legend>Inscription</legend>
	<p>Identifiant ou Mail<br>
      <input class="textin" name="useremail" placeholder="Login ou mail" type="text" /></p>
    <p>Mot de passe<br>
      <input class="textin" name="userpassword" placeholder="mdp" onClick="this.value='';" type="password" />
    </p>
    <p>Rétapez le mot de passe<br>
      <input class="textin" name="userpassword2"  placeholder="mdp" type="password" />
    </p>
    <p>
      <input type="submit" class="subform" name="subform" value="S'inscrire" />
    </p>
    <p>
    <a class="links" href="?pageid=1">< Retour</a>
    </p>
    </fieldset>
    </form>
<?php
	}else{
	//Login
?>
    <form name="logform" method="POST" action="?pageid=1">
    <fieldset>
    <legend>Connexion</legend>
    <p>Login ou Mail<br>
      <input class="textin" name="useremail" placeholder="Login ou mail" type="text"  /></p>
    <p>Mot de passe<br>
      <input class="textin" name="userpassword"  placeholder="mdp" type="password"  />
    </p>
    <p>
      <input type="submit" class="subform" name="logform" value="Connexion" />
    </p>
    <p>
    <a class="linka" href="?pageid=1&sub=1">S'inscrire</a>
    </p>
    </fieldset>
    </form>
<?php
	}
}
?>

</div>