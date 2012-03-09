<?php

//Connexion a la base MySQL MyPlanning

if (($_SERVER['HTTP_HOST'] == "myplanning.xtreemhost.com") || ($_SERVER['HTTP_HOST'] == "mystasks.xtreemhost.com") || ($_SERVER['HTTP_HOST'] == "myplanning.co.cc"))
{ 
	//Base de production
		$myhost = "sql211.xtreemhost.com";
		$mydbname = "xth_10345396_planning";
		$myuser = "xth_10345396";
		$mypass = "uluberlu";
		$connectstring = "mysql:host=".$myhost.";dbname=".$mydbname;
		$modconn = "<pre> Connecté a la base de prod</pre>";
} 
else
{
	// Base de dev
		$myhost = "localhost";
		$mydbname = "myplanning";
		$myuser = "myplanuser";
		$mypass = "hDWxt6zFYTHFZjVU";
		$connectstring = "mysql:host=".$myhost.";dbname=".$mydbname;
		$modconn = "<pre> Connecté a la base de dev</pre>";
}

    try
    {   
		//On se connecte a la base de données
		$connmysql = new PDO($connectstring, $myuser, $mypass);
		$connmysql->exec("SET CHARACTER SET utf8");
		
		if (!empty($modconn)){ echo $modconn;}
	 }
    catch (PDOException $e)
    {
		// Si execption on affichage le message d'erreur
        die("Some fail-messages". $e->getMessage());
    }
	
?>