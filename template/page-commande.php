<div id="page">
<!--tableau-->
	<table class='table-list'>
	<tr class='tabheader'><th>ID</th><th>Numéro bt</th><th>Transporteur</th><th>Declarer un incident</th></tr>
	<?php 
	/*
	* Transformation du tableau des commandes multidimension en simple dimension 
	*  pour pouvoir manipuler les variables de manière simple
	*
	c.id_commandes, 
	c.nbr_bt, 
	t.nom_transporteur
	*/
	foreach($commande_multidim as $key=>$val):
		 foreach($val as $k=>$v){
		 $commande[$k]=$v;
		 }
	 ?>
	<tr class='tabrow' id="row-incident-<?php echo $commande['id_commandes']?>">
	   
		<td><span class='span-cell id-co' id='id-comm'><?php echo $commande['id_commandes']; ?></span></td>
		<td><span class='span-cell ref-co'><?php  echo $commande['nbr_bt'];?></span></td>
		<td>
			<span class='span-cell name-trans'><?php  echo $commande['nom_transporteur'];?></span>
		</td>		<td>
			<span class="demande-remboursement" id="id-demande-remboursement-<?php echo $commande['id_commandes']; ?>"><a href="" class="a-demande-rembour" >Démande de remboursement</a></span>
		</td>
	</tr>

	<?php endforeach; ?>

	</table>
	<!--fin tableau-->
	<!--pagination-->
	<?php require_once 'template/pagination-commande.php';?>	
	<!--fin pagination-->
</div>
<div class="clear"></div>

