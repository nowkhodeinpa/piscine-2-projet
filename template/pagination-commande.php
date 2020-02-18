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
	<br>
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
			<!---->
			<?php 
			$second_last = pagination_second_last($total_no_of_pages);
			if ($total_no_of_pages <= 10){   
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
					 if ($counter == $page_no) {
						echo "<li class='active num-page'><a>$counter</a></li>"; 
					 }else{
						echo "<li class=' num-page'><a href='?page_no=$counter'>$counter</a></li>";
					 }
				}
			}elseif ($total_no_of_pages > 10){
				if($page_no <= 4) { 
					 for ($counter = 1; $counter < 8; $counter++){ 
					 if ($counter == $page_no) {
						echo "<li id = 'active' class='active num-page'><a>$counter</a></li>"; 
					 }else{
							   echo "<li class=' num-page'><a href='?page_no=$counter'>$counter</a></li>";
									}
					}
					echo "<li class=' num-page'><a>...</a></li>";
					echo "<li class=' num-page'><a href='?page_no=$second_last'>$second_last</a></li>";
					echo "<li class=' num-page'><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
			}elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) { 
					echo "<li class=' num-page'><a href='?page_no=1'>1</a></li>";
					echo "<li class=' num-page'><a href='?page_no=2'>2</a></li>";
					echo "<li class=' num-page'><a>...</a></li>";
					for (
						 $counter = $page_no - $adjacents;
						 $counter <= $page_no + $adjacents;
						 $counter++
						 ) { 
						 if ($counter == $page_no) {
					 echo "<li class='active num-page'><a>$counter</a></li>"; 
					 }else{
							echo "<li class=' num-page'><a href='?page_no=$counter'>$counter</a></li>";
							  }                  
						   }
					echo "<li class=' num-page'><a>...</a></li>";
					echo "<li class=' num-page'><a href='?page_no=$second_last'>$second_last</a></li>";
					echo "<li class=' num-page'><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
			}else {
					echo "<li class=' num-page'><a href='?page_no=1'>1</a></li>";
					echo "<li class=' num-page'><a href='?page_no=2'>2</a></li>";
					echo "<li class=' num-page'><a>...</a></li>";
					for (
						 $counter = $total_no_of_pages - 6;
						 $counter <= $total_no_of_pages;
						 $counter++
						 ) {
						 if ($counter == $page_no) {
					 echo "<li class='active num-page'><a>$counter</a></li>"; 
					 }else{
							echo "<li class=' num-page'><a href='?page_no=$counter'>$counter</a></li>";
					 }                   
						 }
			}
			}
?>
			<!---->	
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