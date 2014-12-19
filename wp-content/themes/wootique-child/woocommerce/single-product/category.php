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

$param_type = 'genere'; //  e.g. tag__in, category__in, but genere__in will NOT work
$tags = wp_get_post_terms( $product->id , 'genere');


$generi = get_the_terms( $product->id, 'genere');


/*====================================*/
global $post;
$prod_terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($prod_terms as $prod_term) {

    $product_cat_id = $prod_term->term_id;
    $term = get_term($product_cat_id, "product_cat" );

    $product_categories_all_hierachy = get_tax_and_ancestors( $product_cat_id, 'product_cat' );


    foreach($product_categories_all_hierachy as $product_category){
        $this_term = get_term($product_category, "product_cat" );
        $variable = get_field('tiplogia_categoria', $this_term);
        if($variable=="genere"){
            $link = get_term_link( $this_term, 'product_cat' );
            echo '<div class="genere"><b><a href="'.$link.'">'.$this_term->name. "</a></b></div> ";
        }
    }
    foreach($product_categories_all_hierachy as $product_category){
        $this_term = get_term($product_category, "product_cat" );
        $variable = get_field('tiplogia_categoria', $this_term);
        if($variable=="descrittore_generico"){
            $link = get_term_link( $this_term, 'product_cat' );
            echo " <div  class=\"descrittore_generico\"><b class=\"descrittore_generico\"><a href=\"".$link."\">".$this_term->name."</a></b></div> ";
        }
    }
    foreach($product_categories_all_hierachy as $product_category){
        $this_term = get_term($product_category, "product_cat" );
        $variable = get_field('tiplogia_categoria', $this_term);
        if($variable=="descrittore_generico_figlio"){
            $link = get_term_link( $this_term, 'product_cat' );
            echo " <div  class=\"descrittore_generico_figlio\"><b class=\"descrittore_generico_figlio\"><a href=\"".$link."\">".$this_term->name."</a></b></div> ";
        }
    }
    foreach($product_categories_all_hierachy as $product_category){
        $this_term = get_term($product_category, "product_cat" );
        $variable = get_field('tiplogia_categoria', $this_term);
        if($variable=="famiglia"){
            $link = get_term_link( $this_term, 'product_cat' );
            echo "<div  class=\"famiglia\">Famiglia: <b class=\"famiglia\"><a href=\"".$link."\">".$this_term->name."</a></b></div> ";
        }
    }


    foreach($product_categories_all_hierachy as $product_category){
        $this_term = get_term($product_category, "product_cat" );
        $variable = get_field('tiplogia_categoria', $this_term);
        if($variable=="genere"){
            $link = get_term_link( $this_term, 'product_cat' );
            echo "<div class=\"descrizione_genere\">".$this_term->description."</div> ";
        }
    }


}

