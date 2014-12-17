<?php
/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/
//aggiunto menu 
function register_gorra_menus() {
	register_nav_menus(
		array(
            'categoriesMenu' => 'Menu Genere',
            'pianteMenu' => 'Piante Menu',
            'carrelloMenu' => 'Carrello Menu'

        )
	);
}
add_action( 'init', 'register_gorra_menus' );

//classe body custom per colori della pagina
// add category nicenames in body class
/*
function category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes[] = $category->category_nicename;
	return $classes;
}

add_filter('body_class', 'collezione_perenni');
*/
//se gli utenti logati siamo io o simone allora accendo il debug
get_currentuserinfo();
$tcu=$current_user->data->ID;
/*if($tcu == 1 OR $tcu == 3){

	 // Enable WP_DEBUG mode
	define('WP_DEBUG', true);

	// Enable Debug logging to the /wp-content/debug.log file
	define('WP_DEBUG_LOG', true);

	// Disable display of errors and warnings 
	//define('WP_DEBUG_DISPLAY', false);
	@ini_set('display_errors',0);

	// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
	define('SCRIPT_DEBUG', true);
}*/

//==============================fungo ,funzioni copiate da meta.php (simone)
function tax_val($tax_name){
	$terms = get_field($tax_name);	
	//print_r($terms);
	if(is_array($terms)){
		foreach ($terms as $term){
			$tax_caracteristcs[] = get_term( $term, $tax_name);
		}
		foreach($tax_caracteristcs as $tax_caracteristc){
			$val[] = $tax_caracteristc->name;
		}	
		return $val;
	}else{
		return false;
	}
	
}

function virgole($my_arr){
	$stringa='';
	$i=0;
	if(is_array($my_arr)){
		foreach($my_arr as $s_arr){
			$i++;
			if($i<=1){
				$stringa = $s_arr;
			}else{
				$stringa = $s_arr.", ".$stringa;
			}
		}
		return $stringa;
	}else{
		return "";
	}
	
}

function vf($val){
	//fiore_profumato vf
	//fiore_reciso vf
	//composizione_fiori_secchi vf
	//ibrido vf
	if($val){
		if(get_field($val)){	
			echo str_replace("_"," ",$val); 
		}
	}
	
}
function last($val){
    $stringa = $val[(count($val)-1)];
	return $stringa;
}

/////////// simo ////////////////

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
 
function woo_custom_cart_button_text() {
 
        return __( 'Aggiungi al carrello', 'woocommerce' );
 
}

add_filter( 'add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // < 2.1
 
function woo_archive_custom_cart_button_text() {
 
        return __( 'Aggiungi al carrello', 'woocommerce' );
 
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 40 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 40 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10 );


//visualizzo l'immagine della categoria
add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        if ( $image ) {
            echo '<img src="' . $image . '" alt="" width="100%" />';
        }
    }
}

// determine the topmost parent of a term
function get_term_top_most_parent($term_id, $taxonomy){
    // start from the current term
    $parent  = get_term_by( 'id', $term_id, $taxonomy);
    // climb up the hierarchy until we reach a term with parent = '0'
    while ($parent->parent != '0'){
        $term_id = $parent->parent;

        $parent  = get_term_by( 'id', $term_id, $taxonomy);
    }
    return $parent;
}

// so once you have this function you can just loop over the results returned by wp_get_object_terms
function hey_top_parents($taxonomy, $results = 1) {
    // get terms for current post
    $terms = wp_get_object_terms( get_the_ID(), $taxonomy );
    // set vars
    $top_parent_terms = array();
    foreach ( $terms as $term ) {
        //get top level parent
        $top_parent = get_term_top_most_parent( $term->term_id, $taxonomy );
        //check if you have it in your array to only add it once
        if ( !in_array( $top_parent, $top_parent_terms ) ) {
            $top_parent_terms[] = $top_parent;
        }
    }
    // build output (the HTML is up to you)


    foreach ( $top_parent_terms as $term ) {

        $r = '<ul>';
        $r .= '<li><a href="'. get_term_link( $term->slug, $taxonomy ) . '">' . $term->name . '</a></li>';
    }
    $r .= '</ul>';

    // return the results
    return $r;

}

// return an array of all the parents
function get_term_all_parents($term_id, $post_id, $taxonomy){
    global $post;
    // start from the current term
    $parent  = get_term_by( 'id', $term_id, $taxonomy);
    // climb up the hierarchy until we reach a term with parent = '0'

    $product_cats = get_the_terms($post_id, 'product_cat');
    //print_r($product_cats);
    $my_parent = "";
    foreach($product_cats as $product_cat){
        $my_parent  = $my_parent  ." ". $product_cat->slug;
    }

    $i=0;
    while ($parent->parent != '0'){
        $term_id = $parent->parent;

        $parent  = get_term_by( 'id', $term_id, $taxonomy);
        $my_parent = $my_parent." ".$parent->slug;
        $i++;
        if($i>=10){return $my_parent;}
    }
    return $my_parent;
}



add_action( 'woocommerce_after_order_notes', 'wordimpress_custom_checkout_field' );

function wordimpress_custom_checkout_field( $checkout ) {

        echo '<div id="my_custom_checkout_field">
            <h3>' . __( 'Proposta in caso di piante mancanti' ) . '</h3>
            <p style="margin: 0 0 8px;">Gradisci una proposta diversa nel caso in cui una o alcune delle piante che hai ordinato non siano disponibili?</p>';

        woocommerce_form_field( 'inscription_checkbox', array(
            'type'  => 'checkbox',
            'class' => array( 'inscription-checkbox form-row-wide' ),
            'label' => __( 'Yes' ),
        ), $checkout->get_value( 'inscription_checkbox' ) );


        echo '</div>';


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

/*

function wptt_cat_order( $args ){

    $args['orderby'] = 'slug';
    $args['order'] = 'DESC';
    $args['child_of'] = '2';
    $args['menu_order']   = 'ASC';
    $args['hide_empty']   = '0';
    $args['hierarchical'] = '2';
    $args['taxonomy']     = 'product_cat';
    $args['pad_counts']   = '1';
    return $args;

} // wptt_cat_order
add_filter( 'woocommerce_product_subcategories_args', 'wptt_cat_order' );
*/
/*
            'parent'       => $parent_id,
            'child_of'     => 2,
            'menu_order'   => 'ASC',
            'hide_empty'   => 0,
            'hierarchical' => 2,
            'taxonomy'     => 'product_cat',
            'pad_counts'   => 1
*/

//http://wpthemetutorial.com/2014/03/20/change-product-category-order-woocommerce/ -> scrivi ci un articolo sopra


//Add Alphabetical sorting option to shop page / WC Product Settings
/*
function sv_alphabetical_woocommerce_shop_ordering( $sort_args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    //if ( 'alphabetical' == $orderby_value ) {
        $sort_args['orderby'] = 'slug';
        $sort_args['order'] = 'ASC';
        $sort_args['meta_key'] = '';
    //}

    return $sort_args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'sv_alphabetical_woocommerce_shop_ordering' );
*/
/*
function sv_custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['alphabetical'] = 'Sort by name: alphabetical';
    return $sortby;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'sv_custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'sv_custom_woocommerce_catalog_orderby' );
*/
/*
add_filter( 'woocommerce_get_catalog_ordering_args','custom_query_sort_args' );
function custom_query_sort_args() {
// Sort by and order
    $current_order = ( isset( $_SESSION['orderby'] ) ) ? $_SESSION['orderby'] : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    echo "order -> ".$current_order;
    switch ( $current_order ) {
        case 'date' :
            $orderby = 'date';
            $order = 'desc';
            $meta_key = '';
            break;
        case 'price' :
            $orderby = 'meta_value_num';
            $order = 'asc';
            $meta_key = '_price';
            break;
        case 'title' :
            $orderby = 'meta_value';
            $order = 'asc';
            $meta_key = '_woocommerce_product_short_title';
            break;
        default :
            $orderby = 'menu_order title';
            $order = 'asc';
            $meta_key = '';
            break;
    }
    $args = array();
    //$orderby="slug";
    $args['orderby'] = $orderby;
    $args['order'] = $order;
    if ($meta_key) :
        $args['meta_key'] = $meta_key;
    endif;
    return $args;
}*/

//Add Alphabetical sorting option to shop page / WC Product Settings
/*
function sv_alphabetical_woocommerce_shop_ordering( $sort_args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'alphabetical' == $orderby_value ) {
        $sort_args['orderby'] = 'slug';
        $sort_args['order'] = 'asc';
        $sort_args['meta_key'] = '';
    }

    return $sort_args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'sv_alphabetical_woocommerce_shop_ordering' );

function sv_custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['slug'] = 'Ordinamento alfabetico per: slug';
    return $sortby;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'sv_custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'sv_custom_woocommerce_catalog_orderby' );
*/

/*
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'random_list' == $orderby_value ) {
        $args['orderby'] = 'rand';
        $args['order'] = '';
        $args['meta_key'] = '';
    }
    return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['random_list'] = 'Random';
    return $sortby;
}
*/

add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'slug_list' == $orderby_value ) {
        $args['orderby'] = 'slug';
        $args['order'] = 'ASC';
        $args['meta_key'] = '';
    }
    return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['slug_list'] = 'Ordina alfabeticamente';
    return $sortby;
}



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
