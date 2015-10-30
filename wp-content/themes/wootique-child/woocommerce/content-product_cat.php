<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;
if ( empty( $woocommerce_loop['this_letter_temp'] ) )
    $woocommerce_loop['this_letter_temp'] = "";

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;
//non è mai valorizzata correttamente
//echo "<br clear=\"both\">this_letter_temp -> ".$woocommerce_loop['this_letter_temp']." and loop ".$woocommerce_loop['loop'];

if($woocommerce_loop['this_letter_temp'] == $this_letter){
	 //echo "<br>è uguale";
}else{
	 //echo "<br>è diversa"; 
	if($woocommerce_loop['loop']==1){
		 echo "\n".'<div  class="tab-content" id="'."letter".$this_letter.'">'."\n";
	}else{
		echo  "\n".'</div>'."\n".'<div  class="tab-content" id="'."letter".$this_letter.'">'."\n";
	}
	 //echo $woocommerce_loop['this_letter_temp'].$woocommerce_loop['loop']."<br>";
}
?>
<li class="product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?>">
	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
    <?php
    if($woocommerce_loop['this_letter_temp'] == $this_letter){ ?>
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>"> 
    <?php }else{?>  
            <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>"><!-- name="<?php echo "letter".$this_letter?>" -->
    <?php }

			/**
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_subcategory_title', $category );
		?>
		<h3>
			<?php
				$woocommerce_loop['loop']." - ";
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</h3>
		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>
	</a>
	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
</li>
<?php
$woocommerce_loop['this_letter_temp'] = $this_letter;
?>