<?php
/*
* Variables pour des paginations
*/
//$offset = pagination_offset();
$page_no = pagination_get_current_page();
$previous_page = pagination_prev();
$next_page = pagination_next();
?>

<div id="pagination">
	<div class="tableau-bord-pagination">
	<strong>Page <?php echo $no_page_of_total; ?></strong>
	</div>
	
    <div class="button-pagination">
	    <ul class="pagination">
			<?php if($page_no > 1): ?>
			<li>
			<a class='a-pagination' href='<?php echo pagination_build_query_string(1)?>'>
			<span class='span-pagination'>Début</span>
			</a>
			</li>
			<?php endif; ?>
				
			<li class= "<?php echo ($page_no <= 1)?'disabled':'' ?>">
			<a  class='a-pagination' 
			<?php echo($page_no > 1)?'href="'.pagination_build_query_string($previous_page).'"':'' ?> >
			<span class='span-pagination'>Précédent</span>
			</a>
			</li>
				
			<li class= "<?php echo ($page_no >= $total_no_of_pages)?'disabled':'' ?>">
			<a class='a-pagination' 			
			<?php echo($page_no < $total_no_of_pages)?'href="'.pagination_build_query_string($next_page).'"':'' ?> >
			<span class='span-pagination'>Suivant</span>
			</a>
			</li>
			 
			<?php if($page_no < $total_no_of_pages): ?>
			<li>
			<a class='a-pagination' href='<?php echo pagination_build_query_string($total_no_of_pages)?>'>
			<span class='span-pagination'>Fin &rsaquo;&rsaquo;</span>
			</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
	
</div>