<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
//print_r($product);
//echo $product->get_price_html();
//if($product->get_price_html()!=""){
//if(1==2){//lo sposto a mano nei meta
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<div class="price"><span class="mylabel">Prezzo in vaso standard:</span> <span class="myvalue"><?php echo $product->get_price_html(); ?></span></div>

	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>
<?php //}?>