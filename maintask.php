<?php
//Test si l'utilisateur est connecté
if ((empty($_SESSION["connect"])||($_SESSION["connect"] != 1))) {
	header("Location: ?pageid=1");
}
?>
<div id="boxtitle" class="encours" >En Cours</div>
<div id="tasks">
  <ul>
    <li>Cours Développement <br/><em>14h00 - 17h30</em></li>
    <li>Faires courses</li>
  </ul>
</div>
<div id="boxtitle" class="avenir">A venir</div>
<div id="tasks">
  <ul>
    <li>Cours Réseau   <br/><em>8h00 - 15h00</em></li>
    <li>Aller au garage</li>
    <li>Faire les courses</li>
  </ul>
</div>
<a class="links" href="#" >Voir Archives</a>