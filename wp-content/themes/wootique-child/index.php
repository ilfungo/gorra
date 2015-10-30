<?php
	get_header();
	global $woo_options;
	if ( $woo_options['woo_homepage_content'] == 'true' ) {
?>
	<div id="introduction">
        <?php
            $catquery = new WP_Query( 'cat=442&posts_per_page=1' );
            while($catquery->have_posts()) : $catquery->the_post();
        ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
        <?php endwhile; ?>
	</div>
	<?php
		}
			if(function_exists("meteor_slideshow")) 
			{ 
				meteor_slideshow("test-slideshow"); 
			}
	?>
	<br>
	<!-- /#content -->
	
	 <div id="content" class="col-full">

		<div id="main" class="col-left">

<!-- prodotti recenti rimossi -->
			<!--div class="product-gallery">
				<h2><?php //_e( 'Prodotti recenti', 'woothemes' ); ?></h2>
				<?php //echo do_shortcode( '[recent_products per_page="12" columns="3"]' ); ?>
			</div><!--/.product-gallery-->

            <?php
            $catquery = new WP_Query( 'cat=1&posts_per_page=10' );
            while($catquery->have_posts()) : $catquery->the_post();
                ?>
                <?php
                 $riassunto = has_excerpt();
                 if ($riassunto == true): ?>
                    <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                    <?php the_content(); ?>
                 <?php endif;
                    if($riassunto == false): ?>
                        <h3><?php the_title(); ?></h3>
                        <?php the_content(); ?>
                    <?php endif; ?>

            <?php endwhile; ?>
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div>
	<!-- prodotti in evidenza rimossi -->

	<!--div id="featured-products" class="<?php //if ( get_option( 'woo_featured_product_style' ) == 'slider' ) { echo 'fp-slider'; } ?>">
		<h2><?php //_e( 'Prodotti in evidenza', 'woothemes' ); ?></h2>

		<ul class="featured-products">
<?php
$args = array( 'post_type' => 'product', 'posts_per_page' => get_option( 'woo_featured_product_limit' ), 'meta_key' => '_featured', 'meta_value' => 'yes' );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post(); $_product;
if ( function_exists( 'get_product' ) ) {
	$_product = get_product( $loop->post->ID );
} else {
	$_product = new WC_Product( $loop->post->ID );
}
?>
			<li class="flipper">


					<div class="front">

						<?php woocommerce_show_product_sale_flash( $post, $_product ); ?>

							<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
							<?php if ( has_post_thumbnail( $loop->post->ID ) ) echo get_the_post_thumbnail( $loop->post->ID, 'shop_thumbnail' ); else echo '<img src="' . $woocommerce->plugin_url() . '/assets/images/placeholder.png" alt="Placeholder" width="' . wc_get_image_size( 'shop_thumbnail_image_width' ) . 'px" height="' . wc_get_image_size( 'shop_thumbnail_image_height' ) . 'px" />'; ?>
							</a>

					</div><!--/.front-->

					<div class="back">
						<h3><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">	<?php the_title(); ?></a></h3>
						<span class="price"><?php echo $_product->get_price_html(); ?></span>
						<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
					</div><!--/.back-->

			</li>
			<?php endwhile; ?>
		</ul>
		<div class="clear"></div>
	</div><!--/#featured-products-->

   

<?php get_footer(); ?>