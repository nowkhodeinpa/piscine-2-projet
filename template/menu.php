<div id="menu">
 <ul class="ul-menu-admin">
  <li class="li-list-data"><a href="list-commandes.php" class="a-list-data">Liste commandes</a></li>
  <li class="li-list-data"><a href="list-incidents.php" class="a-list-data">Liste incidents</a></li>
 </ul>
 <!-- filtre -->
 <?php if(get_uri() === '/list-incidents.php'){require_once 'template/filtre-incident.php';} ?>
 <!-- filtre-->
</div>