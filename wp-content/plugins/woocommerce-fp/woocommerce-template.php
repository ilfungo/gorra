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

/*        // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( http://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
        $product_categories = get_categories(array(
            'parent'       => $parent_id,
            'child_of'     => 2,
            'menu_order'   => 'ASC',
            'hide_empty'   => 0,
            'hierarchical' => 2,
            'taxonomy'     => 'product_cat',
            'pad_counts'   => 1
        ) );*/
        // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( http://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
        $product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
            'parent'       => $parent_id,
            'menu_order'   => 'ASC',
            'hide_empty'   => 0,
            'hierarchical' => 1,
            'taxonomy'     => 'product_cat',
            'pad_counts'   => 1
        ) ) );

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

            crate_alphabetic_menu(array("child_product_category"=>$my_child_product_category));

            foreach ( $my_child_product_category as $category ) {
                $this_letter = substr($category->slug, 0, 1);
                wc_get_template( 'content-product_cat.php', array(
                    'category' => $category, 'this_letter' => $this_letter
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


if ( ! function_exists( 'crate_alphabetic_menu' ) ) {

    function crate_alphabetic_menu( $args = array() ) {

        $defaults = array(
            'before'        => '',
            'after'         => '',
            'force_display' => false
        );
        $args = wp_parse_args( $args, $defaults );

        extract( $args );
        //echo "<br>===========================<br>";
        //print_r($child_product_category);
        //echo "<br>===========================<br>";
        //$output = $before . $text . $after;

        //echo $output;

        foreach($child_product_category as $single_child_product_category){
            $this_letter = substr($single_child_product_category->slug, 0, 1);
            if(!in_array($this_letter,$letters))
                $letters[]=$this_letter;


        }
        //print_r($letters);
        echo "<div id=\"alphabetical_order_navigation\">Naviga per nome alfabetico: ";
        $i=1;
        foreach($letters as $letter){
            echo "<a href=\"#letter".$letter."\">".strtoupper($letter)."</a>";
            if($i<count($letters)){echo ", ";}
            //echo $i." ".count($letters)." / ";
            $i++;
        }
        echo "</div>";

    }
}


//add_action( 'woocommerce_review_order_before_submit', 'wordimpress_custom_checkout_field' );

function wordimpress_custom_checkout_field( $checkout ) {

    echo '<div id="my_custom_checkout_field">
            <h3>' . __( 'Proposta in caso di piante mancanti' ) . '</h3>
            <p style="margin: 0 0 8px;">Gradisci una proposta diversa nel caso in cui una o alcune delle piante che hai ordinato non siano disponibili?</p>';

//    woocommerce_form_field( 'inscription_checkbox', array(
//        'type'  => 'checkbox',
//        'class' => array( 'inscription-checkbox form-row-wide' ),
//        'label' => __( 'Yes' ),
//    ), $checkout->get_value( 'inscription_checkbox' ) );
//
    woocommerce_form_field( 'inscription_checkbox', array(
        'type'  => 'checkbox',
        'class' => array( 'inscription-checkbox form-row-wide' ),
        'label' => __( 'Yes' ),
    ));

    echo '</div>';


}

add_action( 'woocommerce_review_order_before_submit', 'descriprion_in_review_order_after_cart_contents' );

function descriprion_in_review_order_after_cart_contents() {

    echo "<div class='payment_box payment_method_pre_ordine'>\n";
    echo "<div id=\"infoSpedizione\">Leggi le modalità di pagamento e per indicazioni generali relative  ai costi di spedizione +</div>\n";
    echo "<div id=\"costiSpedizione\">Condizioni spedizione</div>\n";
    echo "</div>\n";
    ?>
    <script>
        jQuery(function ($) {
            $("#infoSpedizione").click(function(){
                $("#costiSpedizione").toggle();
            });
        });
    </script>
<?php

}

/*---Move Product price by moving add to cart*/
/*
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 50 );

add_action( 'woocommerce_after_order_notes', 'wordimpress_custom_checkout_field' );
*/



/*---Move Product price by moving add to cart*/
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 50 );

function get_tax_and_ancestors($object_id = 0, $object_type = '') {
    $object_id = (int) $object_id;

    $ancestors = array();

    if ( empty( $object_id ) ) {

        /** This filter is documented in wp-includes/taxonomy.php */
        return apply_filters( 'get_ancestors', $ancestors, $object_id, $object_type );
    }

    if ( is_taxonomy_hierarchical( $object_type ) ) {
        $term = get_term($object_id, $object_type);
        $ancestors[] = $term ;
        while ( ! is_wp_error($term) && ! empty( $term->parent ) && ! in_array( $term->parent, $ancestors ) ) {
            $ancestors[] = (int) $term->parent;
            $term = get_term($term->parent, $object_type);
        }
    } elseif ( post_type_exists( $object_type ) ) {
        $ancestors = get_post_ancestors($object_id);
    }

    /**
     * Filter a given object's ancestors.
     *
     * @since 3.1.0
     *
     * @param array  $ancestors   An array of object ancestors.
     * @param int    $object_id   Object ID.
     * @param string $object_type Type of object.
     */
    return apply_filters( 'get_ancestors', $ancestors, $object_id, $object_type );
}

//http://wpthemetutorial.com/2014/03/20/change-product-category-order-woocommerce/ -> scrivi ci un articolo sopra


//=================================inserisco l'ordine alfabetico=================================

add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'slug_list' == $orderby_value ) {
        $args['orderby'] = 'name';
        $args['order'] = 'ASC';
        $args['meta_key'] = '';
    }
    //print_r($args);
    return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['slug_list'] = 'Ordina alfabeticamente';
    return $sortby;
}

//=================================inserisco l'ordine alfabetico=================================


class My_Category_Walker extends Walker_Category {

    var $lev = -1;
    var $skip = 0;
    static $current_parent;

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $this->lev = 0;
        $output .= "<ul>" . PHP_EOL;
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "</ul>" . PHP_EOL;
        $this->lev = -1;
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        extract($args);
        $cat_name = esc_attr( $category->name );
        $class_current = $current_class ? $current_class . ' ' : 'current ';
        if ( ! empty($current_category) ) {
            $_current_category = get_term( $current_category, $category->taxonomy );
            if ( $category->term_id == $current_category ) $class = $class_current;
            elseif ( $category->term_id == $_current_category->parent ) $class = rtrim($class_current) . '-parent ';
        } else {
            $class = '';
        }
        if ( ! $category->parent ) {
            if ( ! get_term_children( $category->term_id, $category->taxonomy ) ) {
                $this->skip = 1;
            } else {
                if ($class == $class_current) self::$current_parent = $category->term_id;
                //$output .= "<li class='" . $class . $level_class . "'>" . PHP_EOL;
                //$output .= sprintf($parent_title_format, $cat_name) . PHP_EOL;
            }
        } else {
            if ( $this->lev == 0 && $category->parent) {
                $link = get_term_link(intval($category->parent) , $category->taxonomy);
                $stored_parent = intval(self::$current_parent);
                $now_parent = intval($category->parent);
                $all_class = ($stored_parent > 0 && ( $stored_parent === $now_parent) ) ? $class_current . ' all' : 'all';
                //$output .= "<li class='" . $all_class . "'><a href='" . $link . "'>" . __('All') . "</a></li>\n";
                self::$current_parent = null;
            }
            if($category->parent==13 OR $category->parent==15){//escludo i link se il parent è graminacee o stocazzo
                $link = $cat_name ;
                $output .= "<li";
                $class .= $category->taxonomy . '-item '.$category->taxonomy . '-high ' . $category->taxonomy . '-item-' . $category->term_id;
                $output .=  ' class="' . $class . '"';
                $output .= ">" . $link;
            }else{
                $link = '<a href="' . esc_url( get_term_link($category) ) . '" >' . $cat_name . '</a>';
                if ( ! empty( $args['show_count'] ) ) {
                    $link .= ' (' . number_format_i18n( $category->count ) . ')';
                }
                $output .= "<li";
                $class .= $category->taxonomy . '-item ' . $category->taxonomy . '-item-' . $category->term_id;
                $output .=  ' class="' . $class . '"';
                $output .= ">" . $link;
            }
        }
    }

    function end_el( &$output, $page, $depth = 0, $args = array() ) {
        $this->lev++;
        if ( $this->skip == 1 ) {
            $this->skip = 0;
            return;
        }
        $output .= "</li>" . PHP_EOL;
    }

}

function gorra_list_categories( $args = '' ) {
    $defaults = array(
        'taxonomy' => 'product_cat',
        'show_option_none' => '',
        'echo' => 1,
        'depth' => 3,
        'wrap_class' => '',
        'level_class' => '',
        'parent_title_format' => '%s',
        'current_class' => 'current',
        'show_count' => 1
    );

    $r = wp_parse_args( $args, $defaults );

    if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
        $r['pad_counts'] = true;

    if ( ! isset( $r['wrap_class'] ) ) $r['wrap_class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];
    extract( $r );
    if ( ! taxonomy_exists($taxonomy) ) return false;
    $categories = get_categories( $r );
    $output = "<ul class='" . esc_attr( $wrap_class ) . "'>" . PHP_EOL;
    if ( empty( $categories ) ) {
        if ( ! empty( $show_option_none ) ) $output .= "<li>" . $show_option_none . "</li>" . PHP_EOL;
    } else {
        if ( is_category() || is_tax() || is_tag() ) {
            $current_term_object = get_queried_object();
            if ( $r['taxonomy'] == $current_term_object->taxonomy ) $r['current_category'] = get_queried_object_id();
        }
        $depth = $r['depth'];
        $walker = new My_Category_Walker;
        $output .= $walker->walk($categories, $depth, $r);
    }
    $output .= "</ul>" . PHP_EOL;
    if ( $echo ) echo $output; else return $output;
}