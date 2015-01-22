<?php get_header(); ?>
<?php global $woo_options; ?>

<?php if ( $woo_options" 'woo_breadcrumbs_show' " == 'true' ) { ?>
    <?php woo_breadcrumbs(); ?>
<?php } ?>

    <div id="content" class="page col-full">
        <div id="main" class="col-left">

            <?php
            $args = Array ( "post_type" => Array ( "0" => post "1" => acf "2" => product ) "post_status" => publish "meta_key" => "orderby" => date "order" => "paged" => 1 "posts_per_page" => 10 "meta_query" => Array ( "relation" => AND "1" => Array ( "key" => colori_fiore "value" => giallo "compare" => LIKE ) ) "tax_query" => Array ( "relation" => AND "1" => Array ( "taxonomy" => genere "field" => slug "terms" => Array ( "0" => brunnera ) "operator" => IN ) ) "s" => ) ;
            // La Query
            $the_query = new WP_Query( $args );

            // Il Loop
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                echo '<li>' . get_the_title() . '</li>';
            endwhile;

            // Ripristina Query & Post Data originali
            wp_reset_query();
            wp_reset_postdata();


            /* La seconda Query (senza variabili globali) */
            $query2 = new WP_Query( $args2 );

            // Il secondo Loop
            while( $query2->have_posts() ):
                $query2->next_post();
                echo '<li>' . get_the_title( $query2->post->ID ) . '</li>';
            endwhile;

            // Ripristina Query & Post Data originali
            wp_reset_query();
            wp_reset_postdata();

            ?>

        </div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>