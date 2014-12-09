<?php
/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/
//aggiunto menu 
function register_my_menus() {
	register_nav_menus(
		array('categoriesMenu' => 'Menu Genere' )
	);
}
add_action( 'init', 'register_my_menus' );

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
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 50 );