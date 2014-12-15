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

//visualizzo le sottocategorie ordinate per ordine alfabetico!!!

if ( ! function_exists( 'woocommerce_product_sub_subcategories' ) ) {

    /**
     * Display product sub categories as thumbnails.
     *
     * @access public
     * @subpackage	Loop
     * @param array $args
     * @return null|boolean
     */
    function woocommerce_product_sub_subcategories( $args = array() ) {
        global $wp_query;

        $defaults = array(
            'before'        => '',
            'after'         => '',
            'force_display' => false
        );

        $args = wp_parse_args( $args, $defaults );

        extract( $args );

        // Main query only
        if ( ! is_main_query() && ! $force_display ) {
            return;
        }

        // Don't show when filtering, searching or when on page > 1 and ensure we're on a product archive
        if ( is_search() || is_filtered() || is_paged() || ( ! is_product_category() && ! is_shop() ) ) {
            return;
        }

        // Check categories are enabled
        if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == '' ) {
            return;
        }

        // Find the category + category parent, if applicable
        // Find the category + category children!!!, if applicable
        $term 			= get_queried_object();
        $parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

        if ( is_product_category() ) {
            $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );
            //ritorna il parametro di configurazione su cosa va mostrato! potrei agire da qui?!
            //print_r($display_type);

            switch ( $display_type ) {
                case 'products' :
                    return;
                    break;
                case '' :
                    if ( get_option( 'woocommerce_category_archive_display' ) == '' ) {
                        return;
                    }
                    break;
            }
        }

        // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( http://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
        $product_categories = get_categories(array(
            'parent'       => $parent_id,
            'child_of'     => 2,
            'menu_order'   => 'ASC',
            'hide_empty'   => 0,
            'hierarchical' => 2,
            'taxonomy'     => 'product_cat',
            'pad_counts'   => 1
        ) );

        //print_r($product_categories);
        $child_product_categories = array();

        foreach($product_categories as $product_category){
            $child_product_categories_temp = get_categories(array(
                'parent'       => $product_category->term_id,
                'child_of'     => 2,
                'menu_order'   => 'ASC',
                'hide_empty'   => 0,
                'hierarchical' => 2,
                'taxonomy'     => 'product_cat',
                'pad_counts'   => 1
            ));
            foreach($child_product_categories_temp as $child_product_category_temp){
                array_push($child_product_categories,$child_product_category_temp);
            }

        }
        foreach($child_product_categories as $child_product_category){
            //echo $child_product_category->slug."<br>";
            $my_child_product_category[$child_product_category->slug]=$child_product_category;
        }

        ksort($my_child_product_category);
        //print_r($my_child_product_category);
        //exit();

        if ( ! apply_filters( 'woocommerce_product_subcategories_hide_empty', false ) ) {
            $my_child_product_category = wp_list_filter( $my_child_product_category, array( 'count' => 0 ), 'NOT' );
        }

        $product_category_found = false;

        if ( $my_child_product_category ) {
            echo $before;

            foreach ( $my_child_product_category as $category ) {
                wc_get_template( 'content-product_cat.php', array(
                    'category' => $category
                ) );
            }

            // If we are hiding products disable the loop and pagination
            if ( is_product_category() ) {
                $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

                switch ( $display_type ) {
                    case 'subcategories' :
                        $wp_query->post_count    = 0;
                        $wp_query->max_num_pages = 0;
                        break;
                    case '' :
                        if ( get_option( 'woocommerce_category_archive_display' ) == 'subcategories' ) {
                            $wp_query->post_count    = 0;
                            $wp_query->max_num_pages = 0;
                        }
                        break;
                }
            }

            if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
                $wp_query->post_count    = 0;
                $wp_query->max_num_pages = 0;
            }

            echo $after;
        }

        return true;
    }
}