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

//$my_term = get_term(get_last_array($product_cats), 'product_cat' );
//print_r($my_term );

$term = get_term( get_last_array($product_cats), 'product_cat' );
$name = $term->name;

//$taxonomy = 'genere';//  e.g. post_tag, category, custom taxonomy
$param_type = 'genere'; //  e.g. tag__in, category__in, but genere__in will NOT work
$tags = wp_get_post_terms( $product->id , 'genere');


$generi = get_the_terms( $product->id, 'genere');
/*
if(is_array($generi)){
$genere = get_last_array($generi);//tira fuori un ID
$genere_link = get_term_link( $genere, 'genere' );

//print_r($genere_link);
//print_r($tags);
//echo '<div class="genere"><b><a href="'.$genere_link.'">'.$tags[0]->name. "</a></b>,</div>";
//echo "<div  class=\"famiglia\">famiglia: <b class=\"famiglia\"><a href=\"".$link."\">".$name."</a></b></div>";

$terms = wp_get_post_terms($product->id, "genere" );

	//print_r($terms);
    if($terms){
        echo "<div class=\"descrizione_genere\">".$terms[0]->description."</div>";
    }
}
*/


/*====================================*/
global $post;
$prod_terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($prod_terms as $prod_term) {

    // gets product cat id
    $product_cat_id = $prod_term->term_id;
    $term = get_term($product_cat_id, "product_cat" );


    // gets an array of all parent category levels
    $product_categories_all_hierachy = get_tax_and_ancestors( $product_cat_id, 'product_cat' );
    //print_r($product_parent_categories_all_hierachy);


    foreach($product_categories_all_hierachy as $product_category){
        //echo "product_parent_category";print_r($product_parent_category);
        //$terms[] = get_term($product_category, "product_cat" );
        $this_term = get_term($product_category, "product_cat" );
        $variable = get_field('tiplogia_categoria', $this_term);
        if($variable=="genere"){
            $link = get_term_link( $this_term, 'product_cat' );
            //print_r($terms);
            echo '<div class="genere"><b><a href="'.$link.'">'.$this_term->name. "</a></b></div> ";
            //echo $variable."<br>";
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
            //echo $this_term->name."<br>";
            //echo $variable."<br>";
            echo "<div  class=\"famiglia\">famiglia: <b class=\"famiglia\"><a href=\"".$link."\">".$this_term->name."</a></b></div> ";
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
    //print_r($terms);
    // This cuts the array and extracts the last set in the array
    /*$last_parent_cat = array_slice($product_parent_categories_all_hierachy, -1, 1, true);
    foreach($last_parent_cat as $last_parent_cat_value){
        // $last_parent_cat_value is the id of the most top level category, can be use whichever one like
        echo '<strong>' . $last_parent_cat_value . '</strong>';
    }*/

}



//echo '<div class="genere"><b><a href="'."".'">'.$term->name. "</a></b>,</div>";
//echo "<div  class=\"famiglia\">famiglia: <b class=\"famiglia\"><a href=\"".$link."\">".$terms->name."</a></b></div>";
/*====================================*/

//echo $product->get_categories( ', ', '<span class="posted_in">' . _n( '', '', $cat_count, 'woocommerce' ) . ' ', '.</span>' );



