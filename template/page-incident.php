<div id="page">
<!--tableau-->

<table border="0">
<tr class='tabheader'><th>ID</th><th>Référence Commande</th><th>Transporteur</th><th>Admin</th><th>Statut Gestion</th><th>#Dossier transporteur</th><th>Statut remboursement</th><th>Documents de gestion</th></tr>
<?php 
/*
* Transformation du tableau d'incident multidimension en simple dimension 
*  pour pouvoir manipuler les variables de manière simple
*/
foreach($incident_multidim as $key=>$val):
	 foreach($val as $k=>$v){
	 $incident[$k]=$v;
	 }
 ?>
 
<!--Etape 1-->
<tr class='tabrow' id="row-incident-<?php echo $incident['id']?>">
   
	<td><span class='id-inc'><?php echo $incident['id']; ?></span></td>
	<td><span class='ref-co'><?php  echo $incident['ref_com'];?></span></td>
	<td>
		<span class='span-cell name-trans'><?php  echo $incident['trans_nom'];?></span>
		<br>
		<span class='span-cell ref-trans'><?php  echo $incident['trans_ref'];?></span></td>
	<td>
		<span class='span-cell name-admin'><?php  echo $incident['admin_nom'];?></span>
		<br>
		<span class='span-cell date-admin'><?php  echo $incident['admin_date'];?></span>
	<td>
	    <!--voir parameters.php -->
		<span id="notif-gest-<?php echo $incident['id']; ?>" class='stat cell-stat-gest stat-gest-<?php echo $incident['stat_gest'];?>'><?php  echo PARAM_STATUT_GESTION[$incident['stat_gest']];?></span>
		<br>
	    <!--voir parameters.php -->
		<span id="dispo-doc-<?php echo $incident['id']; ?>" class='<?php echo ($incident['stat_doc'])?'visible':'invisible'?> stat cell-stat-doc stat-doc-<?php echo $incident['stat_doc'];?>'><?php  echo PARAM_STATUT_DOC[$incident['stat_doc']];?></span>
		<br>
	    <!--voir parameters.php -->
		<!-- afficher si une email est déjà envoyé, donc dépendre de la valeur du stat_mail -->
		<span id="notif-mail-<?php echo $incident['id']; ?>" class='<?php echo ($incident['stat_mail'])?'visible':'invisible'?> stat stat-mail'><?php  echo PARAM_STATUT_MAIL[$incident['stat_mail']];?></span>
	</td>
	<td class="<?php  echo($incident['stat_gest']!= 2)?'dossier-transporteur':'';?>" id="td-doss-transporteur-<?php echo $incident['id']?>">
	    <!-- cette input doit toujour afficher -->
		<span class='stat' id="span-doss-trans-<?php echo $incident['id']?>"><?php  echo $incident['doss_trans'];?></span>
	</td>
	<td id="cell-stat-remb-<?php echo $incident['id']; ?>">
	    <!--voir parameters.php -->
		<!-- l'affichage de cette partie dépend de la valeur du stat_remb -->
		<?php if(!$incident['stat_remb']): ?>
		<span class='stat-remb remb-ko stat'><?php  echo PARAM_STATUT_REMBOURSEMENT[$incident['stat_remb']];?></span>
		<?php else:?>
		<span class='remb-ok'><?php  echo PARAM_STATUT_REMBOURSEMENT[$incident['stat_remb']];?></span>
		<span class='remb-ok'>le, </span>
		<br>
		<span class='remb-ok'><?php  echo $incident['date_remb'];?></span>
		&nbsp;
		<span class='remb-ok'>pour <?php  echo number_format($incident['mt_remb'], 2, ',', ' ');?> €</span>
		<?php endif; ?>
		<!--  fin controle partie 1 -->
    </td>
	<td class="cell-doc-gest">
	    <!-- afficher si document est déjà scanner donc dépendre du stat_scan ou stat_doc ou pdf-->
		<span id="pdf-name-<?php echo $incident['id']; ?>" class='<?php echo ($incident['stat_scan'] || $incident['stat_doc'] || validateDocumentName($incident['pdf']))?'visible':'invisible'?> stat doc-pdf'><?php  echo $incident['pdf'];?></span>	
		<br>
		<span id="link-scan-<?php echo $incident['id']; ?>" class='link-scan'><input id="input-scan-<?php echo $incident['id']; ?>" class="input-scan" type="file"/><a href='' class='a-scan a-incident upload_link' id="upload_link_<?php  echo $incident['id'],'_',$incident['trans_nom'];?>">Scanner un document</a></span>
		<br>
		<!-- afficher si document est déjà scanner, donc dépendre de la valeur du stat_scan-->
		<span id="link-mail-<?php echo $incident['id']; ?>" class='<?php echo ($incident['stat_scan'])?'visible':'invisible'?> link-send-mail'><a href='' class='a-send-mail a-incident' id='mail-<?php echo $incident['id']; ?>'>Envoyer mail</a></span>
		<br>
		<!-- fin controle partie 3-->
		<!-- afficher si mail est déjà envoyé, donc dépend de la valeur du stat_mail-->
		<span  id="link-validate-<?php echo $incident['id']; ?>" class='<?php echo ($incident['stat_mail'])?'visible':'invisible'?> link-validate-doc'><a href='' class='a-validate-doc a-incident' id="validation-<?php echo $incident['id']; ?>" >Valider le remboursement</a></span><!-- fin controle partie 4-->
	</td>
</tr>

<?php endforeach; ?>

</table>

<!--fin tableau-->
	<!--pagination-->
	<?php require_once 'template/pagination.php';?>	
	<!--fin pagination-->
</div>
<div class="clear"></div>