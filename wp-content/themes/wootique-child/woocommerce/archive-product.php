<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */

        global $wp_query;
        $term = $wp_query->get_queried_object();

		do_action( 'woocommerce_before_main_content' );
	?>
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <?php
            $parent_term = get_term($term->parent, "product_cat" );
            $grand_parent_term = get_term($parent_term->parent, "product_cat" );
            //print_r($term);
            //print_r($parent_term);
            //print_r($grand_parent_term);

            $product_categories_all_hierachy = get_tax_and_ancestors( $term->term_id, 'product_cat' );
            //print_r($product_categories_all_hierachy);
            if($term->parent==14 || $term->parent==226){
            $variable = get_field('tiplogia_categoria', $term);
            ?>
            <div id="<?php echo $variable ?>">
			    <h1 class="page-title"><?php echo $parent_term->name ." "; woocommerce_page_title(); ?></h1>
            </div>
            <?php }elseif($grand_parent_term->term_id==14 || $grand_parent_term->term_id==226){
            $variable = get_field('tiplogia_categoria', $term);
            ?>
            <div id="<?php echo $variable ?>">
            <h1 class="page-title"><?php echo $grand_parent_term->name ." ";echo $parent_term->name ." - "; woocommerce_page_title(); ?></h1>
            </div>
            <?php }else{
            $variable = get_field('tiplogia_categoria', $term);?>
            <div id="<?php echo $variable ?>">
            <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
            </div>
            <?php }
            foreach($product_categories_all_hierachy as $product_category){
                $this_term = get_term($product_category, "product_cat" );
                $variable = get_field('tiplogia_categoria', $this_term);
                if($variable=="famiglia"){
                    $link = get_term_link( $this_term, 'product_cat' );
                    echo "<div  class=\"famiglia\">Famiglia: <b class=\"famiglia\"><a href=\"".$link."\">".$this_term->name."</a></b></div> ";
                }
            }
            ?>


		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php
                if($term->term_id==13 OR $term->term_id==15){
                    //print_r($term);
                    //echo "passo da qui";
                    woocommerce_product_sub_subcategories();
                }else{
                    //echo "passo da qua";
                    woocommerce_product_subcategories();
                }
                ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>