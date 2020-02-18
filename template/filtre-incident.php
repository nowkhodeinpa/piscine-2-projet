 <!--Filtre incident-->
 <div id="filtre-incident" class="filtre">
    <h4 class='title-filtre'>Filtres incident</h4>
	 <ul class="ul-filtre">
	  <li class="li-list-data li-filtre">
	    <a href="?state=all" class="a-list-data">Afficher tout &nbsp;&nbsp;
		 <span class='nb-item' id='tout'><?php echo nombre_incident(); ?></span>
		</a>
	  </li>
	  <li class="li-list-data li-filtre">
	    <a href="?state-ge=0" class="a-list-data">Pas géré &nbsp;&nbsp;
		 <span class='nb-item' id='pas-gerer'><?php echo nombre_incident_non_gere(); ?></span>
		</a>
	  </li>
	  <li class="li-list-data li-filtre">
	    <a href="?state-ge=1&state-re=0" class="a-list-data">Géré en attente de remboursement &nbsp;&nbsp;
		 <span class='nb-item' id='gerer-en-attente'><?php echo nombre_incident_gere_enattente_remboursement(); ?></span>
		</a>
	  </li>
	  <li class="li-list-data li-filtre">
	    <a href="?state-re=1" class="a-list-data">Colis remboursé &nbsp;&nbsp;
		 <span class='nb-item' id='rembourser'><?php echo nombre_incident_rembourser(); ?></span>
		</a>
	  </li>
	 </ul>
 </div> 
 <!--fin filtre-->