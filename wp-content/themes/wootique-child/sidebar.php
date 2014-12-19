<?php
	// Don't display sidebar if full width
	global $woo_options;
	if ( $woo_options[ 'woo_layout' ] != "layout-full" ) :
?>
<div id="sidebar" class="col-right">

	<?php //if ( woo_active_sidebar( 'piante-menu' ) ) :

        if(is_tax()){
            //ho bisogno di sapere in che tipo di tassonomia sono
            //echo "se sono in una categoria<br>";

            global $wp_query;
            $term = $wp_query->get_queried_object();
            //print_r($term);
            if($term->parent > 0 AND $term->term_id!=14 AND $term->term_id!=226)// AND !($term->term_id==14 OR $term->term_id==226))
            {
            // THIS IS A CHILD PAGE
            //inserisco il menù dei fratelli

                $parent_id = $term->parent;
                $termchildren = get_terms( "product_cat", array( 'parent' => $parent_id, 'hide_empty' => true ) );
                /*
                echo "<h3>Generi</h3>";
                echo '<ul id="sidebar_child_page">';
                foreach ( $termchildren as $child ) {
                    echo '<li><a href="' . get_term_link( $child, $taxonomy_name ) . '">' . $child->name . '</a></li>';
                }
                echo '</ul>';
                */
//======================================================
                global $post;
                $prod_terms = get_the_terms( $post->ID, 'product_cat' );

                $taxonomy = 'product_cat';//  e.g. post_tag, category, custom taxonomy
                $param_type = 'product_cat'; //  e.g. tag__in, category__in, but genere__in will NOT work
                $tags="";
                if(isset($post))
                    $tags = wp_get_post_terms( $post->ID , $taxonomy );
                //print_r($tags);

                if ($tags) {?>
                    <!-- h3>Congeneri</h3 -->
                    <ul id="sidebar_single_page"><?
                        $query = new WP_Query( array( 'product_cat' => $tags[0]->slug, 'posts_per_page' => 1000,  'order' => 'ASC' , 'orderby' => 'name',) );
                        if( $query->have_posts() ) {
                            while ($query->have_posts()) : $query->the_post(); ?>
                                <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                                <?php $found_none = '';
                            endwhile;
                        }
                        ?>
                    </ul>
                <?
                }

//======================================================

            }
            else
            {
            // THIS IS THE PARENT PAGE
            //inserisco il menù piante
                ?>
                <div class="primary"  id="sidebar_parent_page">
                    <?php //woo_sidebar( 'primary' ); ?>
                    <?php //wp_nav_menu( array( 'items_wrap' => '<div class="title">Your menu title</div><ul class=\"%2$s\">%3$s</ul>' ) );?>
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'pianteMenu',
                            'container'       => 'div',
                            'items_wrap' => '<div class="title"><h3>Tutte le piante</h3></div><ul id="%1$s" class="%2$s">%3$s</ul>'
                        ));?>
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'carrelloMenu',
                            'container' => '',
                            'items_wrap' => '<div class="title"><h3>Il negozio</h3></div><ul id="%1$s" class="%2$s">%3$s</ul>'
                        ));?>
                </div>
            <?php
            }
            //$title = $term->name;
        }elseif(is_single()){
                //echo "se sono in una pagina singola<br>";

                global $post;
                $prod_terms = get_the_terms( $post->ID, 'product_cat' );
                //print_r($prod_terms);

                //$backup = $post;  // backup the current object
                $taxonomy = 'product_cat';//  e.g. post_tag, category, custom taxonomy
                $param_type = 'product_cat'; //  e.g. tag__in, category__in, but genere__in will NOT work
                $tags="";
                $args = array('orderby' => 'slug');
                if(isset($post))
                    $tags = wp_get_post_terms( $post->ID , $taxonomy , $args);
                //print_r($tags);

                if ($tags) {?>
                    <!-- h3>Congeneri</h3 -->
                    <ul id="sidebar_single_page"><?
                $query = new WP_Query( array( 'product_cat' => $tags[0]->slug, 'posts_per_page' => 1000,  'order' => 'ASC' ) );
                    if( $query->have_posts() ) {
                      while ($query->have_posts()) : $query->the_post(); ?>
                        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                        <?php $found_none = '';
                      endwhile;
                    }
                ?>
                    </ul>
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'carrelloMenu',
                            'container' => '',
                            'items_wrap' => '<div class="title"><h3>Il negozio</h3></div><ul id="%1$s" class="%2$s">%3$s</ul>'
                        ));?>
                <?
                }
        }else{ ?>
		<div class="primary">
			<?php //woo_sidebar( 'primary' ); ?>
            <?php wp_nav_menu(array('theme_location' => 'carrelloMenu','container' => '',));?>
		</div>        
		<?php 
}
	endif;?>    
	
</div><!-- /#sidebar -->
<?php //endif; ?>