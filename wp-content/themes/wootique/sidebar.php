<?php 
	// Don't display sidebar if full width
	global $woo_options;
	if ( $woo_options[ 'woo_layout' ] != "layout-full" ) :
?>	
<div id="sidebar" class="col-right">

	<?php if ( woo_active_sidebar( 'primary' ) ) : 
	//echo "terms -> ".$post->ID;
	$terms = wp_get_post_terms( $post->ID, "genere" );
	var_dump($terms);
	print_r($terms);
	
	//print_r(get_queried_object());
	//if(get_queried_object()->term_taxonomy_id==13){//perenni
	//}else if(get_queried_object()->term_taxonomy_id==13){//perenni
	//}else if(get_queried_object()->term_taxonomy_id==13){//perenni
	//}else if(get_queried_object()->term_taxonomy_id==13){//perenni
	//}else{
		?>
		<div class="primary">
			<?php woo_sidebar( 'primary' ); ?>		           
		</div>        
		<?php 
	//}
	endif; ?>    
	
</div><!-- /#sidebar -->

<?php endif; ?>