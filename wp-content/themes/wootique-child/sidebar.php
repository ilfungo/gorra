<?php 
	// Don't display sidebar if full width
	global $woo_options;
	if ( $woo_options[ 'woo_layout' ] != "layout-full" ) :
?>
<div id="sidebar" class="col-right">

	<?php if ( woo_active_sidebar( 'primary' ) ) : 
	
		//$backup = $post;  // backup the current object
		$taxonomy = 'genere';//  e.g. post_tag, category, custom taxonomy
		$param_type = 'genere'; //  e.g. tag__in, category__in, but genere__in will NOT work
        $tags="";
        if(isset($post))
		    $tags = wp_get_post_terms( $post->ID , $taxonomy);
		//print_r($tags);

		if ($tags) {?>
			<ul><?
		$query = new WP_Query( array( 'genere' => $tags[0]->slug ) );
			if( $query->have_posts() ) {
			  while ($query->have_posts()) : $query->the_post(); ?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
				<?php $found_none = '';
			  endwhile;
			}
		?>
			</ul>
		<?
		}else{
			
				?>
		<div class="primary">
			<?php woo_sidebar( 'primary' ); ?>		           
		</div>        
		<?php 
}
	endif;?>    
	
</div><!-- /#sidebar -->
<?php endif; ?>