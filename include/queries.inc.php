<?php
// *** SELECT ID USERS *** //
function getUserID($dbb,$useremail,$userpassword) {
	$sql = "SELECT iduser,useremail,userpassword 
							FROM `user`
							WHERE useremail = '".$useremail."' AND userpassword = '".$userpassword."' ;";
	$user = $dbb->prepare($sql);
	$user->execute();
	
	return $user;
}

function getCategories($dbb, $userlogin) {
	$categories = $dbb->prepare("SELECT c.categoryname 
							   FROM `category` c
							   JOIN `user` u ON u.iduser = c.id_user 
							   WHERE u.userlogin = '".$userlogin."';");
	
	$categories->execute();
}
// *** SELECT ALL TASKS OF USER *** //
function getTasks($dbb, $categoryname, $userlogin) {

	$tasks = $dbb->prepare("SELECT t.taskname, t.taskdescription, t.taskstart, t.taskend 
							FROM `task` t 
							JOIN `category` c ON c.idcategory = t.id_category 
							JOIN `user` u ON u.iduser = t.id_user 
							WHERE u.userlogin = '".$userlogin."' 
								AND c.categoryname = '".$categoryname."';");
								
	$tasks->execute();
	
	return $tasks;
}

// *** ADD USER *** //
function addUserLight($dbb,$useremail,$userpassword) {
	$sql = "INSERT INTO `user` (useremail,userpassword)
			VALUES ('".$useremail."',
					'".$userpassword."');";
	
	$users = $dbb->prepare($sql);
	try {
	$users->execute();
		return "Félicitation ! Vous êtes inscrits !";
	}
    catch (PDOException $e)
    {
		return "Erreur lors de l'ajout";
	}
}

function addUser($dbb, $userlastname, $userfirstname, $userlogin, $userpassword, $useremail) {
	$sql = "INSERT INTO `user` (userlastname, userfirstname, userlogin, userpassword, useremail)
			VALUES ('".$userlastname."',
					'".$userfirstname."',
					'".$userlogin."',
					'".$userpassword."',
					'".$useremail."');";
	
	$users = $dbb->prepare($sql);
	
	$users->execute();
}
// *** ADD CATEGORY *** //
function addCategory($dbb, $categoryname, $userlogin) {
	$user = $dbb->prepare("SELECT iduser 
							FROM `user` 
							WHERE userlogin = '".$userlogin."';");
	
	$user->execute();
	$tuser = $user->fetch();
	
	$sql = "INSERT INTO `category` (categoryname, id_user) 
			VALUES ('".$categoryname."', 
					".$tuser["iduser"].");";
	
	$category = $dbb->prepare($sql);
	
	$category->execute();
}
// *** ADD TASK *** //
function addTask($dbb, $categoryname, $userlogin, $taskname, $taskdescription, $taskstart, $taskend) {
	$user = $dbb->prepare("SELECT iduser 
							FROM `user` 
							WHERE userlogin = '".$userlogin."';");
	
	$user->execute();
	$tuser = $user->fetch();
	$userid = $tuser["iduser"];
	
	$category = $dbb->prepare("SELECT c.idcategory 
								FROM `category` c 
								JOIN `user` u ON u.iduser = c.id_user 
								WHERE c.id_user = ".$userid.";");
	
	$category->execute();
	$tcategory = $category->fetch();
	$categoryid = $tcategory["idcategory"];
	
	$sql = "INSERT INTO `task` (taskname, taskdescription, taskstart, taskend) 
			VALUES ('".$taskname."', 
					'".$taskdescription."', 
					'".$taskstart."', 
					'".$taskend."', 
					".$categoryid.", 
					".$userid.");";
	
	$category = $dbb->prepare($sql);
	
	$category->execute();
}

// *** UPDATE USER *** //
function updateUser($dbb, $userlastname, $userfirstname, $userlogin, $userpassword, $useremail) {
	$sql = "UPDATE `user` 
			SET userlastname = '".$userlastname."', 
				userfirstname = '".$userfirstname."', 
				userpassword = '".$userpassword."', 
				useremail = '".$useremail."'
			WHERE userlogin = '".$userlogin."';";
	
	$users = $dbb->prepare($sql);
	
	$users->execute();
}

// *** UPDATE CATEGORY *** //
function updateCategory($dbb, $categoryname, $userlogin) {
	$user = $dbb->prepare("SELECT iduser 
							FROM `user` 
							WHERE userlogin = '".$userlogin."';");
	
	$user->execute();
	$tuser = $user->fetch();
	$userid = $tuser["iduser"];
	
	$sql = "UPDATE `category`
			SET categoryname = '".$categoryname."'
			WHERE id_user = ".userid.";";
	
	$category = $dbb->prepare($sql);
	
	$category->execute();
}
// *** UPDATE TASK *** //
function updateTask($dbb, $categoryname, $userlogin, $taskname, $taskdescription, $taskstart, $taskend) {
	$user = $dbb->prepare("SELECT iduser 
							FROM `user` 
							WHERE userlogin = '".$userlogin."';");
	
	$user->execute();
	$tuser = $user->fetch();
	$userid = $tuser["iduser"];
	
	$category = $dbb->prepare("SELECT c.idcategory 
								FROM `category` c 
								JOIN `user` u ON u.iduser = c.id_user 
								WHERE c.id_user = ".$userid.";");
	
	$category->execute();
	$tcategory = $category->fetch();
	$categoryid = $tcategory["idcategory"];
	
	$sql = "UPDATE `task` 
			SET taskname = '".$taskname."', 
				taskdescription = '".$taskdescription."', 
				taskstart = '".$taskstart."', 
				taskend = '".$taskend."', 
				id_category = ".$categoryid.";";
	
	$category = $dbb->prepare($sql);
	
	$category->execute();
}
?>