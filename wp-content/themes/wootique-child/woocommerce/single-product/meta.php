<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', 'woocommerce' ); ?></span>.</span>
	
	<?php endif; ?>

	<?php //echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '.</span>' ); ?>
	<?php /*
	$categorie = $product->get_categories(); 
	$categoria = explode(",",$categorie);
	if($categorie!=""){echo "Appartenenti a: ".last($categoria);}
	//if($categorie!=""){echo "Appartenenti a: ".$categorie;}
	*/
	?>	

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '.</span>' ); ?>
	<?php			
	if(get_field('esposizione')!=""){
		echo "<span class=\"mylabel\">Esposizione : </span>";
		echo "<span class=\"myvalue\">";
		the_field('esposizione');
		echo "</span>";
		echo "<br />";			
	}			
	if(get_field('altezza')!=""){
		echo "<span class=\"mylabel\">Altezza cm : </span>";
		echo "<span class=\"myvalue\">".get_field('altezza')."</span>";
		echo "<br />";			
	}		
	if(get_field('mese_fioritura')!=""){
		echo "<span class=\"mylabel\">Mesi di fioritura : </span>";
		echo "<span class=\"myvalue\">";
		the_field('mese_fioritura');
		echo "</span>";
		echo "<br />";
	}

    $note_terreno = get_field('note_terreno');

    if($note_terreno!=""){
        echo "<span class=\"mylabel\">Terreno: </span>";
        echo "<span class=\"myvalue\">".$note_terreno."</span>";
        echo "<br />";
    }elseif(get_field('terreno')!=""){
        echo "<span class=\"mylabel\">Tipo di terreno : </span>";
        echo "<span class=\"myvalue\">";
        echo ('terreno');
        echo "</span>";
        echo "<br />";
    }

	/*if(get_field('terreno')!=""){
		echo "<span class=\"mylabel\">Tipo di terreno : </span>";
		echo "<span class=\"myvalue\">";
		the_field('terreno');
		echo "</span>";
		echo "<br />";
	}*/

	$colore_fiore_descrizione = get_field('colore_fiore_descrizione');		
	$colori_fiore = tax_val('colori_fiore');
	$stringa = virgole($colori_fiore);
			
	if($colore_fiore_descrizione!=""){
		echo "<span class=\"mylabel\">Colore fiore: </span>";
		echo "<span class=\"myvalue\">".$colore_fiore_descrizione."</span>";				
		echo "<br />";
	}
	elseif($stringa != ""){
		echo "<span class=\"mylabel\">Colore fiore: </span>";
		echo "<span class=\"myvalue\">".$stringa."</span>";				
		echo "<br />";
	}
	
						
			
	$colore_foglie_descrizione = get_field('colore_foglie_descrizione');		
	$colori_foglia = tax_val('colori_foglia');
	$stringa = virgole($colori_foglia);

	if($colore_foglie_descrizione!=""){
		echo "<span class=\"mylabel\">Colore foglia : </span>";
		echo "<span class=\"myvalue\">".$colore_foglie_descrizione."</span>";
		echo "<br />";
	}elseif($stringa!="") {
		echo "<span class=\"mylabel\">Colore foglia : </span>";
		echo "<span class=\"myvalue\">".$stringa."</span>";
		echo "<br />";	
	}		

	if(get_field('densità_mq')!=""){
		echo "<span class=\"mylabel\">Numero esemplari /m² : </span><span class=\"myvalue\">". get_field('densità_mq')."</span>";
		echo "<br />";			
	}				

	if(get_field('annotazioni')!=""){
		echo "<span class=\"mylabel\">Note : </span>";
		echo "<span class=\"myvalue\">".get_field('annotazioni')."</span>";
		echo "<br />";			
	}			

	if(get_field('formato_vaso')!=""){
		echo "<span class=\"mylabel\">Vaso standard: ø cm </span>";
		echo "<span class=\"myvalue\">".get_field('formato_vaso')."</span>";
		echo "<br />";			
	}	

	if(get_field('resistenza_al_freddo')!=""){
		echo "<span class=\"mylabel\">Resistenza al freddo: </span>";
		echo "<span class=\"myvalue\">";
		the_field('resistenza_al_freddo');
		echo "</span>";
		echo "<br />";			
	}

/*			
			
			if(get_field('località')!=""){
				echo "<span class=\"mylabel\">Adatte a giardini di : </span>";
				echo the_field('località');
				echo "<br />";			
			}		
							
			
			if(get_field('fiore_profumato')!=""){
				echo "<span class=\"mylabel\"><img src=\"".esc_url( get_template_directory_uri() . '/images/gorra_check.jpg' )."\" style=\"vertical-align:middle\" />Pianta con fiore profumato</span>";
				echo "<br />";			
			}						


			if(get_field('fiore_reciso')!=""){
				echo "<span class=\"mylabel\"><img src=\"".esc_url( get_template_directory_uri() . '/images/gorra_check.jpg' )."\" style=\"vertical-align:middle\" />Pianta con fiore adatti per composizioni</span>";
				echo "<br />";			
			}			

			if(get_field('composizione_fiori_secchi')!=""){
				echo "<span class=\"mylabel\"><img src=\"".esc_url( get_template_directory_uri() . '/images/gorra_check.jpg' )."\" style=\"vertical-align:middle\" />Pianta adatta per composizioni di fiori secchi</span>";
				echo "<br />";			
			}			

			if(get_field('tappezzanti')!=""){
				echo "<span class=\"mylabel\"><img src=\"".esc_url( get_template_directory_uri() . '/images/gorra_check.jpg' )."\" style=\"vertical-align:middle\" />Pianta tappezzante</span>";
				echo "<br />";			
			}	

*/
			//tappezzanti vf
			//annotazioni text
			//densità_mq text
			//altezza text
			//formato_vaso text

	?>	

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
