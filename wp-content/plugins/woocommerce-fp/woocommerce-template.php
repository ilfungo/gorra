<?php
/**
 * Template Function Overrides
 *
 */

if ( ! function_exists( 'woocommerce_template_single_category' ) ) {

     /**
      * Output the product title.
      *
      * @access public
      * @subpackage  Product
      * @return void
      */
     function woocommerce_template_single_category() {
         wc_get_template( 'single-product/category.php' );
     }
}

function get_last_array($array_seq){
    if(!is_array($array_seq)) return false;
	end($array_seq);         // move the internal pointer to the end of the array
	$key = key($array_seq);  // fetches the key of the element pointed to by the internal pointer
	//var_dump($key);
	//echo "key".$key;
	return $key;
}