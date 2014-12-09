<?php
/**
 * Single Product category
 *
 * @author 		Federico Porta
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

//echo $post->ID. " " . $product->id; // sono uguali
 
$product_cats = get_the_terms( $product->id, 'product_cat');
$product_cat = get_last_array($product_cats);//tira fuori un ID
$link = get_term_link( $product_cat, 'product_cat' );

$term = get_term( get_last_array($product_cats), 'product_cat' );
$name = $term->name; 

//$taxonomy = 'genere';//  e.g. post_tag, category, custom taxonomy
$param_type = 'genere'; //  e.g. tag__in, category__in, but genere__in will NOT work
$tags = wp_get_post_terms( $product->id , 'genere');


$generi = get_the_terms( $product->id, 'genere');
if(is_array($generi)){
$genere = get_last_array($generi);//tira fuori un ID
$genere_link = get_term_link( $genere, 'genere' );

//print_r($genere_link);
//print_r($tags);
echo '<div class="genere"><b><a href="'.$genere_link.'">'.$tags[0]->name. "</a></b>,</div>";
echo "<div  class=\"famiglia\">famiglia: <b class=\"famiglia\"><a href=\"".$link."\">".$name."</a></b></div>";

$terms = wp_get_post_terms($product->id, "genere" );

	//print_r($terms);
    if($terms){
        echo "<div class=\"descrizione_genere\">".$terms[0]->description."</div>";
    }
}

//echo $product->get_categories( ', ', '<span class="posted_in">' . _n( '', '', $cat_count, 'woocommerce' ) . ' ', '.</span>' ); 